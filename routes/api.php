<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//add /v1 to all of api path
Route::prefix("v1")->group(function() {
//    do signup
    Route::post("auth/signup", [\App\Http\Controllers\api\AuthController::class, "signup"]);
//    do signin
    Route::post("auth/signin", [\App\Http\Controllers\api\AuthController::class, "signin"]);

//    check Authorization token
    Route::middleware("auth:sanctum")->group(function() {
//        do signout
        Route::post("auth/signout", [\App\Http\Controllers\api\AuthController::class, "signout"]);

//        save game data
        Route::post("games", [\App\Http\Controllers\api\GameController::class, "store"]);
//        update separate game data
        Route::put("games/{game:slug}", [\App\Http\Controllers\api\GameController::class, "update"]);
//        delete game data
        Route::DELETE("games/{game:slug}", [\App\Http\Controllers\api\GameController::class, "destroy"]);
//        save game data
        Route::post("games/{game:slug}/scores", [\App\Http\Controllers\api\ScoreController::class, "store"]);
//        upload new game version
        Route::post("games/{game:slug}/upload", [\App\Http\Controllers\api\VersionController::class, "store"]);
//        get separate user data
        Route::get("users/{user:username}", [\App\Http\Controllers\api\UserController::class, "show"]);
    });

//    get all games data
    Route::get("games", [\App\Http\Controllers\api\GameController::class, "index"]);
//        get separate game data
    Route::get("games/{game:slug}", [\App\Http\Controllers\api\GameController::class, "show"]);
//        get game's scores data
    Route::get("games/{game:slug}/scores", [\App\Http\Controllers\api\ScoreController::class, "index"]);
});
