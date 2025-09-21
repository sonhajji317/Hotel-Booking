<?php

namespace App\Livewire\Hotel;

use App\Models\Hotel;
use Livewire\Component;
use Livewire\WithPagination;

class HotelAll extends Component
{
    use WithPagination;

    public $search;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.hotel.hotel-all', [
            'hotels' => Hotel::with('rooms')
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('city', 'like', '%' . $this->search . '%')
                            ->orWhere('address', 'like', '%' . $this->search . '%');
                    });
                })
                ->orderByRaw("CASE WHEN status = 'active' THEN 1 ELSE 2 END")
                ->paginate(12)
        ])->layout('components.layouts.app');
    }
}
