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
            <form method="POST" action="{{ route('userSignup') }}" id="signup" autocomplete="on">
                @csrf
                <input class="@error('email') is-invalid @enderror" type="email" id="email" name="email"
                    placeholder="Email" maxlength="30" value="{{ old('email') }}">
                <input class="@error('name') is-invalid @enderror" type="text" id="name" name="name"
                    placeholder="Name" maxlength="30" value="{{ old('name') }}">
                <input class="@error('password') is-invalid @enderror" type="password" id="password" name="password"
                    placeholder="Password" maxlength="30">
                <input class="@error('password_confirmation') is-invalid @enderror" type="password"
                    id="password_confirmation" name="password_confirmation" placeholder="Repeat Password"
                    maxlength="30">
                @if ($errors->any())
                    <p class="error">{{ $errors->all()[0] }}</p>
                @endif
                <button type="submit">Sign Up</button>
            </form>
            <p>Already have an account ? <a href="{{ route('userShowSignin') }}">Sign In</a></p>
        </section>
    </main>
</body>

</html>
