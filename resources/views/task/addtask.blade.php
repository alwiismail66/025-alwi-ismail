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
            <form action="">
                <main class="section">
                    <label for="name">Name</label>
                    <input id="name" type="text" placeholder="John Doe">
                    <label for="notice">notice</label>
                    <textarea name="" id="notice" placeholder="example : tell tom to play"></textarea>
                    <label for="date">for date</label>
                    <input id="date" type="date">
                    <label for="startAt">start at</label>
                    <input id="startAt" type="time">
                    <label for="duration">duration</label>
                    <input id="duration" type="time">
                    <button>submit</button>
                </main>
            </form>
        </section>
    </main>
</body>

</html>
