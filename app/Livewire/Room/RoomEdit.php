<?php

namespace App\Livewire\Room;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomType;
use Livewire\Component;

class RoomEdit extends Component
{
    public $hotel_id, $room_type_id, $room_number, $floor, $status, $room_details;

    public function mount($id)
    {
        $this->room_details = Room::find($id);
        $this->hotel_id = $this->room_details->hotel_id;
        $this->room_type_id = $this->room_details->room_type_id;
        $this->room_number = $this->room_details->room_number;
        $this->floor = $this->room_details->floor;
        $this->status = $this->room_details->status;
    }

    public function update()
    {
        //validate
        $this->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_type_id' => 'required|exists:room_types,id',
            'room_number' => 'required|integer|min:1|max:10',
            'floor' => 'required|integer|min:1|max:5',
            'status' => 'required|in:available,maintenance,booked',
        ]);

        //kirim ke database
        $this->room_details->update([
            'hotel_id' => $this->hotel_id,
            'room_type_id' => $this->room_type_id,
            'room_number' => $this->room_number,
            'floor' => $this->floor,
            'status' => $this->status,
        ]);

        request()->session()->flash('success', 'Room Success Updated!');
        //redirect
        return $this->redirect('/roomList');
    }

    public function render()
    {
        return view('livewire.room.room-edit', [
            'rooms' => Room::all(),
            'hotels' => Hotel::all(),
            'room_types' => RoomType::all()
        ]);
    }
}
