<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Score;
use Illuminate\Http\Request;

class GameController extends Controller
{
//    show game lists
    public function games()
    {
        if (!@$_GET['search'] || $_GET['search'] == "") {
            $games = Game::withTrashed()->get();
        } else {
            $games = Game::withTrashed()->where("title", "LIKE", "%".$_GET['search']."%")->get();
        }
        return view("games", compact("games"));
    }

//    softDelete the game
    public function deletes(Game $game)
    {
        $game->delete();
        return to_route("games")->with("msg", "Game deleted.");
    }

//    restore the game
    public function restores(Game $game)
    {
        $game->restore();
        return to_route("games")->with("msg", "Game restored.");
    }

//    view game's detail
    public function games_detail(Game $game)
    {
        return view("game_detail", compact("game"));
    }

//    bulk or single score delete
    public function delete_score(Request $request, Score $score)
    {
        $id = $score->game_version->game->slug;
        $user_id = $score->user->id;

        if ($request->type == "bulk") {
            $s = $score->game_version->game->scores;

            foreach ($s as $v) {
                if ($v['user_id'] == $user_id) {
                    $v->delete();
                }
            }
        } else {
            $score->delete();
        }

        return to_route("games_detail", $id)->with("msg", "Score deleted");
    }

//    delete all score in game
    public function delete_all(Game $game)
    {
        $s = $game->scores;

        foreach ($s as $v) {
            $v->delete();
        }

        return to_route("games_detail", $game->slug)->with("msg", "Score deleted");
    }
}
