@extends('common')

@section('content')
    <div class="col-flex gap">
        <h2>Manage Games</h2>

        <form class="flex gap aic">
            <div class="form-floating">
                <input type="text" class="form-control" id="search" name="search" placeholder="1">
                <label for="search">Search</label>
            </div>

            <button class="btn btn-primary">Search</button>
        </form>

        <div class="table" style="--i: 6">
            <div class="item">
                <p>thumbnail</p>
                <p>title</p>
                <p>description</p>
                <p>author</p>
                <p>versions</p>
                <p>action</p>
            </div>

            @foreach($games as $v)
                <div class="item">
                    <div class="img">
                        @if($v->hasThumbnail())
                            <img src="{{ asset("public".$v->getThumbnail()) }}" alt="thumbnail" title="thumbnail">
                        @endif
                    </div>
                    <a href="{{ route("games_detail", $v['slug']) }}">{{ $v['title'] }}</a>
                    <p>{{ $v['description'] }}</p>
                    <p>{{ \App\Models\User::find($v->user_id)->username ?? "" }}</p>

                    <div class="versions col-flex">
                        @foreach($v->versions as $va)
                            <p>{{ $va['created_at'] }}</p>
                        @endforeach
                    </div>

                    <div class="btns">
                        @if($v->trashed())
                            <form class="por" action="{{ route("restores", $v['id']) }}" method="POST">
                                @csrf
                                <button class="btn btn-success">Restore</button>
                            </form>
                        @else
                            <form class="por" action="{{ route("delete", $v['id']) }}" method="POST">
                                @csrf
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
