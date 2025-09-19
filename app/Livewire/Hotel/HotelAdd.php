<?php

namespace App\Livewire\Hotel;

use App\Models\Hotel;
use Livewire\Component;
use Livewire\WithFileUploads;

class HotelAdd extends Component
{
    use WithFileUploads;

    public $name, $address, $city, $description, $rating, $status, $thumbnail;

    public function save()
    {
        //validate
        $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'status' => 'required|in:active,inactive',
            'thumbnail' => 'nullable|image|max:2048'
        ]);

        //create directory thumbnail
        $filename = $this->thumbnail ? $this->thumbnail->store('hotels', 'public') : null;
        //send to database
        Hotel::create([
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'description' => $this->description,
            'rating' => $this->rating,
            'status' => $this->status,
            'thumbnail' => $filename,
        ]);

        //redirect to hotel list
        session()->flash('message', 'Hotel Success added');
        return $this->redirect('/hotelList');
    }

    public function render()
    {
        return view('livewire.hotel.hotel-add');
    }
}
