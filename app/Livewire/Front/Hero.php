<?php

namespace App\Livewire\Front;

use App\Models\Hotel;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Hero extends Component
{
    #[Validate('required|exists:hotels,id')]
    public $hotel;

    #[Validate('required|date|after_or_equal:today')]
    public $check_in_date;

    #[Validate('required|date|after:check_in_date')]
    public $check_out_date;

    public function mount()
    {
        $this->check_in_date = date('Y-m-d');
        $this->check_out_date = date('Y-m-d', strtotime('+1 day'));
    }

    public function searchHotelSelected()
    {
        // Using attribute validation - no need to call validate() manually
        $this->validate();

        // OPTIMIZED: Add error handling for better UX
        try {
            return redirect()->route('hotel.details', [
                'id' => $this->hotel,
                'check_in_date' => $this->check_in_date,
                'check_out_date' => $this->check_out_date,
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'Unable to search hotels. Please try again.');
        }
    }

    public function render()
    {
        // OPTIMIZED: Only load essential hotel data for dropdown/search
        return view('livewire.front.hero', [
            'hotels' => Hotel::select(['id', 'name', 'city', 'address', 'rating'])
                ->where('status', 'active') // Only show active hotels
                ->orderBy('name') // Alphabetical order for better UX
                ->get()
        ]);
    }
}
