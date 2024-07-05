<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = ['done', 'testing', 'in_working', 'wait'];

        $date_create = $this->faker->date();

        $date_to_finish = $this->faker->dateTimeBetween($date_create, '+1 year')->format('Y-m-d');

        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement($status),
            'date_create' => $date_create,
            'date_to_finish' => $date_to_finish,
        ];
    }
}
