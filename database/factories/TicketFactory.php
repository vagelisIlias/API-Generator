<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => fake()->sentence,
            'content' => fake()->paragraph,
            'user_name' => fake()->name,
            'user_email' => fake()->email,
            'created_at' => fake()->dateTime(),
            'status' => false,
        ];
    }
}
