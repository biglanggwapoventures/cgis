<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeightRecord extends Model
{
    protected $fillable = [
        'daily_log_id',
        'deck_id',
        'optimal_weight',
        'recorded_weight',
    ];

    public function dailyLog()
    {
        return $this->belongsTo('App\DailyLog', 'daily_log_id');
    }

    public function deck()
    {
        return $this->belongsTo('App\Deck', 'deck_id');
    }
}
