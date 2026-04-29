<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use SoftDeletes;

    protected $appends = ["thumbnail", "uploadTimestamp", "author", "scoreCount", "gamePath"];
    protected $hidden = ["user", "scores"];

//    add thumbnail path in result
    public function getThumbnailAttribute()
    {
        return $this->getThumbnail();
    }

    //    add uploadTimestamp path in result
    public function getUploadTimestampAttribute()
    {
        if ($this->latestVersion) {
            return $this->latestVersion->created_at;
        }
        return $this->created_at;
    }

    //    add author path in result
    public function getAuthorAttribute()
    {
        return $this->user->username;
    }

    //    add scoreCount path in result
    public function getScoreCountAttribute()
    {
        return $this->scores->count();
    }

    //    add gamePath path in result
    public function getGamePathAttribute()
    {
        return $this->latestVersion ? $this->latestVersion->path : null;
    }

    //    check this game has thumbnail
    public function hasThumbnail()
    {
        if ($this->latestVersion && $this->latestVersion->hasThumbnail()) {
            return true;
        }
        return false;
    }

//    get game's thumbnail path
    public function getThumbnail()
    {
        if ($this->hasThumbnail()) {
            return $this->latestVersion->getThumbnail();
        }
        return null;
    }

//    get game's latest version
    public function latestVersion()
    {
        return $this->hasOne(GameVersion::class)->latestOfMany();
    }

//    get author of this game
    public function user()
    {
        return $this->belongsTo(User::class);
    }

//    get all scores of this game
    public function scores()
    {
        return $this->hasManyThrough(Score::class, GameVersion::class);
    }

//    get all versions of this game
    public function versions()
    {
        return $this->hasMany(GameVersion::class);
    }
}
