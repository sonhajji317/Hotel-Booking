<?php

namespace App\Livewire\Room;

use App\Models\Room;
use App\Models\Hotel;
use Livewire\Component;
use App\Models\RoomType;

class RoomAdd extends Component
{
    public $hotel_id, $room_type_id, $floor, $room_number, $status;

    public function save()
    {
        $this->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_type_id' => 'required|exists:room_types,id',
            'room_number' => 'required|integer|max:10',
            'floor' => 'required|integer|min:1|max:5',
            'status' => 'required|in:available,maintenance,booked',
        ]);

        //kirim ke database
        Room::create([
            'hotel_id' => $this->hotel_id,
            'room_type_id' => $this->room_type_id,
            'floor' => $this->floor,
            'room_number' => $this->room_number,
            'status' => $this->status,
        ]);

        //redirect
        session()->flash('success', 'Room Success Added');
        return $this->redirect('/roomList');
    }

    public function render()
    {
        return view('livewire.room.room-add', [
            'hotels' => Hotel::all(),
            'room_types' => RoomType::all()
        ]);
    }
}
