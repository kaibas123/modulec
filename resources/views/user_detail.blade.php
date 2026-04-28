@extends('common')

@section("content")
    <div class="col-flex gap">
        <h2>User Info</h2>
        <h3>{{ $user['username'] }}</h3>
        <p>created: {{ $user['created_at'] }}</p>
        <p>last login: {{ $user['lastLogin'] }}</p>
    </div>
@endsection
