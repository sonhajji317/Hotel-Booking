<?php

namespace App\Livewire\Booking;

use App\Models\Booking;
use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Auth;

class BookingDetails extends Component
{
    use WithPagination;

    protected $listeners = ['refreshBookings' => '$refresh'];

    public function pay($id)
    {
        // OPTIMIZED: Load all needed relationships in one query
        $booking = Booking::with([
            'room.room_type',  // Fixed: room_type is accessed through room, not directly
            'hotel',
            'user'  // Added user relationship in case needed
        ])->findOrFail($id);

        // bikin order_id unik
        $orderId = 'BOOK-' . $booking->id . '-' . time();

        // buat Snap token lewat service
        $midtrans = new MidtransService();
        $snapToken = $midtrans->createTransaction($booking, $orderId);

        // OPTIMIZED: Check if payment already exists to avoid duplicates
        $existingPayment = Payment::where('booking_id', $booking->id)
            ->where('transaction_status', 'pending')
            ->first();

        if (!$existingPayment) {
            // simpan ke payments
            Payment::create([
                'booking_id'   => $booking->id,
                'order_id'     => $orderId,
                'gross_amount' => $booking->total_price,
                'transaction_status' => 'pending',
            ]);
        }

        // kirim ke frontend buat popup Snap
        $this->dispatch('midtrans:pay', snapToken: $snapToken);
    }

    public function delete($id)
    {
        // OPTIMIZED: Only load if needed, or remove eager loading if not used in delete logic
        $booking = Booking::findOrFail($id);

        // OPTIMIZED: Check authorization before deletion
        if (!Auth::user()->is_admin && $booking->user_id !== Auth::id()) {
            session()->flash('error', 'Unauthorized action!');
            return;
        }

        // OPTIMIZED: Delete related payments first (if cascade delete not set)
        Payment::where('booking_id', $id)->delete();

        $booking->delete();

        session()->flash('success', 'Data successfully deleted!');
        return $this->redirect('/');
    }

    public function render()
    {
        // OPTIMIZED: Build query with eager loading for all needed relationships
        $query = Booking::with([
            'hotel:id,name,address,city',           // Only select needed hotel columns
            'room:id,hotel_id,room_type_id,room_number',  // Only needed room columns  
            'room.room_type:id,name,price',         // Room type through room
            'user:id,name,email',                   // Only needed user columns
            'payment:id,booking_id,transaction_status,gross_amount' // Payment info
        ]);

        // OPTIMIZED: Add user filter efficiently
        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::id());
        }

        // OPTIMIZED: Order by latest first for better UX
        $query->orderBy('created_at', 'desc');

        return view('livewire.booking.booking-details', [
            'bookings' => $query->paginate(5),
        ]);
    }
}
