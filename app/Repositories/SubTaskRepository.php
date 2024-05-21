<?php

namespace App\Repositories;

use App\Models\SubTask;

class SubTaskRepository
{
    public function storeSubTask($subTask, $task_id)
    {
        return SubTask::create([
            'task_id' => $task_id,
            'name' => $subTask
        ]);
    }
}
