<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\GameVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\PersonalAccessToken;
use Mockery\Exception;

class VersionController extends Controller
{
//    function for save new version
    public function store(Game $game, Request $request)
    {
        $request->validate([
            "zipfile" => "required|file",
            "token" => "required"
        ]);

        $token = PersonalAccessToken::findToken($request->get("token"));
        if (!$token) {
            return response("Unauthorized", 401);
        }

        $user = $token->tokenable;
        if ($user->id !== $game->user_id) {
            return response("A game can only be updated by the author", 403);
        }

        $version = "v1";

        if ($game->latestVersion) {
            $version = "v".((int) substr($game->latestVersion->version, 1)) + 1;
        }

        $zip = new \ZipArchive();
        if (!$zip->open($request->file("zipfile")->getRealPath())) {
            return response("ZIP file cannot be opened", 400);
        }

        $storagePath = "games/".$game->slug."/".$version;
        $absolutePath = Storage::disk("local")->path($storagePath);

        if (!Storage::disk("local")->exists($storagePath)) {
            try {
                if (!Storage::makeDirectory($storagePath, 0777, true)) {
                    return response("Storage path (".$storagePath.") cannot be created", 500);
                }
            } catch (Exception $e) {
                return response("Storage path (".$storagePath.") cannot be created", 500);
            }
        }

        $zip->extractTo($absolutePath);
        $zip->close();

        chmod($absolutePath, 0777);

        foreach (GameVersion::query()->where("game_id", $game->id)->get() as $v) {
            $v->delete();
        }

        GameVersion::query()->create([
            "game_id" => $game->id,
            "version" => $version,
            "path" => $storagePath."/"
        ]);

        return response("Upload successful", 201);
    }
}
