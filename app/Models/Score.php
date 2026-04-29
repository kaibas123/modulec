<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
//    get user of score
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

//    get version of score
    public function game_version()
    {
        return $this->belongsTo(GameVersion::class);
    }
}
