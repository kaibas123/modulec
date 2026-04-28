@extends('common')

@section('content')
    <form action="{{ route("login_action") }}" method="POST" class="col-flex gap">
        @csrf

        <h2>Login</h2>

        <div class="form-floating">
            <input type="text" id="username" name="username" placeholder="1" class="form-control">
            <label for="username">Username</label>
        </div>

        <div class="form-floating">
            <input type="password" id="password" name="password" placeholder="1" class="form-control">
            <label for="password">Password</label>
        </div>

        <button class="btn btn-primary">Login</button>
    </form>
@endsection
