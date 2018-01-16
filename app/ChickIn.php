<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChickIn extends Model
{
    protected $fillable = [
        'grow_id',
        'column_id',
        'num_heads',
        'num_dead',
        'chick_in_date',
        'reference_number',
    ];

    public function grow()
    {
        return $this->belongsTo('App\Grow');
    }
}
