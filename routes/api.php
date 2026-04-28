<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix("v1")->group(function() {
    Route::post("auth/signup", [\App\Http\Controllers\api\AuthController::class, "signup"]);
    Route::post("auth/signin", [\App\Http\Controllers\api\AuthController::class, "signin"]);

    Route::middleware("auth:sanctum")->group(function() {
        Route::post("auth/signout", [\App\Http\Controllers\api\AuthController::class, "signout"]);

        Route::post("games", [\App\Http\Controllers\api\GameController::class, "store"]);
        Route::put("games/{game:slug}", [\App\Http\Controllers\api\GameController::class, "update"]);
        Route::DELETE("games/{game:slug}", [\App\Http\Controllers\api\GameController::class, "destroy"]);
        Route::post("games/{game:slug}/scores", [\App\Http\Controllers\api\ScoreController::class, "store"]);
        Route::post("games/{game:slug}/upload", [\App\Http\Controllers\api\VersionController::class, "store"]);
        Route::get("users/{user:username}", [\App\Http\Controllers\api\UserController::class, "show"]);
    });

    Route::get("games", [\App\Http\Controllers\api\GameController::class, "index"]);
    Route::get("games/{game:slug}", [\App\Http\Controllers\api\GameController::class, "show"]);
    Route::get("games/{game:slug}/scores", [\App\Http\Controllers\api\ScoreController::class, "index"]);
});
