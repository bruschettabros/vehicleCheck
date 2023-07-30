<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Faker\Provider\Fakecar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new Fakecar($this->faker));
        $vehicle = (object) $this->faker->vehicleArray;

        return [
            'make' => $vehicle->brand,
            'model' => $vehicle->model,
            'registration' => $this->faker->vehicleRegistration,
        ];
    }
}
