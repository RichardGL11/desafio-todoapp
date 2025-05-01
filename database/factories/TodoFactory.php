<?php

namespace Database\Factories;

use App\Enums\TodoStatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'status' => TodoStatusEnum::PENDING,
            'user_id' => User::factory(),
        ];
    }

    public function completed():static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TodoStatusEnum::COMPLETED->value
        ]);
    }
}
