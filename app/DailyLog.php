<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyLog extends Model
{
    protected $fillable = [
        'date',
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

    public function getTotalMortality()
    {
        return $this->mortalities->sum(function ($mortality) {
            return $mortality->num_am + $mortality->num_pm;
        });
    }

    public function getRemainingChickCountFromDeck($deckId, $lastLogDeckChickCount)
    {
        $deckMortality = $this->mortalities->where('deck_id', $deckId)->first();
        $deckMortalityCount = $deckMortality->num_am + $deckMortality->num_pm;
        return $lastLogDeckChickCount - $deckMortalityCount;
    }

    public function getTotalFeedConsumption($feedId)
    {
        return $this->feedsConsumption->where('feed_id', $feedId)->sum('num_feed');
    }

}
