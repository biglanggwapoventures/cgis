<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mortality extends Model
{
    protected $fillable = [
        'daily_log_id',
        'deck_id',
        'num_am',
        'num_pm',
    ];

    public function dailyLog()
    {
        return $this->belongsTo('App\DailyLog');
    }
}
