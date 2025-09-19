<?php

namespace App\Livewire\Hotel;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\Booking;
use Livewire\Component;
use App\Models\RoomType;
use Illuminate\Support\Facades\Auth;

class HotelDetails extends Component
{
    public $hotel, $check_in_date, $check_out_date, $hotel_id, $room_id, $total_price, $description, $room_description, $guest_name, $guest_email, $guest_phone, $selected_room, $user_id;

    public function updatedRoomId($value)
    {
        $this->calculateTotalPrice();
        $room = Room::with('room_type')->find($value);
        $this->selected_room = Room::with('room_type')->find($value);
        $this->room_description = $this->selected_room?->room_type?->description ?? '';
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

    public function mount($id)
    {
        $this->hotel = Hotel::findOrFail($id);
        $this->hotel_id = $id;
        $this->check_in_date = request()->query('check_in_date', now()->toDateString());
        $this->check_out_date = request()->query('check_out_date', now()->addDay()->toDateString());
    }

    public function setRoomId($roomId)
    {
        $this->room_id = $roomId;
        $this->bookingNow(); // Langsung panggil bookingNow setelah room_id diatur
    }

    public function bookingNow()
    {
        $this->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'room_description' => 'required|exists:room_types,description',
            'total_price' => 'required|numeric',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|string|max:100',
            'guest_phone' => 'required|numeric|max_digits:15',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'hotel_id' => $this->hotel_id,
            'room_id' => $this->room_id,
            'check_in_date' => $this->check_in_date,
            'check_out_date' => $this->check_out_date,
            'room_description' => $this->room_description,
            'total_price' => $this->total_price,
            'guest_name' => $this->guest_name,
            'guest_email' => $this->guest_email,
            'guest_phone' => $this->guest_phone,
        ]);

        session()->flash('success', 'Data successfully added, please check booking menu!');
        return $this->redirect('/', navigate: true);
    }

    public function render()
    {
        return view('livewire.hotel.hotel-details', [
            'hotels' => Hotel::all(),
            'rooms' => Room::with('room_type')
                ->where('hotel_id', $this->hotel_id)
                ->orderByRaw("CASE WHEN status = 'available' THEN 1 ELSE 2 END")
                ->get(),
            'room_types' => RoomType::all()
        ]);
    }
}
