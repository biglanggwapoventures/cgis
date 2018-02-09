<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyLog extends Model
{
    protected $fillable = [
        'grow_id',
        'day_count',
        'remarks',
    ];

    public function mortalities()
    {
        return $this->hasMany('App\Mortality');
    }

    public function feedsConsumption()
    {
        return $this->hasMany('App\FeedsConsumption');
    }

    public function feedsDeliveries()
    {
        return $this->hasMany('App\FeedsDelivery');
    }

    public function weightRecords()
    {
        return $this->hasMany('App\WeightRecord');
    }

    public function previousDayCount()
    {
        return (int) $this->day_count ? ($this->day_count - 1) : 0;
    }
}
