<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedsDelivery extends Model
{
    protected $fillable = [
        'daily_log_id',
        'feed_id',
        'num_feed',
    ];

    public function dailyLog()
    {
        return $this->belongsTo('App\DailyLog');
    }
}
