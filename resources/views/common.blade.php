<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <link rel="stylesheet" href="{{ asset("public/bootstrap.css") }}">
    <link rel="stylesheet" href="{{ asset("public/style.css") }}">

    <script>
        @if($errors->any())
            alert(@json($errors->first()));
        @endif
        @if(session("msg"))
            alert(@json(session('msg'));
        @endif
    </script>
</head>
<body>
<header>
    <div class="container">
        <h1>Gaming Platform</h1>

        <nav class="flex gap">
            @auth
                <a href="{{ route("admins") }}">admin users</a>
                <a href="{{ route("users") }}">platform users</a>
                <a href="{{ route("games") }}">manage games</a>
                <a href="{{ route("logout") }}">Logout</a>
            @else
                <a href="{{ route("login") }}">Login</a>
            @endauth
        </nav>
    </div>
</header>

<main>
    <div class="screen">
        <div class="container">
            @yield("content")
        </div>
    </div>
</main>
</body>
</html>

<style>

</style>
