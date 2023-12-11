<?php

namespace Database\Factories;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'email' => fake()->safeEmail(),
            'phone' => $this->faker->numerify('##########'),
            'password' => bcrypt('p@$$word'),
            'birthday' =>  fake()->dateTimeBetween('1990-01-01', '2010-12-31')->format('Y-m-d'),
            'gender' =>  fake()->boolean(),
        ];
    }
}
