<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <title>Sign In</title>
</head>

<body>
    <main>
        <header>
            <h1>welcome to my to do list</h1>
            <p>login to your account</p>
        </header>
        <section>
            <form method="POST" action="{{ route('userAuthenticate') }}" id="signin" autocomplete="on">
                @csrf
                <input class="@error('email') is-invalid @enderror" type="email" id="email" name="email"
                    placeholder="Email" maxlength="30" value="{{ old('email') }}">
                <input class="@error('password') is-invalid @enderror" type="password" id="password" name="password"
                    placeholder="Password" maxlength="30">
                @if ($errors->any())
                    <p class="error">{{ $errors->all()[0] }}</p>
                @endif
                <button type="submit">Sign In</button>
            </form>
            <p>Don't hava an account ? <a href="{{ route('userShowSignup') }}">Sign Up</a></p>
        </section>
    </main>
</body>

</html>
