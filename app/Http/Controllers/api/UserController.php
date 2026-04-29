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
     * Display the specified resource.
     */
//    function for load separate user data
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

        $players = [];
        $scores = Score::query()
            ->where("user_id", $user['id'])
            ->orderByDesc("score")
            ->get()
            ->filter(function($v) use(&$players) {
                if (in_array($v->user_id, $players)) {
                    return false;
                }

                array_push($players, $v->user_id);
                return true;
            })
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
            })
            ->values();

        return response()->json([
           "username" => $user['username'],
           "registeredTimestamp" => $user['created_at'],
           "authoredGames" => $game,
           "highscores" => $scores,
        ]);
    }
    
}
