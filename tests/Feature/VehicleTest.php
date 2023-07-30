<?php

namespace Tests\Feature;

use App\Models\Vehicle;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    use LazilyRefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testVehicleFactory(): void
    {
        $vehicle = Vehicle::factory()->make();

        $this->assertNotEmpty($vehicle->make);
        $this->assertNotEmpty($vehicle->model);
        $this->assertNotEmpty($vehicle->registration);
        $this->assertNull($vehicle->deleted_at);
    }

    public function testApiReturnsNothing(): void
    {
        Vehicle::factory()->count(5)->create();
        $response = $this->getJson('/api/vehicles');

        $this->assertDatabaseCount(Vehicle::class, 5);
        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
        $response->assertJson(['data' => []]);
    }

    public function testApiReturnsWithFullRegistration(): void
    {
        Vehicle::factory()->count(5)->create();
        $vehicle = Vehicle::first();
        $response = $this->Json('GET', '/api/vehicles', [
            'registration' => $vehicle->registration,
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJson(['data' => [
            [
                'id' => $vehicle->id,
                'make' => $vehicle->make,
                'model' => $vehicle->model,
                'registration' => $vehicle->registration,
            ],
        ]]);
    }

    public function testApiReturnsWithPartialRegistration(): void
    {
        $vehicleOne = Vehicle::factory()->create([
            'registration' => 'ABC123',
        ]);
        $vehicleTwo = Vehicle::factory()->create([
            'registration' => 'ABC456',
        ]);
        $vehicleThree = Vehicle::factory()->create([
            'registration' => 'DEF123',
        ]);

        $response = $this->Json('GET', '/api/vehicles', [
            'registration' => Str($vehicleOne->registration)->substr(0, 3),
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJson(['data' => [
            [
                'id' => $vehicleOne->id,
                'make' => $vehicleOne->make,
                'model' => $vehicleOne->model,
                'registration' => $vehicleOne->registration,
            ],
            [
                'id' => $vehicleTwo->id,
                'make' => $vehicleTwo->make,
                'model' => $vehicleTwo->model,
                'registration' => $vehicleTwo->registration,
            ],
        ]]);

        $response = $this->Json('GET', '/api/vehicles', [
            'registration' => Str($vehicleOne->registration)->substr(3, 3),
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJson(['data' => [
            [
                'id' => $vehicleOne->id,
                'make' => $vehicleOne->make,
                'model' => $vehicleOne->model,
                'registration' => $vehicleOne->registration,
            ],
            [
                'id' => $vehicleThree->id,
                'make' => $vehicleThree->make,
                'model' => $vehicleThree->model,
                'registration' => $vehicleThree->registration,
            ],
        ]]);
    }

    public function testApiReturnsWithMake(): void
    {
        $vehicleOne = Vehicle::factory()->create([
            'make' => 'Ford',
        ]);
        $vehicleTwo = Vehicle::factory()->create([
            'make' => 'Ford',
        ]);
        $vehicleThree = Vehicle::factory()->create([
            'make' => 'hyundai',
        ]);

        $response = $this->Json('GET', '/api/vehicles', [
            'make' => 'FORD',
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJson(['data' => [
            [
                'id' => $vehicleOne->id,
                'make' => $vehicleOne->make,
                'model' => $vehicleOne->model,
                'registration' => $vehicleOne->registration,
            ],
            [
                'id' => $vehicleTwo->id,
                'make' => $vehicleTwo->make,
                'model' => $vehicleTwo->model,
                'registration' => $vehicleTwo->registration,
            ],
        ]]);

        $response = $this->Json('GET', '/api/vehicles', [
            'make' => 'Fo',
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJson(['data' => [
            [
                'id' => $vehicleOne->id,
                'make' => $vehicleOne->make,
                'model' => $vehicleOne->model,
                'registration' => $vehicleOne->registration,
            ],
            [
                'id' => $vehicleTwo->id,
                'make' => $vehicleTwo->make,
                'model' => $vehicleTwo->model,
                'registration' => $vehicleTwo->registration,
            ],
        ]]);
    }

    public function testApiReturnsWithModel(): void
    {
        $vehicleOne = Vehicle::factory()->create([
            'make' => 'Ford',
            'model' => 'Focus',
        ]);
        $vehicleTwo = Vehicle::factory()->create([
            'make' => 'Ford',
            'model' => 'Fiesta',
        ]);
        $vehicleThree = Vehicle::factory()->create([
            'make' => 'Ford',
            'model' => 'Mondeo',
        ]);

        $response = $this->Json('GET', '/api/vehicles', [
            'model' => 'focus',
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJson(['data' => [
            [
                'id' => $vehicleOne->id,
                'make' => $vehicleOne->make,
                'model' => $vehicleOne->model,
                'registration' => $vehicleOne->registration,
            ]
        ]]);

        $response = $this->Json('GET', '/api/vehicles', [
            'model' => 'F',
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJson(['data' => [
            [
                'id' => $vehicleOne->id,
                'make' => $vehicleOne->make,
                'model' => $vehicleOne->model,
                'registration' => $vehicleOne->registration,
            ],
            [
                'id' => $vehicleTwo->id,
                'make' => $vehicleTwo->make,
                'model' => $vehicleTwo->model,
                'registration' => $vehicleTwo->registration,
            ],
        ]]);
    }

    public function testApiReturnsWithMultipleInputs(): void
    {
        $vehicleOne = Vehicle::factory()->create([
            'make' => 'Ford',
            'model' => 'Focus',
            'registration' => 'ABC123',
        ]);
        $vehicleTwo = Vehicle::factory()->create([
            'make' => 'Ford',
            'model' => 'Fiesta',
            'registration' => 'DEF456',
        ]);
        $vehicleThree = Vehicle::factory()->create([
            'make' => 'Ford',
            'model' => 'Mondeo',
            'registration' => 'DEF123',
        ]);
        $vehicleFour = Vehicle::factory()->create([
            'make' => 'knockoff',
            'model' => 'Focus',
            'registration' => 'DEF123',
        ]);

        $response = $this->Json('GET', '/api/vehicles', [
            'model' => 'focus',
            'make' => 'Ford',
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJson(['data' => [
            [
                'id' => $vehicleOne->id,
                'make' => $vehicleOne->make,
                'model' => $vehicleOne->model,
                'registration' => $vehicleOne->registration,
            ],
        ]]);

        $response = $this->Json('GET', '/api/vehicles', [
            'make' => 'ord',
            'registration' => '123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJson(['data' => [
            [
                'id' => $vehicleOne->id,
                'make' => $vehicleOne->make,
                'model' => $vehicleOne->model,
                'registration' => $vehicleOne->registration,
            ],
            [
                'id' => $vehicleThree->id,
                'make' => $vehicleThree->make,
                'model' => $vehicleThree->model,
                'registration' => $vehicleThree->registration,
            ],
        ]]);
    }
}
