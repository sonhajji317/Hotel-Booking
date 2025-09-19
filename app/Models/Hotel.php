<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'description',
        'rating',
        'thumbnail',
        'status',
    ];

    public function room_types()
    {
        return $this->hasMany(RoomType::class);
    }
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
