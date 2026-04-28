<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameVersion;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {
        if ($user['id'] == $request->user()?->id) {
            $game = Game::query()
                ->where("user_id", $user['id'])
                ->get()
                ->map(fn($v) => ([
                    "slug" => $v['slug'],
                    "title" => $v['title'],
                    "description" => $v['description']
                ]));
        } else {
            $game = Game::query()
                ->with("latestVersion")
                ->whereHas("latestVersion")
                ->where("user_id", $user['id'])
                ->get()
                ->map(fn($v) => ([
                    "slug" => $v['slug'],
                    "title" => $v['title'],
                    "description" => $v['description']
                ]));
        }

        $scores = Score::query()
            ->select("games.id, games.description, games.slug, games.title, scores.score, scores.created_at")
            ->where("scores.user_id", $user['id'])
            ->leftJoin("game_versions", "scores.game_version_id", "=", "game_versions.id")
            ->leftJoin("games", "game_versions.game_id", "=", "games.id")
            ->groupBy("games.id")
            ->get()
            ->map(function($v) {
                $scoreGame = GameVersion::query()->where("id", $v->game_version_id)->first()->game;

                return [
                    "game" => [
                        "slug" => $scoreGame->slug,
                        "title" => $scoreGame->title,
                        "description" => $scoreGame->description
                    ],
                    "score" => $v->score,
                    "timestamp" => $v->created_at
                ];
            });

        return response()->json([
           "username" => $user['username'],
           "registeredTimestamp" => $user['created_at'],
           "authoredGames" => $game,
           "highscores" => $scores,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
