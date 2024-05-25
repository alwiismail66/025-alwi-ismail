<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{
    public function storeTask($request): Task|null
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
    public function getTaskSubTaskToday(): Task|Collection|null
    {
        return Task::where('for_date', date('Y-m-d'))->with('subtasks')->get();
    }
    public function updateStatusTask($id, $progress, $action)
    {
        return Task::where('id', $id)->update([
            'progress' => $progress,
            'status' => $action
        ]);
    }
}
