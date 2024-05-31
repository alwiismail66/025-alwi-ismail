<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/home.css') }}">
        <title>My Task</title>
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
                    <h2># my task</h2>
                </header>
                <main class="section">
                    <table>
                        <thead>
                            <tr>
                                <th>task name</th>
                                <th>subtask</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (filled($data))
                                @foreach ($data as $task)
                                    <tr>
                                        <td class="task main" style="vertical-align: middle"
                                            @if (filled($task->subtasks)) rowspan="{{ count($task->subtasks) }}" @endif>
                                            <h4>{{ $task->name }}</h4>
                                            <p class="status">status : {{ $task->status ?? ' - ' }}</p>
                                            <p class="status">for date : {{ $task['for_date'] }}</p>
                                        </td>
                                        <td class="task">
                                            {{ $task->subtasks->first()->name ?? '-' }}</td>
                                        <td class="task"
                                            @if (filled($task->subtasks)) rowspan="{{ count($task->subtasks) }}" @endif>
                                            <a href="{{ route('task.detail', ['id' => $task->id]) }}">
                                                <span class="detail">detail</span></a>
                                            @if ($task['can_edit'] == true)
                                                <a href="{{ route('task.edit', ['id' => $task->id]) }}">
                                                    <span class="edit">edit</span></a>
                                            @endif
                                            <a href="{{ route('task.delete', ['id' => $task->id]) }}">
                                                <span class="delete">delete</span></a>
                                        </td>
                                    </tr>
                                    @if (count($task->subtasks))
                                        @foreach ($task->subtasks->skip(1) as $subtask)
                                            <tr>
                                                <td class="task">{{ $subtask->name }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">
                                        <h4 style="text-align: center;">you don't have a task
                                            <a href="{{ route('task.showAdd') }}" class="create-task">
                                                create a task now !
                                            </a>
                                        </h4>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot class="my-task">
                            <tr>
                                <td>
                                    <div>
                                        <p>for date :</p>
                                        <p>page :</p>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="arrow">
                                        <a class="page"
                                            href="{{ route('task.showTask', ['page' => $page > 1 ? $page - 1 : $page]) }}">
                                            <span>&lt;</span>
                                        </a>
                                    </div>
                                    @foreach ($dates as $date)
                                        <div class="page">
                                            <a class="page" href="{{ route('task.showTask', ['page' => $page]) }}">
                                                <p>{{ $date['date'] }}</p>
                                                <p>{{ $page++ }}</p>
                                            </a>
                                        </div>
                                    @endforeach
                                    <div class="arrow">
                                        <a class="page" href="{{ route('task.showTask', ['page' => $page]) }}">
                                            <span>&gt;</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </main>
            </section>
        </main>
    </body>

</html>
