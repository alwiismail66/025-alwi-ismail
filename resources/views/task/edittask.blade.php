<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/task.css') }}">
        <title>Create New Task</title>
    </head>

    <body>
        <aside>
            <header>
                <h1>my to do list</h1>
                <p>hello , buddy</p>
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
                    <h2># create new task</h2>
                </header>
                <form action="{{ route('task.edit') }}" method="POST" id="task-add" autocomplete="on">
                    @method('PUT') @csrf
                    <main class="section">
                        <input type="hidden" name="id" value="{{ $task->id }}">

                        <label for="name-task">name task</label>
                        <input id="name-task" class="@error('name-task')is-invalid @enderror" name="name-task"
                            type="text" value="{{ $task->name ?? old('name-task') }}"
                            @if ($task['can_edit_task'] == false) readonly @endif>

                        <label for="notice">notice</label>
                        <textarea id="notice" class="@error('notice')is-invalid @enderror" name="notice" placeholder="can leave blank"
                            @if ($task['can_edit_task'] == false) readonly @endif>
                            {{ $task->notice ?? old('notice') }}
                        </textarea>

                        <label for="for-date">for date</label>
                        <input id="for-date" class="@error('for-date')is-invalid @enderror" name="for-date"
                            type="date" value="{{ $task->for_date ?? old('for-date') }}"
                            @if ($task['can_edit_task'] == false) readonly @endif>


                        <label for="start-at">start at</label>
                        <input id="start-at" class="@error('start-at')is-invalid @enderror" name="start-at"
                            type="time"
                            value="{{ $task->start_at ?? old('start-at') }}"@if ($task['can_edit_task'] == false) readonly @endif>

                        <label for="duration">duration</label>
                        <input id="duration" class="@error('duration')is-invalid @enderror" name="duration"
                            type="time"
                            value="{{ $task->duration ?? old('duration') }}"@if ($task['can_edit_task'] == false) readonly @endif>

                        <label for="subtask1">subtask 1</label>
                        @if (isset($task->subtasks[0]))
                            <input type="hidden" name="subtask-id[]" value="{{ $task->subtasks[0]->id }}">
                        @endif
                        <input id="subtask1" class="@error('subtask.0')is-invalid @enderror" name="subtask[]"
                            type="text" placeholder="can leave blank"
                            value="{{ $task->subtasks[0]->name ?? old('subtask.0') }}"
                            @if (isset($task->subtasks[0]['can_edit']) && $task->subtasks[0]['can_edit'] == false) readonly @endif>

                        <label for="subtask2">subtask 2</label>
                        @if (isset($task->subtasks[1]))
                            <input type="hidden" name="subtask-id[]" value="{{ $task->subtasks[1]->id }}">
                        @endif
                        <input id="subtask2" class="@error('subtask.1')is-invalid @enderror" name="subtask[]"
                            type="text" placeholder="can leave blank"
                            value="{{ $task->subtasks[1]->name ?? old('subtask.1') }}"
                            @if (isset($task->subtasks[1]['can_edit']) && $task->subtasks[1]['can_edit'] == false) readonly @endif>

                        <label for="subtask3">subtask 3</label>
                        @if (isset($task->subtasks[2]))
                            <input type="hidden" name="subtask-id[]" value="{{ $task->subtasks[2]->id }}">
                        @endif
                        <input id="subtask3" class="@error('subtask.2')is-invalid @enderror" name="subtask[]"
                            type="text" placeholder="can leave blank"
                            value="{{ $task->subtasks[2]->name ?? old('subtask.2') }}"
                            @if (isset($task->subtasks[2]['can_edit']) && $task->subtasks[2]['can_edit'] == false) readonly @endif>

                        <label for="subtask4">subtask 4</label>
                        @if (isset($task->subtasks[3]))
                            <input type="hidden" name="subtask-id[]" value="{{ $task->subtasks[3]->id }}">
                        @endif
                        <input id="subtask4" class="@error('subtask.3')is-invalid @enderror" name="subtask[]"
                            type="text" placeholder="can leave blank"
                            value="{{ $task->subtasks[3]->name ?? old('subtask.3') }}"
                            @if (isset($task->subtasks[3]['can_edit']) && $task->subtasks[3]['can_edit'] == false) readonly @endif>

                        <label for="subtask5">subtask 5</label>
                        @if (isset($task->subtasks[4]))
                            <input type="hidden" name="subtask-id[]" value="{{ $task->subtasks[4]->id }}">
                        @endif
                        <input id="subtask5" class="@error('subtask.4')is-invalid @enderror" name="subtask[]"
                            type="text" placeholder="can leave blank"
                            value="{{ $task->subtasks[4]->name ?? old('subtask.4') }}"
                            @if (isset($task->subtasks[5]['can_edit']) && $task->subtasks[4]['can_edit'] == false) readonly @endif>
                        <button type="submit">Edit</button>
                        @if ($errors->any())
                            <p class="error">{{ $errors->all()[0] }}</p>
                        @endif
                    </main>
                </form>
            </section>
        </main>
    </body>

</html>
