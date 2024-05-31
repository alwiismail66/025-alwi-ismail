<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubTask>
 */
class SubTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition () : array
    {
        return [
            'task_id' => Task::factory (),
            'name'    => $this->faker->word (),
            'status'  => $this->faker->optional ()->randomElement ( [ 'complete', 'not_complete', null ] ),
        ];
    }
}
