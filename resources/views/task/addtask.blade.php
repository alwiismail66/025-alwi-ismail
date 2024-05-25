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
                <li><a href="">my task</a></li>
                <li><a href="">add task</a></li>
            </ul>
        </nav>
    </aside>
    <main>
        <section>
            <header>
                <h2># create new task</h2>
            </header>
            <form action="{{ route('task.store') }}" method="POST" id="task-add" autocomplete="on">
                @csrf
                <main class="section">
                    <label for="name-task">name task</label>
                    <input id="name-task" class="@error('name-task')is-invalid @enderror" name="name-task"
                        type="text" value="{{ old('name-task') }}">
                    <label for="notice">notice</label>
                    <textarea id="notice" class="@error('notice')is-invalid @enderror" name="notice" placeholder="can leave blank">{{ old('notice') }}</textarea>
                    <label for="for-date">for date</label>
                    <input id="for-date" class="@error('for-date')is-invalid @enderror" name="for-date" type="date"
                        value="{{ old('for-date') }}">
                    <label for="start-at">start at</label>
                    <input id="start-at" class="@error('start-at')is-invalid @enderror" name="start-at" type="time"
                        value="{{ old('start-at') }}">
                    <label for="duration">duration</label>
                    <input id="duration" class="@error('duration')is-invalid @enderror" name="duration" type="time"
                        value="{{ old('duration') }}">
                    <label for="subtask1">subtask 1</label>
                    <input id="subtask1" class="@error('subtask.0')is-invalid @enderror" name="subtask[]"
                        type="text" placeholder="can leave blank" value="{{ old('subtask.0') }}">
                    <label for="subtask2">subtask 2</label>
                    <input id="subtask2" class="@error('subtask.1')is-invalid @enderror" name="subtask[]"
                        type="text" placeholder="can leave blank" value="{{ old('subtask.1') }}">
                    <label for="subtask3">subtask 3</label>
                    <input id="subtask3" class="@error('subtask.2')is-invalid @enderror" name="subtask[]"
                        type="text" placeholder="can leave blank" value="{{ old('subtask.2') }}">
                    <label for="subtask4">subtask 4</label>
                    <input id="subtask4" class="@error('subtask.3')is-invalid @enderror" name="subtask[]"
                        type="text" placeholder="can leave blank" value="{{ old('subtask.3') }}">
                    <label for="subtask5">subtask 5</label>
                    <input id="subtask5" class="@error('subtask.4')is-invalid @enderror" name="subtask[]"
                        type="text" placeholder="can leave blank" value="{{ old('subtask.4') }}">
                    <button type="submit">submit</button>
                    @if ($errors->any())
                        <p class="error">{{ $errors->all()[0] }}</p>
                    @endif
                </main>
            </form>
        </section>
    </main>
</body>

</html>
