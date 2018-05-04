<?php
namespace App\Services;

use DB;

class GrowService
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getHeadsPerDeck()
    {
        $result = DB::table('chick_ins')
            ->select(DB::raw('SUM(chick_ins.num_heads - chick_ins.num_dead) AS total_heads'), 'columns.deck_id')
            ->join('columns', 'columns.id', '=', 'chick_ins.column_id')
            ->where('chick_ins.grow_id', $this->id)
            ->groupBy('columns.deck_id')
            ->get();

        return $result->pluck('total_heads', 'deck_id');
    }

    public function getHeadsPerDeckAfterDay($dayCount)
    {
        // dd($dayCount)
        $result = DB::table('daily_logs')
            ->select(DB::raw('SUM(mortalities.num_am + mortalities.num_pm) AS total_mortality'), 'mortalities.deck_id')
            ->join('mortalities', 'mortalities.daily_log_id', '=', 'daily_logs.id')
            ->where([
                ['daily_logs.grow_id', '=', $this->id],
                ['daily_logs.day_count', '<=', $dayCount],
            ])
            ->groupBy('mortalities.deck_id')
            ->get()
            ->pluck('total_mortality', 'deck_id');

        $gross = $this->getHeadsPerDeck();

        // dd($result);

        return $gross->mapWithKeys(function ($num, $deck) use ($result) {
            $total = $result->has($deck) ? ($num - $result->get($deck)) : $num;
            return [$deck => $total];
        });
    }

    public function getFeedStock($point = null)
    {
        $result = DB::table('feed_logs')
            ->select(DB::raw('SUM(quantity) AS total_quantity'), 'feed_id')
            ->when($point, function ($q) use ($point) {
                return $q->where('daily_log_id', '<', $point);
            })
            ->groupBy('feed_id')
            ->get()
            ->pluck('total_quantity', 'feed_id');

        return $result;
    }
}
