<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Brand;
use App\Models\Models;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // \App\Models\User::factory(10)->create();

    \App\Models\User::factory()->create([
      'name' => 'mirko',
      'email' => 'mirko@example.com',
      'password' => Hash::make('mirko123')
    ]);

    Brand::factory()->create(
      [
        'name' => 'BMW',
      ]
    );
    Brand::factory()->create(
      [
        'name' => 'Mercedes-Benz',
      ]
    );
    Brand::factory()->create(
      [
        'name' => 'Volkswagen',
      ]
    );

    VehicleType::factory()->create(
      [
        'name' => 'Automobile',
      ]
    );
    VehicleType::factory()->create(
      [
        'name' => 'Motorcycle',
      ]
    );
    VehicleType::factory()->create(
      [
        'name' => 'Truck',
      ]
    );

    Models::factory(20)->create();
    // Vehicle::factory(20)->create();
  }
}
