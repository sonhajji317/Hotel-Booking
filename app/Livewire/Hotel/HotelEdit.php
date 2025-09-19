<?php

namespace App\Livewire\Hotel;

use App\Models\Hotel;
use Livewire\Component;
use Livewire\WithFileUploads;

class HotelEdit extends Component
{
    use WithFileUploads;

    public $name, $address, $city, $description, $thumbnail, $rating, $status, $hotel_details, $existing_thumbnail;

    public function mount($id)
    {
        $this->hotel_details = Hotel::find($id);
        $this->name = $this->hotel_details->name;
        $this->address = $this->hotel_details->address;
        $this->city =  $this->hotel_details->city;
        $this->description = $this->hotel_details->description;
        $this->existing_thumbnail = $this->hotel_details->thumbnail;
        $this->rating = $this->hotel_details->rating;
        $this->status = $this->hotel_details->status;
    }

    public function update()
    {
        //validate
        $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'thumbnail' => 'nullable|image|max:2048',
            'description' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'status' => 'required|in:active,inactive',

        ]);

        //jika user upload thumbnail baru
        if ($this->thumbnail && is_object($this->thumbnail)) {
            $thumbnailPath = $this->thumbnail->store('hotels', 'public');
        } else {
            $thumbnailPath = $this->existing_thumbnail;
        }

        //send to database
        $this->hotel_details->update([
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'description' => $this->description,
            'thumbnail' => $thumbnailPath,
            'rating' => $this->rating,
            'status' => $this->status,
        ]);

        //redirect
        session()->flash('success', 'Hotel Success Updated!');
        return $this->redirect('/hotelList');
    }

    public function render()
    {
        return view('livewire.hotel.hotel-edit');
    }
}
