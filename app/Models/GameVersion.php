<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class GameVersion extends Model
{
    use SoftDeletes;

//    get version's thumbnail
    public function getThumbnail()
    {
        return $this->path."thumbnail.png";
    }

//    check this version has thumbnail
    public function hasThumbnail()
    {
        if (Storage::disk('local')->exists($this->getThumbnail())) {
            return $this->getThumbnail();
        }
        return null;
    }

//    get game of version
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
