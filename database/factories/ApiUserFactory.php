<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ApiUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$V/axb3V/UU4BDfM1Qc6u0udidch2YD5Z2otW5Ty/9MEIdDw3z0x4y', // password
            'designation'=>fake()->text(),
            'mobile'=>fake()->phoneNumber()
        ];
    }
}
