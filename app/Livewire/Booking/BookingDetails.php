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
        $booking = Booking::findOrFail($id);

        // bikin order_id unik
        $orderId = 'BOOK-' . $booking->id . '-' . time();

        // buat Snap token lewat service
        $midtrans = new MidtransService();
        $snapToken = $midtrans->createTransaction($booking, $orderId);

        // simpan ke payments
        Payment::create([
            'booking_id'   => $booking->id,
            'order_id'     => $orderId,
            'gross_amount' => $booking->total_price,
            'transaction_status' => 'pending',
        ]);

        // kirim ke frontend buat popup Snap
        $this->dispatch('midtrans:pay', snapToken: $snapToken);
    }


    public function delete($id)
    {
        $booking = Booking::find($id);
        $booking->delete();

        session()->flash('success', 'Data successfully deleted!');
        return $this->redirect('/');
    }

    public function render()
    {
        $query = Booking::query();

        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::id())
                ->latest();
        }

        return view('livewire.booking.booking-details', [
            'bookings' => $query->paginate(5),
        ]);
    }
}
