<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return to_route("admins");
    } else {
        return to_route("login");
    }
})->name("index");

//start auth
Route::middleware("guest")->group(function() {
    Route::get("/admin", [\App\Http\Controllers\AuthController::class, "login"])->name("login");
    Route::post("/login/action", [\App\Http\Controllers\AuthController::class, "login_action"])->name("login_action");
});

Route::middleware("auth")->group(function () {
    Route::get("/logout", [\App\Http\Controllers\AuthController::class, "logout"])->name('logout');
//end auth

//start admin
    Route::get("/admins", [\App\Http\Controllers\AdminController::class, "admins"])->name('admins');
//end admin

//start user
    Route::get("/users", [\App\Http\Controllers\UserController::class, "users"])->name('users')->withTrashed();
    Route::get("/user/{user:username}", [\App\Http\Controllers\UserController::class, "users_detail"])->name('users_detail');
    Route::post("/users/block/{user}", [\App\Http\Controllers\UserController::class, "block"])->name('block')->withTrashed();
    Route::post("/users/restore/{user}", [\App\Http\Controllers\UserController::class, "restore"])->name('restore')->withTrashed();
//end user

//start game
    Route::get("/games", [\App\Http\Controllers\GameController::class, "games"])->name('games');
    Route::get("/game/{game:slug}", [\App\Http\Controllers\GameController::class, "games_detail"])->name('games_detail');
    Route::post("/games/delete/{game}", [\App\Http\Controllers\GameController::class, "deletes"])->name('delete')->withTrashed();
    Route::post("/games/restore/{game}", [\App\Http\Controllers\GameController::class, "restores"])->name('restores')->withTrashed();
    Route::post("/games/scores/delete/{score}", [\App\Http\Controllers\GameController::class, "delete_score"])->name('delete_score')->withTrashed();
    Route::post("/games/scores/delete_all/{game}", [\App\Http\Controllers\GameController::class, "delete_all"])->name('delete_all')->withTrashed();
//end game
});
