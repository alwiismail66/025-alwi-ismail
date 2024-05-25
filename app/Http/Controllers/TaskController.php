<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TaskRequests\AddTaskRequest;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function showAdd()
    {
        return view('task.addtask');
    }

    public function store(AddTaskRequest $request, TaskService $taskService)
    {
        try {
            DB::beginTransaction();
            if ($taskService->storeTask($request)) {
                DB::commit();
                return to_route('home');
            } else {
                DB::rollBack();
                return back()->withInput()->withErrors('Error failed to add task');
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function toggleStatus(Request $request, TaskService $taskService)
    {
        try {
            DB::beginTransaction();
            $request = explode(',', $request->task ?? $request->subtask);
            $table = $request[0];
            $progress = $request[1];
            $id = $request[2];
            $query = false;
            if ($table === 'task') {
                $query = $taskService->updateStatusTask($id, $progress);
            } else {
                $query = $taskService->updateStatusSubAndTask($id, $progress);
            }
            if ($query) {
                DB::commit();
                return to_route('home');
            } else {
                DB::rollBack();
                return back()->withErrors('Error cannot update status');
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
