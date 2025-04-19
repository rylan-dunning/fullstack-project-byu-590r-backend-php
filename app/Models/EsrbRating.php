<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EsrbRating extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description'
    ];

    /**
     * Get the video games for this rating.
     */
    public function videoGames()
    {
        return $this->hasMany(VideoGame::class);
    }
}