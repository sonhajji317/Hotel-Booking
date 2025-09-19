<?php

namespace App\Livewire\Booking;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Room;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class BookingEdit extends Component
{
    public $hotel_id, $room_id, $check_in_date, $check_out_date, $total_price, $status, $guest_name, $guest_email, $guest_phone, $booking_details;
    public $filteredRooms = [];

    public function updatedHotelId($value)
    {
        $this->room_id = null;

        if ($value) {
            // OPTIMIZED: Load rooms with room_type for better UX
            $this->filteredRooms = Room::with('room_type')
                ->where('hotel_id', $value)
                ->select(['id', 'hotel_id', 'room_type_id', 'room_number', 'status'])
                ->get();
        } else {
            $this->filteredRooms = [];
        }
    }

    public function mount($id)
    {
        // OPTIMIZED: Load booking with all needed relationships in one query
        $this->booking_details = Booking::with([
            'hotel:id,name',
            'room:id,hotel_id,room_type_id,room_number',
            'room.room_type:id,name,price',
            'user:id,name' // In case needed for authorization
        ])->findOrFail($id);

        // OPTIMIZED: Authorization check
        if (!Auth::user()->is_admin && $this->booking_details->user_id !== Auth::id()) {
            session()->flash('error', 'Unauthorized access!');
            return redirect('/bookingList');
        }

        // Populate form fields
        $this->hotel_id = $this->booking_details->hotel_id;
        $this->room_id = $this->booking_details->room_id;
        $this->check_in_date = $this->booking_details->check_in_date;
        $this->check_out_date = $this->booking_details->check_out_date;
        $this->total_price = $this->booking_details->total_price;
        $this->status = $this->booking_details->status;
        $this->guest_name = $this->booking_details->guest_name;
        $this->guest_email = $this->booking_details->guest_email;
        $this->guest_phone = $this->booking_details->guest_phone;

        // OPTIMIZED: Load filtered rooms with room_type info
        $this->filteredRooms = Room::with('room_type')
            ->where('hotel_id', $this->hotel_id)
            ->select(['id', 'hotel_id', 'room_type_id', 'room_number', 'status'])
            ->get();
    }

    public function update()
    {
        // OPTIMIZED: Additional authorization check before update
        if (!Auth::user()->is_admin && $this->booking_details->user_id !== Auth::id()) {
            session()->flash('error', 'Unauthorized action!');
            return;
        }

        //validate
        $this->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,complete,canceled',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max_digits:15',
        ]);

        // OPTIMIZED: Only update changed fields
        $updateData = [];

        if ($this->booking_details->hotel_id != $this->hotel_id) $updateData['hotel_id'] = $this->hotel_id;
        if ($this->booking_details->room_id != $this->room_id) $updateData['room_id'] = $this->room_id;
        if ($this->booking_details->check_in_date != $this->check_in_date) $updateData['check_in_date'] = $this->check_in_date;
        if ($this->booking_details->check_out_date != $this->check_out_date) $updateData['check_out_date'] = $this->check_out_date;
        if ($this->booking_details->total_price != $this->total_price) $updateData['total_price'] = $this->total_price;
        if ($this->booking_details->status != $this->status) $updateData['status'] = $this->status;
        if ($this->booking_details->guest_name != $this->guest_name) $updateData['guest_name'] = $this->guest_name;
        if ($this->booking_details->guest_email != $this->guest_email) $updateData['guest_email'] = $this->guest_email;
        if ($this->booking_details->guest_phone != $this->guest_phone) $updateData['guest_phone'] = $this->guest_phone;

        // Only update if there are changes
        if (!empty($updateData)) {
            $updateData['updated_at'] = now();
            $this->booking_details->update($updateData);
            request()->session()->flash('success', 'Data successfully updated!');
        } else {
            request()->session()->flash('info', 'No changes detected.');
        }

        return $this->redirect('/bookingList');
    }

    public function render()
    {
        // OPTIMIZED: Only load essential hotel data
        return view('livewire.booking.booking-edit', [
            'hotels' => Hotel::select(['id', 'name', 'city', 'address'])
                ->orderBy('name')
                ->get(),
            'rooms' => $this->filteredRooms
        ]);
    }
}
