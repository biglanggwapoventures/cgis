<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Grow extends Model
{
    protected $fillable = [
        'grow_code',
        'remarks',
        'start_date',
    ];

    public function chickIns()
    {
        return $this->hasMany('App\ChickIn');
    }

    public function dailyLogs()
    {
        return $this->hasMany('App\DailyLog');
    }

    public function latestDailyLog()
    {
        return $this->dailyLogs()->latest()->limit()->first();
    }

    public function decksUsed()
    {
        $ids = DB::table('decks AS d')
            ->selectRaw('DISTINCT d.id')
            ->join('columns AS c', 'c.deck_id', '=', 'd.id')
            ->join('chick_ins AS ci', 'ci.column_id', '=', 'c.id')
            ->where('ci.grow_id', '=', $this->id)
            ->where('ci.num_heads', '>', 0)
            ->get();

        return $ids->pluck('id');
    }

    public function dailyLogsCount()
    {
        return $this->hasOne('App\DailyLog')
            ->selectRaw('grow_id, count(*) as count')
            ->groupBy('grow_id');
    }

    public function harvests()
    {
        return $this->hasMany('App\Harvest', 'grow_id');
    }

    public function totalChicks()
    {
        return intval($this->chickIns->sum('num_heads'));
    }

    public function totalDOA()
    {
        return intval($this->chickIns->sum('num_dead'));
    }

    public function netChicks()
    {
        return $this->totalChicks() - $this->totalDOA();
    }

    public function generateReport()
    {
        $dailyLogs = $this->dailyLogs()
            ->with([
                'mortalities' => function ($q) {
                    $q->selectRaw('SUM(num_am) as num_am, SUM(num_pm) as num_pm, SUM(num_am + num_pm) as total_mortalities, daily_log_id')->groupBy('daily_log_id');
                },
                'feedsConsumption' => function ($q) {
                    $q->selectRaw('SUM(num_feed) as num_feed, daily_log_id, feed_id')->groupBy('daily_log_id')->groupBy('feed_id');
                },
                'feedsDeliveries' => function ($q) {
                    $q->selectRaw('SUM(num_feed) as num_feed, daily_log_id, feed_id')->groupBy('daily_log_id')->groupBy('feed_id');
                },
                'weightRecords' => function ($q) {
                    $q->selectRaw('SUM(recorded_weight) as recorded_weight, daily_log_id, deck_id')->groupBy('daily_log_id')->groupBy('deck_id')->orderBy('deck_id');
                },
                'weightRecords.deck',
            ])
            ->get()
            ->pluck(null, 'day_count')
            ->toArray();

        $dailyLogs = array_merge([
            'grow_code' => $this->grow_code,
            'total_chicks' => $this->totalChicks(),
            'total_DOA' => $this->totalDOA(),
            'net_chicks' => $this->netChicks(),
            'daily_logs' => $dailyLogs,
        ]);

        return $dailyLogs;
    }

    public function getTotalMortalityFromLogs()
    {
        return $this->dailyLogs->sum(function ($log) {
            return $log->mortalities->sum(function ($mortality) {
                return $mortality->num_am + $mortality->num_pm;
            });
        });
    }

    public function getTotalMortality()
    {
        return $this->getTotalMortalityFromLogs() + $this->chickIns->sum('num_dead');
    }

    public function getTotalChickIns()
    {
        return $this->chickIns->sum('num_heads');
    }

    public function getTotalFeedConsumption($feedId)
    {
        return $this->dailyLogs->sum(function ($log) use ($feedId) {
            return $log->getTotalFeedConsumption($feedId);
        });
    }

    public function getTotalFeedsDelivered($feedId)
    {
        return $this->dailyLogs->sum(function ($log) use ($feedId) {
            return $log->feedsDeliveries->where('feed_id', $feedId)->first()->num_feed;
        });
    }

    public function scopeOngoing($query)
    {
        return $query->whereNull('end_date')->latest();
    }
}
