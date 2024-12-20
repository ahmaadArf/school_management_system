<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\ReligionTableSeeder;
use Database\Seeders\TypeBloodTableSeeder;
use Database\Seeders\NationalitiesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $this->call(TypeBloodTableSeeder::class);
        // $this->call(NationalitiesTableSeeder::class);
        // $this->call(ReligionTableSeeder::class);
        // $this->call(GenderTableSeeder::class);
        // $this->call(SpecializationsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);

    }
}
