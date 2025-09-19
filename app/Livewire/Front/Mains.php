<?php

namespace App\Livewire\Front;

use App\Models\RoomType;
use Livewire\Component;
use Livewire\WithPagination;

class Mains extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.front.mains', [
            'room_types' => RoomType::paginate(4)
        ]);
    }
}
