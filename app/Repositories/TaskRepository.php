<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{
    public function storeTask ( $request ) : Task|null
    {
        return Task::create ( [
            'name'     => $request[ 'name-task' ],
            'user_id'  => auth ()->id (),
            'notice'   => $request->notice,
            'for_date' => $request[ 'for-date' ],
            'start_at' => $request[ 'start-at' ],
            'duration' => $request[ 'duration' ],
            'expired'  => $request->expired,
        ] );
    }
    public function getTaskSubTaskToday () : Task|Collection|null
    {
        return Task::where ( 'for_date', date ( 'Y-m-d' ) )->with ( 'subtasks' )->orderBy ( 'start_at', 'asc' )->get ();
    }
    public function updateStatusTask ( $id, $progress, $action )
    {
        return Task::where ( 'id', $id )->update ( [
            'progress' => $progress,
            'status'   => $action,
        ] );
    }
    public function getPage ( $skip )
    {
        return Task::where ( 'user_id', auth ()->id () )
            ->select ( 'for_date' )
            ->distinct ()
            ->orderBy ( 'for_date', 'asc' )
            ->skip ( $skip )
            ->take ( 10 )
            ->get ();
    }
    public function getTaskAll ( $fromPage, $page )
    {
        $fordate = $fromPage->pluck ( 'for_date' )[$page] ?? null;
        if ( isset ( $fordate ) )
        {
            return Task::where ( 'user_id', auth ()->id () )
                ->with ( 'subtasks' )
                ->whereIn ( 'for_date', [ $fordate ] )
                ->orderBy ( 'for_date', 'asc' )
                ->get ();
        }
        else
        {
            return abort ( 404 );
        }
    }
    public function getClosestTask ()
    {
        $today = Carbon::now ();

        // Temukan tanggal terdekat dari hari ini
        $nearestDate = Task::select ( 'for_date' )
            ->orderByRaw ( 'ABS(DATEDIFF(for_date, ?))', [ $today ] )
            ->first ()
            ->for_date;

        // Ambil semua task dengan tanggal tersebut
        return Task::with ( 'subTasks' )
            ->whereDate ( 'for_date', $nearestDate )
            ->get ();

    }

    public function getTask ( $id )
    {
        return Task::with ( 'subtasks' )->findOrFail ( $id );
    }
    public function updateTask ( $request, $id )
    {
        return Task::findOrFail ( $id )->update ( [
            'name'     => $request[ 'name-task' ],
            'notice'   => $request->notice,
            'for_date' => $request[ 'for-date' ],
            'start_at' => $request[ 'start-at' ],
            'duration' => $request[ 'duration' ],
        ] );
    }
    public function deleteTask ( $id )
    {
        return Task::findOrFail ( $id )->delete ();
    }
}
