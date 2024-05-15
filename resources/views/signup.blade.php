<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <title>Sign Up</title>
</head>

<body>
    <main>
        <header>
            <h1>welcome to my to do list</h1>
            <p>create your account</p>
        </header>
        <section>
            <form action="" name="signup" target="">
                <input type="email" id="email" name="email" placeholder="Email" maxlength="30" required>
                <input type="text" id="name" name="name" placeholder="Name" maxlength="30" required>
                <input type="password" id="password" name="password" placeholder="Password" maxlength="30" required>
                <input type="password" id="repeatPassword" name="repeat_password" placeholder="Repeat Password"
                    maxlength="30" required>
                <button>Sign Up</button>
            </form>
            <p>Already have an account ? <a href="{{ route('signin') }}">Sign In</a></p>
        </section>
    </main>
</body>

</html>
