@extends('common')

@section("content")
    <div class="col-flex gap">
        <h2>List Admin Users</h2>

        <div class="table" style="--i: 3">
            <div class="item">
                <p>username</p>
                <p>created timestamp</p>
                <p>last login timestamp</p>
            </div>

            @foreach(\App\Models\Admin::all() as $v)
                <div class="item">
                    <p>{{ $v['username'] }}</p>
                    <p>{{ $v['created_at'] }}</p>
                    <p>{{ $v['lastLogin'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
