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
}
