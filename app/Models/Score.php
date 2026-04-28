<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
    public function game_version()
    {
        return $this->belongsTo(GameVersion::class);
    }
}
