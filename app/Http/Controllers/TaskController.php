<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TaskRequests\AddTaskRequest;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function showAdd ()
    {
        return view ( 'task.addtask' );
    }

    public function store ( AddTaskRequest $request, TaskService $taskService )
    {
        try
        {
            DB::beginTransaction ();
            if ( $taskService->storeTask ( $request ) )
            {
                DB::commit ();
                return to_route ( 'home' );
            }
            else
            {
                DB::rollBack ();
                return back ()->withInput ()->withErrors ( 'Error failed to add task' );
            }
        }
        catch ( \Throwable $e )
        {
            DB::rollBack ();
            throw $e;
        }
    }

    public function toggleStatus ( Request $request, TaskService $taskService )
    {
        try
        {
            DB::beginTransaction ();
            $request = explode ( ',', $request->task ?? $request->subtask );
            $table = $request[ 0 ];
            $progress = $request[ 1 ];
            $id = $request[ 2 ];
            $query = false;
            if ( $table === 'task' )
            {
                $query = $taskService->updateStatusTask ( $id, $progress );
            }
            else
            {
                $query = $taskService->updateStatusSubAndTask ( $id, $progress );
            }
            if ( $query )
            {
                DB::commit ();
                return back ();
            }
            else
            {
                DB::rollBack ();
                return back ()->withErrors ( 'Error cannot update status' );
            }
        }
        catch ( \Throwable $e )
        {
            DB::rollBack ();
            throw $e;
        }
    }
    public function showTask ( Request $request, TaskService $taskService )
    {
        $listDate = $taskService->getPage ( $request->page ?? 1 );
        $data = $taskService->getTaskAll ( $listDate, $request->page ?? 1 );

        $page = $request->page <= 1 || $request->page <= 10 ? 1 : $request->page;
        return view ( 'task.task' )->with ( 'data', $data )->with ( 'dates', $listDate )->with ( 'page', $page );
    }
    public function showDetailTask ( Request $request, TaskService $taskService )
    {
        $data = $taskService->getTask ( $request->id );
        return view ( 'task.detailtask' )->with ( 'task', $data );
    }
    public function showEditTask ( Request $request, TaskService $taskService )
    {
        $data = $taskService->getTask ( $request->id );
        return view ( 'task.edittask' )->with ( 'task', $data );
    }
    public function updateTask ( AddTaskRequest $request, TaskService $taskService )
    {
        try
        {
            DB::beginTransaction ();
            if ( $taskService->updateTask ( $request, $request->id, $request[ 'subtask-id' ] ) )
            {
                DB::commit ();
                return to_route ( 'task.showTask' );
            }
            else
            {
                DB::rollBack ();
                return back ()->withInput ()->withErrors ( 'Error failed to edit task' );
            }
        }
        catch ( \Throwable $e )
        {
            DB::rollBack ();
            throw $e;
        }
    }
    public function deleteTask ( Request $request, TaskService $taskService )
    {
        try
        {
            DB::beginTransaction ();
            if ( $taskService->deleteTask ( $request->id ) )
            {
                DB::commit ();
                return to_route ( 'task.showTask' );
            }
            else
            {
                DB::rollBack ();
                return to_route ( 'task.showTask' )->withErrors ( 'error cannot delete task with id $request->task' );
            }
        }
        catch ( \Throwable $e )
        {
            DB::rollBack ();
            throw $e;
        }
    }
}
