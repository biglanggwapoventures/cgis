<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'farm_id',
        'name',
        'description',
    ];

    public function decks()
    {
        return $this->hasMany('App\Deck');
    }

    public function farm()
    {
        return $this->belongsTo('App\Farm');
    }
}
