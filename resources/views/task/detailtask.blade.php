<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/home.css') }}">
        <title>Home</title>
    </head>

    <body>
        <aside>
            <header>
                <h1>my to do list</h1>
                <p>hello , {{ auth()->user()->name }}</p>
            </header>
            <nav>
                <ul>
                    <li><a href="{{ route('home') }}">home</a></li>
                    <li><a href="{{ route('task.showTask') }}">my task</a></li>
                    <li><a href="{{ route('task.showAdd') }}">add task</a></li>
                    <li><a href="{{ route('logout') }}">logout</a></li>
                </ul>
            </nav>
        </aside>
        <main>
            <section>
                <header>
                    <h2># task detail</h2>
                </header>
                <main class="section">
                    <table>
                        <thead>
                            <tr>
                                <th>task name</th>
                                <th>subtask</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action="{{ route('task.toggleStatus') }}" method="POST">
                                @method('PUT') @csrf
                                @if (filled($task))
                                    <tr>
                                        <td class="task main" rowspan="{{ count($task->subtasks) + 1 }}">
                                            <h4>{{ $task->name }}</h4>
                                            <p class="startat">for date : {{ $task->for_date }}</p>
                                            <p class="notice">notice : {{ $task->notice ?? ' - ' }}
                                            </p>
                                            <p class="startat">start at : {{ substr($task->start_at, 0, 5) }}</p>
                                            <p class="duration">Duration : {{ substr($task->duration, 0, 5) }}</p>
                                            <p class="progress">progress : {{ $task->progress }}%</p>
                                            <p class="status">status : {{ $task->status ?? 'not complete' }}</p>
                                            <p class="progress">created at : {{ $task->created_at }}</p>
                                            <p class="progress">updated at : {{ $task->updated_at }}</p>
                                        </td>
                                        @if (count($task->subtasks))
                                            @foreach ($task->subtasks as $subtask)
                                    </tr>
                                    <tr>
                                        <td class="task">{{ $subtask->name }}</td>
                                        <td class="task">
                                            @if (filled($subtask->status))
                                                <p>{{ $subtask->status }}</p>
                                            @elseif ($task['expired_status'] == true)
                                                <p>expired</p>
                                            @else
                                                <button name="subtask" class="done" type="submit"
                                                    value="subtask,100,{{ $subtask->id }}">done</button>
                                                <button name="subtask" class="undone" type="submit"
                                                    value="subtask,0,{{ $subtask->id }}">undone</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <td class="task"> - </td>
                                <td class="task">
                                    @if (filled($task->status))
                                        <p>{{ $task->status }}</p>
                                    @elseif ($task['expired_status'] == true)
                                        <p>expired</p>
                                    @else
                                        <button name="task" class="done" type="submit"
                                            value="task,100,{{ $task->id }}">done</button>
                                        <button name="task" class="undone" type="submit"
                                            value="task,0,{{ $task->id }}">undone</button>
                                    @endif
                                </td>
                                </tr>
                                @endif
                            @else
                                <tr>
                                    <td colspan="3">
                                        <h4 style="text-align: center;">no task for today</h4>
                                    </td>
                                </tr>
                                @endif
                            </form>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    @if ($task['can_edit'] == true)
                                        <a href="{{ route('task.edit', ['id' => $task->id]) }}">
                                            <span class="edit">edit</span></a>
                                    @endif
                                    <a href="{{ route('task.delete', ['id' => $task->id]) }}">
                                        <span class="delete">delete</span></a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </main>
            </section>
        </main>
    </body>

</html>
