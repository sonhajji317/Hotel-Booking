<?php

namespace App\Livewire\Booking;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomType;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class BookingList extends Component
{
    use WithPagination;

    public $booking_details, $search, $order_id;
    public $sortField = 'created_at'; // Better default sort
    public $sortDirection = 'desc';   // Show newest first

    // Reset pagination when search changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
        $this->resetPage(); // Reset pagination on sort
    }

    public function delete($id)
    {
        // OPTIMIZED: Only load booking without unnecessary relations for delete
        $booking = Booking::findOrFail($id);

        // OPTIMIZED: Authorization check
        if (!Auth::user()->is_admin && $booking->user_id !== Auth::id()) {
            session()->flash('error', 'Unauthorized action!');
            return;
        }

        // OPTIMIZED: Delete related payments first (if no cascade delete)
        Payment::where('booking_id', $id)->delete();

        $booking->delete();
        session()->flash('success', 'Booking deleted successfully.');

        // Don't redirect, just refresh the component
        $this->dispatch('$refresh');
    }

    public function render()
    {
        // OPTIMIZED: Build efficient query with proper eager loading
        $bookingsQuery = Booking::with([
            'hotel:id,name,address,city',
            'room:id,hotel_id,room_type_id,room_number',
            'room.room_type:id,name,price',
            'user:id,name,email',
            'payment:id,booking_id,order_id,transaction_status,gross_amount'
        ]);

        // OPTIMIZED: Apply user filter for non-admin users
        if (!Auth::user()->is_admin) {
            $bookingsQuery->where('user_id', Auth::id());
        }

        // OPTIMIZED: Enhanced search functionality
        if ($this->search) {
            $bookingsQuery->where(function ($query) {
                $query->where('guest_name', 'like', '%' . $this->search . '%')
                    ->orWhere('guest_email', 'like', '%' . $this->search . '%')
                    ->orWhere('guest_phone', 'like', '%' . $this->search . '%')
                    ->orWhereHas('hotel', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('payment', function ($q) {
                        $q->where('order_id', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // OPTIMIZED: Handle different sort fields properly
        switch ($this->sortField) {
            case 'hotel_name':
                $bookingsQuery->join('hotels', 'bookings.hotel_id', '=', 'hotels.id')
                    ->orderBy('hotels.name', $this->sortDirection)
                    ->select('bookings.*'); // Ensure we select booking fields
                break;
            case 'room_number':
                $bookingsQuery->join('rooms', 'bookings.room_id', '=', 'rooms.id')
                    ->orderBy('rooms.room_number', $this->sortDirection)
                    ->select('bookings.*');
                break;
            case 'guest_name':
                $bookingsQuery->orderBy('guest_name', $this->sortDirection);
                break;
            case 'total_price':
                $bookingsQuery->orderBy('total_price', $this->sortDirection);
                break;
            case 'status':
                $bookingsQuery->orderBy('status', $this->sortDirection);
                break;
            default:
                $bookingsQuery->orderBy($this->sortField, $this->sortDirection);
        }

        return view('livewire.booking.booking-list', [
            'bookings' => $bookingsQuery->paginate(10),

            // OPTIMIZED: Remove unused data - only load if actually used in view
            // Comment out if not used in the Blade template:
            // 'room_types' => RoomType::select(['id', 'name', 'price'])->get(),
            // 'payments' => Payment::select(['id', 'order_id', 'transaction_status'])->get(),
            // 'rooms' => Room::select(['id', 'room_number', 'hotel_id'])->get(),
        ]);
    }
}
