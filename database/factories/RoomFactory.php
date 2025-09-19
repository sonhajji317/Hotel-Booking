<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hotel_id' => Hotel::inRandomOrder()->first()->id,
            'room_type_id' => RoomType::inRandomOrder()->first()->id,
            'room_number' => $this->faker->numberBetween(1, 10),
            'floor' => $this->faker->numberBetween(1, 5),
            'status' => $this->faker->randomElement(['available', 'maintenance', 'booked'])
        ];
    }
}
