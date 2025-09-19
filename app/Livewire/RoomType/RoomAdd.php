<?php

namespace App\Livewire\RoomType;

use App\Models\Hotel;
use App\Models\RoomType;
use Livewire\Component;
use Livewire\WithFileUploads;

class RoomAdd extends Component
{
    use WithFileUploads;

    public $name, $images_view, $description, $price, $capacity, $facilities;

    public function save()
    {
        //validate
        $this->validate([
            'name' => 'required|string|max:255',
            'images_view' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'required|string',
            'price' => 'required|numeric|min:10000',
            'capacity' => 'required|numeric|min:1|max:8',
            // 'facilities' => 'nullable|numeric',
        ]);
        //membuat directory images_view
        $filename = $this->images_view ? $this->images_view->store('images_view', 'public') : null;
        //kirim ke database
        RoomType::create([
            'name' => $this->name,
            'description' => $this->description,
            'images_view' => $filename,
            'price' => $this->price,
            'capacity' => $this->capacity,
        ]);
        //redirect
        session()->flash('success', 'Room Type Added!');
        return $this->redirect('/roomTypeTable');
    }

    public function render()
    {
        return view('livewire.room-type.room-add', [
            'hotels' => Hotel::all(),
            'room_types' => RoomType::all()
        ]);
    }
}
