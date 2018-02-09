<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Harvest extends Model
{
    protected $fillable = [
        'grow_id',
        'harvest_date',
        'remarks',
    ];

    public function grow()
    {
        return $this->belongsTo('App\Grow');
    }

    public function line()
    {
        return $this->hasMany('App\HarvestLine');
    }
}
