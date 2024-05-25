<?php

namespace App\Repositories;

use App\Models\Task;
use App\Models\SubTask;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SubTaskRepository
{
    public function storeSubTask($subTask, $task_id)
    {
        return SubTask::create([
            'task_id' => $task_id,
            'name' => $subTask
        ]);
    }
    public function updateStatusSubtask($id, $status)
    {
        return SubTask::where('id', $id)->update(['status' => $status]);
    }

    public function getTaskIdAndProgressSubtask($id)
    {
        return SubTask::where('id', $id)->with([
            'task' => function (Builder $query) {
                $query->select('id');
                $query->withCount('subtasks as total_subtask');//withcount di ibaratkan addselect jadi tidak perlu di select ketika hanya ingin menampilkan hasil dari kolom dari withcount nya saja
                $query->withCount([
                    'subtasks as total_subtask_complete' => function (Builder $query) {
                    $query->where('status', 'complete');
                }
                ]);
                $query->selectRaw('(select total_subtask_complete/total_subtask*100) as progress');//di selectraw bisa mendapatkan col berisi hasil dari query yang sedang di jalankan contoh ketika selectraw('tasks.id as id')id disini berisi 1
            }
        ])
            ->select('id', 'task_id')
            ->first();
    }
}
