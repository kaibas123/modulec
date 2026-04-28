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

    public function getThumbnailAttribute()
    {
        return $this->getThumbnail();
    }
    public function getUploadTimestampAttribute()
    {
        if ($this->latestVersion) {
            return $this->latestVersion->created_at;
        }
        return $this->created_at;
    }
    public function getAuthorAttribute()
    {
        return $this->user->username;
    }
    public function getScoreCountAttribute()
    {
        return $this->scores->count();
    }
    public function getGamePathAttribute()
    {
        return $this->latestVersion ? $this->latestVersion->path : null;
    }

    public function hasThumbnail()
    {
        if ($this->latestVersion && $this->latestVersion->hasThumbnail()) {
            return true;
        }
        return false;
    }

    public function getThumbnail()
    {
        if ($this->hasThumbnail()) {
            return $this->latestVersion->getThumbnail();
        }
        return null;
    }

    public function latestVersion()
    {
        return $this->hasOne(GameVersion::class)->latestOfMany();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scores()
    {
        return $this->hasManyThrough(Score::class, GameVersion::class);
    }

    public function versions()
    {
        return $this->hasMany(GameVersion::class);
    }
}
