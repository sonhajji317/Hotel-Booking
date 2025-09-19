<?php

namespace App\Livewire\RoomType;

use App\Models\RoomType;
use Livewire\Component;
use Livewire\WithPagination;

class RoomTable extends Component
{
    use WithPagination;

    public $room_type_details;
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $search, $name;

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function delete($id)
    {
        $this->room_type_details = RoomType::find($id);
        $this->room_type_details->delete();

        session()->flash('success', 'Room Type Deleted Successfully');
        return $this->redirect('/roomTypeTable');
    }

    public function render()
    {
        return view('livewire.room-type.room-table', [
            'room_types' => RoomType::latest()
                ->where('name', 'like', '%' . $this->search . '%')
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10)
        ]);
    }
}
