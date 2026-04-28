@extends("common")

@section("content")
    <div class="col-flex gap">
        <h2>Game Detail</h2>

        <div class="flex gap aie">
            <div class="img border">
                @if($game->hasThumbnail())
                    <img src="{{ asset("public/".$game->latestVersion->getThumbnail()) }}" alt="thumbnail" title="thumbnail">
                @endif
            </div>

            <div class="col-flex gap">
                <h3>{{ $game->title }}</h3>
                <p>created: {{ $game->created_at }}</p>
            </div>
        </div>

        <div class="flex gap aic">
            <h3>Scores</h3>
            <form action="{{ route("delete_all", $game->id) }}" method="POST">
                @csrf
                <button class="btn btn-danger">All Delete</button>
            </form>
        </div>

        <div class="table" style="--i: 3">
            <div class="item">
                <p>username</p>
                <p>score</p>
                <p>action</p>
            </div>

            @foreach($game->scores as $v)
                <div class="item">
                    <p>{{ $v->user->username }}</p>
                    <p>{{ $v->score }}</p>

                    <form action="{{ route("delete_score", $v['id']) }}" method="POST">
                        @csrf
                        <div class="btns flex gap">
                            <button class="btn btn-danger" name="type" value="bulk">Bulk Delete</button>
                            <button class="btn btn-danger" name="type" value="one">Delete</button>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<style>
    .img {
        width: 400px;
        height: 300px;
    }
</style>
