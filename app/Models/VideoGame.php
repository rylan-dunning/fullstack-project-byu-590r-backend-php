<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VideoGame extends Model
{    
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'file',
        'year',
        'esrb_rating_id'
    ];

    /**
     * Get the ESRB rating for this game.
     */
    
    public function esrbRating()
    {
        return $this->belongsTo(EsrbRating::class);
    }

}
