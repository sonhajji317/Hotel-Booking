<?php

namespace App\Livewire\Front;

use App\Models\Hotel;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Hero extends Component
{
    public $hotel, $check_in_date, $check_out_date, $hotel_selected;

    public function mount()
    {
        $this->check_in_date = date('Y-m-d');
        $this->check_out_date = date('Y-m-d', strtotime('+1 day'));
    }

    public function placeholder()
    {
        return view('livewire.skeleton');
    }

    public function searchHotelSelected()
    {
        $this->validate([
            'hotel' => 'required|exists:hotels,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date'
        ]);

        //redirect ke halaman hotel_details
        return redirect()->route('hotel.details', [
            'id' => $this->hotel,
            'check_in_date' => $this->check_in_date,
            'check_out_date' => $this->check_out_date,
        ]);
    }

    public function render()
    {
        return view('livewire.front.hero', [
            'hotels' => Hotel::all()
        ]);
    }
}
