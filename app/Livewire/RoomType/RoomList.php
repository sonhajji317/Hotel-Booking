<?php

namespace App\Livewire\RoomType;

use App\Models\RoomType;
use Livewire\Component;
use Livewire\WithPagination;

class RoomList extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.room-type.room-list', [
            'room_types' => RoomType::latest()
                ->paginate('6')
        ]);
    }
}
