<?php

namespace App;

use App\FeedLog;
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

    public function log()
    {
        return $this->morphOne(FeedLog::class, 'loggable', 'causer_type', 'causer_id');
    }

    public function saveLog()
    {
        return $this->log()->updateOrCreate(
            ['causer_type' => get_class($this), 'causer_id' => $this->id, 'daily_log_id' => $this->daily_log_id],
            ['feed_id' => $this->feed_id, 'quantity' => $this->num_feed, 'balance' => 0]
        );
    }
}
