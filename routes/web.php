<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Booking\BookingAdd;
use App\Livewire\Booking\BookingDetails;
use App\Livewire\Booking\BookingEdit;
use App\Livewire\Booking\BookingList;
use App\Livewire\Front\About;
use App\Livewire\Hotel\HotelAdd;
use App\Livewire\Hotel\HotelAll;
use App\Livewire\Hotel\HotelDetails;
use App\Livewire\Hotel\HotelEdit;
use App\Livewire\Hotel\HotelList;
use App\Livewire\Room\RoomAdd as RoomRoomAdd;
use App\Livewire\Room\RoomEdit as RoomRoomEdit;
use App\Livewire\Room\RoomList as RoomRoomList;
use App\Livewire\RoomType\RoomAdd;
use App\Livewire\RoomType\RoomEdit;
use App\Livewire\RoomType\RoomList;
use App\Livewire\RoomType\RoomTable;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hotelAll', HotelAll::class);
Route::get('/hotel/{id}/details', HotelDetails::class)->name('hotel.details');
Route::get('/roomTypeList', RoomList::class);
Route::get('/bookingDetails', BookingDetails::class);
Route::get('/about', About::class);

Route::post('/midtrans/notification', [App\Http\Controllers\MidtransController::class, 'notification']);


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/hotelList', HotelList::class);
    Route::get('/hotelAdd', HotelAdd::class);
    Route::get('/hotel/{id}/edit', HotelEdit::class);

    Route::get('/roomList', RoomRoomList::class);
    Route::get('/roomAdd', RoomRoomAdd::class)->name('room.add');
    Route::get('/room/{id}/edit', RoomRoomEdit::class);

    Route::get('/roomTypeTable', RoomTable::class);
    Route::get('/roomTypeAdd', RoomAdd::class);
    Route::get('/roomType/{id}/edit', RoomEdit::class);

    Route::get('/bookingList', BookingList::class);
    Route::get('/bookingAdd', BookingAdd::class);
    Route::get('/booking/{id}/edit', BookingEdit::class);
});
