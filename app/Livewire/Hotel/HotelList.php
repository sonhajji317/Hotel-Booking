<?php

namespace App\Livewire\Hotel;

use App\Models\Hotel;
use Livewire\Component;
use Livewire\WithPagination;

class HotelList extends Component
{
    use WithPagination;
    public $search, $hotel_details;
    public $sortField = 'name';
    public $sortDirection = 'asc';

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
        $this->hotel_details = Hotel::find($id);
        $this->hotel_details->delete();
        session()->flash('success', 'Hotel deleted successfully.');
        return $this->redirect('/hotelList');
    }

    public function render()
    {
        $hotels = Hotel::query()
            ->where(function ($query) {
                $query->where('address', 'like', '%' . $this->search . '%')
                    ->orWhere('city', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.hotel.hotel-list', [
            'hotels' => $hotels
        ]);
    }
}
