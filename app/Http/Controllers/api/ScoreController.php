<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Game $game)
    {
        $scores = $game->scores()->get()->map(fn($v) => ([
            "username" => $v->user->username,
            "score" => $v['score'],
            "timestamp" => $v['created_at']
        ]));

        return response()->json([
            "scores" => $scores
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Game $game)
    {
        Score::query()->create([
            "user_id" => auth()->user()->id,
            "game_version_id" => $game->latestVersion->id,
            "score" => $request->score
        ]);

        return response()->json([
            "status" => "success"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
