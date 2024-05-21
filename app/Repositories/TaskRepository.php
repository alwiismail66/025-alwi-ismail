<?php

namespace App\Repositories;

use App\Models\Task;


class TaskRepository
{
    public function storeTask($request)
    {
        return Task::create([
            'name' => $request['name-task'],
            'user_id' => auth()->id(),
            'notice' => $request->notice,
            'for_date' => $request['for-date'],
            'start_at' => $request['start-at'],
            'duration' => $request['duration']
        ]);
    }
}
