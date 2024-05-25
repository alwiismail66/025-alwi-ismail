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
        protected SubTaskRepository $subTaskRepo
    ) {
    }
    public function storeTask(FormRequest $request): bool|Task
    {
        $request = $request->safe();
        $task = $this->taskRepo->storeTask($request);
        if ($request->filled('subtask')) {
            $subtasks = $request->subtask;
            foreach ($subtasks as $subtask) {
                if (!isset($subtask)) {
                    break;
                }
                $this->subTaskRepo->storeSubTask($subtask, $task->id);
            }
        }
        return $task;
    }

    public function updateStatusTask($id, $progress): bool
    {
        $status = $progress >= 100 ? 'complete' : 'not_complete';
        return $this->taskRepo->updateStatusTask($id, $progress, $status);
    }
    public function updateStatusSubtask($id, $status): bool
    {
        return $this->subTaskRepo->updateStatusSubtask($id, $status);
    }
    public function updateStatusSubAndTask($id, $progress): bool
    {
        $status = $progress >= 100 ? 'complete' : 'not_complete';
        if ($this->updateStatusSubtask($id, $status)) {
            $subtask = $this->subTaskRepo->getTaskIdAndProgressSubtask($id);
            $taskId = $subtask->task_id;
            $taskProgress = round($subtask->task->progress, 2);
            return $this->updateStatusTask($taskId, $taskProgress);
        } else {
            return false;
        }
    }
}
