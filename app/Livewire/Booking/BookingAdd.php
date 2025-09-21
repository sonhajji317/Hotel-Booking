<?php

namespace App\Livewire\Booking;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\Booking;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class BookingAdd extends Component
{
    public $hotel_id, $room_id, $check_in_date, $check_out_date, $total_price, $status, $guest_name, $guest_email, $guest_phone, $description;
    public $filteredRooms = [];

    public function updatedHotelId($value)
    {
        $this->room_id = null; //reset room selection
        if ($value) {
            $this->filteredRooms = Room::with('room_types', 'hotel')->where('hotel_id', $value)->get();
        } else {
            $this->filteredRooms = [];
        }
    }

    public function updatedRoomId($value)
    {
        $this->calculateTotalPrice();
        $room = Room::with('room_type', 'hotel')->find($value);
        $this->description = $room ? $room->room_type->description : '';
    }

    public function updatedCheckInDate()
    {
        $this->calculateTotalPrice();
    }

    public function updatedCheckOutDate()
    {
        $this->calculateTotalPrice();
    }

    public function getDays()
    {
        if ($this->check_in_date && $this->check_out_date) {
            $checkIn = Carbon::parse($this->check_in_date);
            $checkOut = Carbon::parse($this->check_out_date);
            return $checkIn->diffInDays($checkOut);
        } else {
            return 0;
        }
    }

    public function calculateTotalPrice()
    {
        if ($this->room_id && $this->check_in_date && $this->check_out_date) {
            $room = Room::find($this->room_id);
            if ($room) {
                $days = $this->getDays();
                $this->total_price = $room->room_type->price * $days;
            }
        } else {
            $this->total_price = 0;
        }
    }


    public function save()
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
            'guest_email' => 'required|string|email|max:255',
            'guest_phone' => 'required|string|max_digits:15',
        ]);

        //kirim data
        Booking::create([
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

        request()->session()->flash('success', 'Data success added!');
        //redirect
        return $this->redirect('/bookingList');
    }

    public function render()
    {
        return view('livewire.booking.booking-add', [
            'bookings' => Booking::with('room', 'room_type', 'hotel')->all(),
            'hotels' => Hotel::with('bookings', 'room_types')->all(),
            'rooms' => $this->filteredRooms,
        ]);
    }
}
