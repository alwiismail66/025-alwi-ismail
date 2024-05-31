<?php

namespace Database\Seeders;

use App\Models\SubTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run () : void
    {
        $this->call ( UserTaskSeeder::class);
        Task::factory ()
            ->has ( SubTask::factory ()->count ( 3 ) )
            ->count ( 5 )
            ->create ();
    }
}
