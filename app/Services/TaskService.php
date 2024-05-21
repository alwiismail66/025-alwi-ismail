<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\SubTaskRepository;
use App\Repositories\TaskRepository;
use Illuminate\Foundation\Http\FormRequest;

class TaskService
{
    public function __construct(
        protected TaskRepository $taskRepo,
        protected  SubTaskRepository $subTaskRepo
    ) {
    }
    public function storeTask(FormRequest $request): bool|Task
    {
        $request = $request->safe();
        $task = $this->taskRepo->storeTask($request);
        if ($request->filled('subtask')) {
            $subtasks = $request->subtask;
            foreach ($subtasks as $subtask) {
                $this->subTaskRepo->storeSubTask($subtask, $task->id);
            }
        }
        return $task;
    }
}
