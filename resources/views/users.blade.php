@extends('common')

@section("content")
    <div class="col-flex gap">
        <h2>Manage Platform Users</h2>

        <div class="table" style="--i: 4">
            <div class="item">
                <p>username</p>
                <p>created timestamp</p>
                <p>last login timestamp</p>
                <p>action</p>
            </div>

            @foreach($users as $v)
                <div class="item">
                    <a href="{{ route("users_detail", $v['username']) }}">{{ $v['username'] }}</a>
                    <p>{{ $v['created_at'] }}</p>
                    <p>{{ $v['lastLogin'] }}</p>

                    <div class="btns">
                        @if($v->trashed())
                            <form action="{{ route("restore", $v['id']) }}" method="POST">
                                @csrf
                                <button class="btn btn-success">Restore</button>
                            </form>
                        @else
                        <form class="por" action="{{ route("block", $v['id']) }}" method="POST">
                            @csrf
                            <button type="button" class="btn btn-danger">Block</button>

                            <div class="list">
                                <button type="submit" name="reason" value="You have been blocked for spamming" class="btn btn-danger">spamming</button>
                                <button type="submit" name="reason" value="You have been blocked for cheating" class="btn btn-danger">cheating</button>
                                <button type="submit" name="reason" value="You have been blocked by an administrator" class="btn btn-danger">other</button>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<style>
    .list {
        position: absolute;
        top: 80%;
        left: 50%;
        transform: translateX(-50%);
        transition: .3s .3s;
        display: flex;
        flex-direction: column;
        background: #fff;
        border-radius: 5px;
        padding: .5rem 1rem;
        gap: .5rem;
        opacity: 0;
        pointer-events: none;
        z-index: 2;
        box-shadow: 0 0 3px #0003;
    }

    .list:hover,
    .btn-danger:focus ~ .list {
        opacity: 1;
        pointer-events: all;
        top: 100%;
        transition: .3s;
    }
</style>
