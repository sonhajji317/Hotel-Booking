<?php

namespace App\Livewire\Booking;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\RoomType;
use Livewire\Component;
use Livewire\WithPagination;

class BookingList extends Component
{
    use WithPagination;

    public $booking_details, $search, $order_id;
    public $sortField = 'hotel_id';
    public $sortDirection = 'asc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function delete($id)
    {
        $this->booking_details = Booking::with(['hotel', 'room', 'room_type'])->find($id);
        $this->booking_details->delete();
        session()->flash('success', 'Booking deleted successfully.');
        return $this->redirect('/bookingList');
    }

    public function render()
    {
        return view('livewire.booking.booking-list', [
            'room_types' => RoomType::all(),
            'payments' => Payment::all(),
            'rooms' => Room::all(),
            'bookings' => Booking::with('payment')
                ->when($this->search, function ($query) {
                    $query->whereHas('payment', function ($q) {
                        $q->where('order_id', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10),
        ]);
    }
}
