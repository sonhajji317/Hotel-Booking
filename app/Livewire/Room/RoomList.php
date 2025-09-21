<?php

namespace App\Livewire\Room;

use App\Models\Room;
use Livewire\Component;
use App\Models\RoomType;
use Livewire\WithPagination;

class RoomList extends Component
{
    use WithPagination;
    public $room_details;
    public $sortField = 'hotel_id';
    public $sortDirection = 'asc';
    public $search, $hotel_id, $room_type_id, $price, $room_number, $floor;

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
        $this->room_details = Room::with(['hotel', 'room_type'])->find($id);
        $this->room_details->delete();
        session()->flash('success', 'Room deleted successfully.');
        return $this->redirect('/roomList');
    }

    public function render()
    {
        return view('livewire.room.room-list', [
            'room_types' => RoomType::with('rooms')->get(),
            'rooms' => Room::orderBy($this->sortField, $this->sortDirection)
                ->paginate(10)
        ]);
    }
}
