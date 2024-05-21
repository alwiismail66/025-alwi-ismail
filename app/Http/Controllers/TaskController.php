<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TaskRequests\AddTaskRequest;

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
            return throw $e;
        }
    }
}
