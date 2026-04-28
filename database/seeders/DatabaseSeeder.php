<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Game;
use App\Models\GameVersion;
use App\Models\Score;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::query()->create([
            "username" => "admin1",
            "password" => Hash::make("hellouniverse1!"),
        ]);
        Admin::query()->create([
            "username" => "admin2",
            "password" => Hash::make("hellouniverse2!"),
        ]);
        User::query()->create([
            "username" => "player1",
            "password" => Hash::make("helloworld1!"),
        ]);
        User::query()->create([
            "username" => "player2",
            "password" => Hash::make("helloworld2!"),
        ]);
        User::query()->create([
            "username" => "dev1",
            "password" => Hash::make("hellobyte1!"),
        ]);
        User::query()->create([
            "username" => "dev2",
            "password" => Hash::make("hellobyte2!"),
        ]);

        Game::query()->create([
            "title" => "Demo Game 1",
            "slug" => "demo-game-1",
            "description" => "This is demo game 1",
            "user_id" => 3,
        ]);
        Game::query()->create([
            "title" => "Demo Game 2",
            "slug" => "demo-game-2",
            "description" => "This is demo game 2",
            "user_id" => 4,
        ]);

        GameVersion::query()->create([
            "game_id" => 1,
            "version" => "v1",
            "path" => "/games/demo-game-1/v1/"
        ]);
        GameVersion::query()->create([
            "game_id" => 1,
            "version" => "v2",
            "path" => "/games/demo-game-1/v2/"
        ]);
        GameVersion::query()->create([
            "game_id" => 2,
            "version" => "v1",
            "path" => "/games/demo-game-2/v1/"
        ]);

        Score::query()->create([
            "user_id" => 1,
            "game_version_id" => 1,
            "score" => 10.0,
        ]);
        Score::query()->create([
            "user_id" => 1,
            "game_version_id" => 1,
            "score" => 15.0,
        ]);
        Score::query()->create([
            "user_id" => 1,
            "game_version_id" => 2,
            "score" => 12.0,
        ]);
        Score::query()->create([
            "user_id" => 2,
            "game_version_id" => 2,
            "score" => 20.0,
        ]);
        Score::query()->create([
            "user_id" => 2,
            "game_version_id" => 3,
            "score" => 30.0,
        ]);
        Score::query()->create([
            "user_id" => 3,
            "game_version_id" => 2,
            "score" => 1000.0,
        ]);
        Score::query()->create([
            "user_id" => 3,
            "game_version_id" => 2,
            "score" => -300.0,
        ]);
        Score::query()->create([
            "user_id" => 4,
            "game_version_id" => 2,
            "score" => 5.0,
        ]);
        Score::query()->create([
            "user_id" => 4,
            "game_version_id" => 3,
            "score" => 200.0,
        ]);
    }
}
