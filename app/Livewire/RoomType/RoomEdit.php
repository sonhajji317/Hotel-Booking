<?php

namespace App\Livewire\RoomType;

use App\Models\Hotel;
use App\Models\RoomType;
use Livewire\Component;
use Livewire\WithFileUploads;

class RoomEdit extends Component
{
    use WithFileUploads;

    public $name, $images_view, $capacity, $price, $description, $room_type_details, $existing_image;

    public function mount($id)
    {
        $this->room_type_details = RoomType::find($id);
        $this->name = $this->room_type_details->name;
        $this->existing_image = $this->room_type_details->images_view;
        $this->capacity = $this->room_type_details->capacity;
        $this->price = $this->room_type_details->price;
        $this->description = $this->room_type_details->description;
    }

    public function update()
    {
        //validate
        $this->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1|max:8',
            'price' => 'required|integer|min:10000',
            'description' => 'required|string',
            'images_view' => 'nullable|image|max:2048',
        ]);

        //jika user upload images view baru
        if ($this->images_view && is_object($this->images_view)) {
            $images_view_path = $this->images_view->store('images_view', 'public');
        } else {
            $images_view_path = $this->existing_image;
        }

        //kirim ke database
        $this->room_type_details->update([
            'name' => $this->name,
            'capacity' => $this->capacity,
            'price' => $this->price,
            'description' => $this->description,
            'images_view' => $images_view_path,
        ]);

        //redirect ke view
        session()->flash('success', 'Room Success Updated!');
        return $this->redirect('/roomTypeTable');
    }

    public function render()
    {
        return view('livewire.room-type.room-edit', [
            'hotels' => Hotel::all(),
            'room_types' => RoomType::all()
        ]);
    }
}
