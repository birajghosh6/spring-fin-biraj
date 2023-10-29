<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Player;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PlayerFactory extends Factory
{
    protected $model = Player::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'addressLine1' => $this->faker->sentence(1),
            'addressLine2' => $this->faker->sentence(1),
            'city' => $this->faker->sentence(1),
            'province' => $this->faker->sentence(1),
            'country' => $this->faker->sentence(1),
            'postal' => $this->faker->randomNumber(6),
            'points' => $this->faker->randomNumber(3)
        ];
    }
}
