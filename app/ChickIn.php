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

    protected $appends = [
        'net_chicks',
    ];

    public function grow()
    {
        return $this->belongsTo('App\Grow');
    }

    public function getNetChicksAttribute()
    {
        return $this->num_heads - $this->num_dead;
    }
}
