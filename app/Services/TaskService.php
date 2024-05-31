<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\SubTaskRepository;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class TaskService
{
    public function __construct (
        protected TaskRepository $taskRepo,
        protected SubTaskRepository $subTaskRepo,
    ) {
    }
    public function storeTask ( FormRequest $request ) : Task|null
    {
        $request = $request->safe ();
        $taskStart = Carbon::parse ( $request[ 'for-date' ] . ' ' . $request[ 'start-at' ] );
        $duration = Carbon::parse ( $request->duration );
        $endTask = $taskStart->copy ()->addHours ( $duration->hour )->addMinutes ( $duration->minute )->addSeconds ( $duration->second );
        $request->expired = $endTask->copy ()->addDay ();
        $task = $this->taskRepo->storeTask ( $request );
        if ( $request->filled ( 'subtask' ) )
        {
            $subtasks = $request->subtask;
            foreach ( $subtasks as $subtask )
            {
                if ( ! isset ( $subtask ) )
                {
                    break;
                }
                $this->subTaskRepo->storeSubTask ( $subtask, $task->id );
            }
        }
        return $task;
    }

    public function updateStatusTask ( $id, $progress ) : bool
    {
        $status = $progress >= 100 ? 'complete' : 'not_complete';
        return $this->taskRepo->updateStatusTask ( $id, $progress, $status );
    }
    public function updateStatusSubtask ( $id, $status ) : bool
    {
        return $this->subTaskRepo->updateStatusSubtask ( $id, $status );
    }
    public function updateStatusSubAndTask ( $id, $progress ) : bool
    {
        $status = $progress >= 100 ? 'complete' : 'not_complete';
        if ( $this->updateStatusSubtask ( $id, $status ) )
        {
            $subtask = $this->subTaskRepo->getTaskIdAndProgressSubtask ( $id );
            $taskId = $subtask->task_id;
            $taskProgress = round ( $subtask->task->progress, 2 );
            return $this->updateStatusTask ( $taskId, $taskProgress );
        }
        else
        {
            return false;
        }
    }
    public function getPage ( $page )
    {
        $page <= 10 ? $skip = 0 : $skip = $page;

        return $this->taskRepo->getPage ( $skip )->map ( function ($item)
        {
            $item[ 'date' ] = Carbon::parse ( $item[ 'for_date' ] )->format ( 'd/m' );
            return $item;
        } );
    }
    public function getTaskAll ( $fromPage, $page ) : Collection|null
    {
        $page >= 1 ? $page -= 1 : $page = 0;
        return $this->taskRepo->getTaskAll ( $fromPage, $page )->map ( function ($item)
        {
            $taskForDate = Carbon::parse ( $item[ 'for_date' ] );
            $dateNow = Carbon::parse ( date ( 'Y-m-d' ) );
            $item[ 'can_edit' ] = true;
            $item[ 'can_edit_task' ] = true;
            $item[ 'allSubFilled' ] = true;

            $item->subtasks = $item->subtasks->map ( function ($subtask) use (&$item) //add atribute subtask['can_edit']
            {
                $subtask[ 'can_edit' ] = true;
                if ( filled ( $subtask[ 'status' ] ) )
                {
                    $subtask[ 'can_edit' ] = false;
                }
                else
                {
                    $item[ 'allSubFilled' ] = false;
                }
                return $subtask;
            } );

            if ( $taskForDate->lessThan ( $dateNow ) || ( filled ( $item[ 'status' ] ) && ( blank ( $item->subtasks ) || $item[ 'allSubFilled' ] = true ) ) ) //add atribute task[can_edit]
            {
                $item[ 'can_edit' ] = false;
            }

            if ( filled ( $item[ 'status' ] ) )
            {
                $item[ 'can_edit_task' ] = false;
            }

            return $item;
        } );

    }
    public function getClosestTask ()
    {
        return $this->taskRepo->getClosestTask ()->map ( function ($item)
        {
            $taskForDate = Carbon::parse ( $item[ 'for_date' ] );
            $dateNow = Carbon::parse ( date ( 'Y-m-d' ) );
            $item[ 'can_edit' ] = true;
            $item[ 'can_edit_task' ] = true;
            $item[ 'allSubFilled' ] = true;

            $item->subtasks = $item->subtasks->map ( function ($subtask) use (&$item) //add atribute subtask['can_edit']
            {
                $subtask[ 'can_edit' ] = true;
                if ( filled ( $subtask[ 'status' ] ) )
                {
                    $subtask[ 'can_edit' ] = false;
                }
                else
                {
                    $item[ 'allSubFilled' ] = false;
                }
                return $subtask;
            } );

            if ( $taskForDate->lessThan ( $dateNow ) || ( filled ( $item[ 'status' ] ) && ( blank ( $item->subtasks ) || $item[ 'allSubFilled' ] = true ) ) ) //add atribute task[can_edit]
            {
                $item[ 'can_edit' ] = false;
            }

            if ( filled ( $item[ 'status' ] ) )
            {
                $item[ 'can_edit_task' ] = false;
            }

            return $item;
        } );
    }

    public function getTask ( int $id ) : Task|null
    {
        $task = $this->taskRepo->getTask ( $id );
        if ( $task[ 'user_id' ] != auth ()->id () )
        {
            return abort ( 404 );
        }
        $taskForDate = Carbon::parse ( $task[ 'for_date' ] );
        $dateNow = Carbon::parse ( date ( 'Y-m-d' ) );
        $task[ 'can_edit' ] = true;
        $task[ 'can_edit_task' ] = true;
        $task[ 'expired_status' ] = false;
        $task[ 'allSubFilled' ] = true;

        $task->subtasks = $task->subtasks->map ( function ($subtask) use (&$task) //add atribute subtask['can_edit']
        {
            $subtask[ 'can_edit' ] = true;

            if ( filled ( $subtask[ 'status' ] ) )
            {
                $subtask[ 'can_edit' ] = false;
            }
            else
            {
                $task[ 'allSubFilled' ] = false;

            }
            return $subtask;
        } );

        if ( $taskForDate->lessThan ( $dateNow ) || ( filled ( $task[ 'status' ] ) && ( blank ( $task->subtasks ) || $task[ 'allSubFilled' ] = true ) ) ) //add atribute task[can_edit]
        {
            $task[ 'can_edit' ] = false;
        }

        if ( filled ( $task[ 'status' ] ) )
        {
            $task[ 'can_edit_task' ] = false;
        }

        if ( Carbon::parse ( now () )->greaterThan ( Carbon::parse ( $task->expired ) ) )
        {
            $task[ 'expired_status' ] = true;
        }
        return $task;
    }
    public function updateTask ( FormRequest $request, int $id, null|array $subtaskId )
    {
        $safeRequest = $request->safe ();
        $updateTask = $this->taskRepo->updateTask ( $safeRequest, $id );

        if ( $safeRequest->filled ( 'subtask' ) )
        {
            foreach ( $safeRequest->subtask as $index => $subtask )
            {
                if ( $subtask === null )
                {
                    break;
                }
                $subtaskIdExists = $subtaskId[$index] ?? null;
                if ( $subtaskIdExists )
                {
                    $this->subTaskRepo->updateSubtask ( $subtask, $subtaskIdExists );
                }
                else
                {
                    $this->subTaskRepo->storeSubTask ( $subtask, $id );
                }
            }
        }
        return $updateTask;
    }
    public function deleteTask ( int $id )
    {
        return $this->taskRepo->deleteTask ( $id );
    }
}
