<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\SubTask;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run () : void
    {
        $user = User::where ( 'email', 'admin@gmail.com' )->first ();

        if ( ! $user )
        {
            $user = User::factory ()->withSpecificCredentials ( 'admin@gmail.com', '123456' )->create ();
        }

        Task::factory ()
            ->has ( SubTask::factory ()->count ( 3 ) )
            ->count ( 10 )
            ->create ( [
                'user_id' => $user->id,
            ] );

    }
}
