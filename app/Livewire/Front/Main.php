<?php

namespace App\Livewire\Front;

use App\Models\Hotel;
use App\Models\RoomType;
use Livewire\Component;
use Livewire\WithPagination;

class Main extends Component
{
    use WithPagination;

    public $search;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.front.main', [
            'hotels' => Hotel::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('address', 'like', '%' . $this->search . '%')
                ->orWhere('city', 'like', '%' . $this->search . '%')
                ->orderByRaw("CASE WHEN status = 'active' THEN 1 ELSE 2 END")
                ->paginate(4),
            'room_types' => RoomType::paginate(4),
        ]);
    }
}
