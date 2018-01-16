<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedsConsumption extends Model
{
    protected $fillable = [
        'daily_log_id',
        'deck_id',
        'feed_id',
        'num_feed',
    ];

    public function dailyLog()
    {
        return $this->belongsTo('App\DailyLog');
    }
}
