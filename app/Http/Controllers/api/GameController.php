<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            "page" => "integer|min:0",
            "size" => "integer|min:1",
            "sortBy" => "in:title,popular,uploaddate",
            "sortDir" => "in:asc,desc",
        ]);

        $page = $request->get("page", 0);
        $size = $request->get("size", 10);
        $sortBy = $request->get("sortBy", "title");
        $sortDir = $request->get("sortDir", "asc");

        $sortBy = $sortBy == "popular" ? "scoreCount" : ($sortBy == "title" ? "title" : "uploadTimestamp");

        $game = Game::query()
            ->with("latestVersion")
            ->whereHas("latestVersion")
            ->skip($page * $size)
            ->take($size)
            ->get()
            ->sortBy(function($v) use($sortBy) {
                return $v[$sortBy];
            }, SORT_REGULAR, $sortDir === "desc")
            ->map(fn($v) => Arr::except($v->toArray(), ["scores_cound", "id", "user_id", "created_at", "updated_at", "deleted_at", "gamePath", "latest_version", "game_author"]))
            ->values();

        return response()->json([
            "page" => $page,
            "size" => $size,
            "totalElements" => GameVersion::query()->groupBy("game_id")->count(),
            "content" => $game->toArray()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $val = $request->validate([
            "title" => "required|min:3|max:60",
            "description" => "required|min:0|max:200"
        ]);

        $val['slug'] = str_replace(" ", '-', Str::lower($request->title));
        $val['user_id'] = auth()->user()->id;

        if (Game::query()->where("slug", $val['slug'])->first()) {
            return response()->json([
                "status" => "invalid",
                "slug" => "Game title already exists"
            ], 400);
        }

        Game::query()->create($val);

        return response()->json([
            "status" => "success",
            "slug" => $val['slug']
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        $game = Arr::except($game->toArray(), ["id", "user_id", "created_at", "updated_at", "deleted_at", "latest_version"]);

        return response()->json($game);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $val = $request->validate([
            "title" => "min:3|max:60",
            "description" => "min:0|max:200"
        ]);

        if ($game['user_id'] !== auth()->user()->id) {
            return response()->json([
                "status" => "forbidden",
                "message" => "You are not the game author"
            ], 403);
        }

        if (!$request->title) $val['title'] = $game->title;
        if (!$request->description) $val['description'] = $game->description;

        $game->update($val);

        return response()->json([
            "status" => "success",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        if ($game['user_id'] !== auth()->user()->id) {
            return response()->json([
                "status" => "forbidden",
                "message" => "You are not the game author"
            ], 403);
        }

        $game->delete();

        return response()->noContent();
    }
}
