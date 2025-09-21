<?php

namespace App\Livewire\Booking;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Room;
use Livewire\Component;

class BookingEdit extends Component
{
    public $hotel_id, $room_id, $check_in_date, $check_out_date, $total_price, $status, $guest_name, $guest_email, $guest_phone, $booking_details;
    public $filteredRooms = [];

    public function updatedHotelId($value)
    {
        $this->room_id = null;
        $this->filteredRooms = Room::where('hotel_id', $value)->get();
    }

    public function mount($id)
    {
        $this->booking_details = Booking::findOrFail($id);
        $this->hotel_id = $this->booking_details->hotel_id;
        $this->room_id = $this->booking_details->room_id;
        $this->filteredRooms = Room::where('hotel_id', $this->hotel_id)->get();
        $this->check_in_date = $this->booking_details->check_in_date;
        $this->check_out_date = $this->booking_details->check_out_date;
        $this->total_price = $this->booking_details->total_price;
        $this->status = $this->booking_details->status;
        $this->guest_name = $this->booking_details->guest_name;
        $this->guest_email = $this->booking_details->guest_email;
        $this->guest_phone = $this->booking_details->guest_phone;
    }

    public function update()
    {
        //validate
        $this->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'total_price' => 'required|numeric',
            'status' => 'required|in:pending,complete,canceled',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max_digits:15',
        ]);

        $this->booking_details->update([
            'hotel_id' => $this->hotel_id,
            'room_id' => $this->room_id,
            'check_in_date' => $this->check_in_date,
            'check_out_date' => $this->check_out_date,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'guest_name' => $this->guest_name,
            'guest_email' => $this->guest_email,
            'guest_phone' => $this->guest_phone,
        ]);

        request()->session()->flash('success', 'Data success updated!');
        return $this->redirect('/bookingList');
    }

    public function render()
    {
        return view('livewire.booking.booking-edit', [
            'hotels' => Hotel::all(),
            'rooms' => $this->filteredRooms
        ]);
    }
}
