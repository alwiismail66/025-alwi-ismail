<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition () : array
    {
        $startRange = Carbon::now ()->subWeek ();
        $endRange = Carbon::now ()->addWeek ();

        // Menghasilkan tanggal acak dalam rentang yang ditentukan
        $forDate = $this->faker->dateTimeBetween ( $startRange, $endRange )->format ( 'Y-m-d' );
        $startAt = $this->faker->time ();
        $duration = $this->faker->time ();

        $expired = Carbon::parse ( "{$forDate} {$startAt}" )
            ->add ( Carbon::parse ( $duration )->diffAsCarbonInterval () )
            ->addDay ();

        return [
            'user_id'  => User::factory (),
            'name'     => $this->faker->word (),
            'notice'   => $this->faker->sentence ( 6 ),
            'for_date' => $forDate,
            'start_at' => $startAt,
            'duration' => $duration,
            'expired'  => $expired,
            'progress' => 0, // Default, will be calculated later
            'status'   => $this->faker->optional ()->randomElement ( [ 'complete', 'not_complete', null ] ),
        ];
    }

    public function configure ()
    {
        return $this->afterCreating ( function (Task $task)
        {
            // Check if the task has subtasks
            $subTasks = $task->subTasks;

            if ( $subTasks->isEmpty () )
            {
                // No subtasks, progress is 100% if status is complete
                $task->progress = $task->status === 'complete' ? 100 : 0;
            }
            else
            {
                // Calculate progress based on subtasks
                $totalSubTasks = $subTasks->count ();
                $completedSubTasks = $subTasks->where ( 'status', 'complete' )->count ();
                $task->progress = ( $completedSubTasks / $totalSubTasks ) * 100;
            }

            $task->save ();
        } );
    }
}
