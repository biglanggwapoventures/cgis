<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deck extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'building_id',
        'name',
        'description',
    ];

    public function columns()
    {
        return $this->hasMany('App\Column');
    }

    public function building()
    {
        return $this->belongsTo('App\Building');
    }

}
