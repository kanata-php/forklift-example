<?php

namespace Database\Factories;

use App\Models\Directory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => substr($this->faker->sentence(Arr::random([2,3])), 0, 40),
            'content' => $this->faker->sentence(Arr::random([20, 25, 30])),
        ];
    }

    public function withDirectory()
    {
        return $this->state(function (array $attributes) {
            $directory = Directory::inRandomOrder()->first();

            return [
                'directory_id' => $directory->id,
            ];
        });
    }
}
