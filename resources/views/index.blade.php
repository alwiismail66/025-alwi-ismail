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
                <li><a href="">my task</a></li>
                <li><a href="{{ route('taskShowAdd') }}">add task</a></li>
                <li><a href="{{ route('logout') }}">logout</a></li>
            </ul>
        </nav>
    </aside>
    <main>
        <section>
            <header>
                <h2># sunday , 10-05-2025</h2>
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
                        <tr>
                            <td class="task">
                                <h4>playing soccer </h4>
                                <p class="notice">notice : Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                    Doloribus
                                    consectetur cum illum voluptatem. Voluptates, tempora!
                                </p>
                                <p class="startat">start at : 08.00 AM - 09.00 AM</p>
                                <p class="duration">Duration : 1 Hour</p>
                                <p class="progress">progress : 100%</p>
                            </td>
                            <td class="task">-</td>
                            <td class="task">
                                <a href=""><span class="done">done</span></a>
                                <a href=""><span class="undone">undone</span></a>
                            </td>
                        </tr>
                        <tr>
                            <td class="task" rowspan="4">
                                <h4>learnig web programming </h4>
                                <p class="notice">notice : Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                    Doloribus
                                    consectetur cum illum voluptatem. Voluptates, tempora!
                                </p>
                                <p class="startat">start at : 08.00 AM - 09.00 AM</p>
                                <p class="duration">Duration : 1 Hour</p>
                                <p class="progress">progress : 30%</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="task">learn html</td>
                            <td class="task">
                                Completed
                            </td>
                        </tr>
                        <tr>
                            <td class="task">learn css</td>
                            <td class="task">
                                not completed
                            </td>
                        </tr>
                        <tr>
                            <td class="task">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quas magnam ad
                                animi assumenda fuga tenetur libero voluptates modi amet reiciendis.</td>
                            <td class="task">
                                <a href=""><span class="done">done</span></a>
                                <a href=""><span class="undone">undone</span></a>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">overall progress completed</td>
                            <td>80%</td>
                        </tr>
                    </tfoot>
                </table>
            </main>
        </section>
    </main>
</body>

</html>
