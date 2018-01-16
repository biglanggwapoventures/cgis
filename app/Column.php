<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Column extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'deck_id',
        'name',
        'description',
    ];

    public function deck()
    {
        return $this->belongsTo('App\Deck');
    }

    public function chickIns()
    {
        return $this->hasMany('App\ChickIn');
    }
}
