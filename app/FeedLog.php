<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedLog extends Model
{
    protected $fillable = [
        'causer_id',
        'causer_type',
        'daily_log_id',
        'feed_id',
        'quantity',
        'balance',
    ];

    public function loggable()
    {
        return $this->morphTo();
    }
}
