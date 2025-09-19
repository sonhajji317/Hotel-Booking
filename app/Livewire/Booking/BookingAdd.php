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

    // Cache room data to avoid repeated queries
    private $roomCache = null;

    public function updatedHotelId($value)
    {
        $this->room_id = null; //reset room selection
        $this->roomCache = null; // Clear cache

        if ($value) {
            // OPTIMIZED: Load rooms with their room_type in one query
            $this->filteredRooms = Room::with(['room_type', 'hotel'])
                ->where('hotel_id', $value)
                ->get();
        } else {
            $this->filteredRooms = [];
        }
    }

    public function updatedRoomId($value)
    {
        $this->calculateTotalPrice();

        if ($value) {
            // OPTIMIZED: Use cached room or load with eager loading
            if (!$this->roomCache || $this->roomCache->id != $value) {
                $this->roomCache = Room::with(['room_type', 'hotel'])->find($value);
            }
            $this->description = $this->roomCache ? $this->roomCache->room_type->description : '';
        } else {
            $this->description = '';
            $this->roomCache = null;
        }
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
            // OPTIMIZED: Use cached room or load with room_type
            if (!$this->roomCache || $this->roomCache->id != $this->room_id) {
                $this->roomCache = Room::with('room_type')->find($this->room_id);
            }

            if ($this->roomCache && $this->roomCache->room_type) {
                $days = $this->getDays();
                $this->total_price = $this->roomCache->room_type->price * $days;
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

        // OPTIMIZED: Add user_id if authenticated (your model expects it)
        $bookingData = [
            'hotel_id' => $this->hotel_id,
            'room_id' => $this->room_id,
            'check_in_date' => $this->check_in_date,
            'check_out_date' => $this->check_out_date,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'guest_name' => $this->guest_name,
            'guest_email' => $this->guest_email,
            'guest_phone' => $this->guest_phone,
        ];

        // Add user_id if user is authenticated
        if (Auth::check()) {
            $bookingData['user_id'] = Auth::id();
        }

        Booking::create($bookingData);

        request()->session()->flash('success', 'Data success added!');
        //redirect
        return $this->redirect('/bookingList');
    }

    public function render()
    {
        // OPTIMIZED: Remove unnecessary eager loading in render method
        // Only load what you actually need for the view
        return view('livewire.booking.booking-add', [
            // Remove 'bookings' if not used in the view - this was loading ALL bookings unnecessarily
            'hotels' => Hotel::select(['id', 'name', 'address', 'city'])->get(), // Only select needed columns
            'rooms' => $this->filteredRooms, // Already optimized above
        ]);
    }
}
