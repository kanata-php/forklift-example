<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Directory;
use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $directories1 = Directory::factory()->count(3)->create();

        $directories2 = Directory::factory()->create([
            'parent' => $directories1->random()->id,
        ]);

        $directories1->each(function ($directory) {
            Document::factory()->count(Arr::random([1, 2]))->create([
                'directory_id' => $directory->id
            ]);
        });

        $directories2->each(function ($directory) {
            Document::factory()->count(Arr::random([1, 2]))->create([
                'directory_id' => $directory->id
            ]);
        });
    }
}
