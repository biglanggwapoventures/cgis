<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HarvestLine extends Model
{
    protected $fillable = [
        'harvest_id',
        'column_id',
        'vehicle_plate_number',
        'withdrawal_slip',
        'farm_num_heads',
        'actual_num_heads',
        'farm_average_live_weight',
        'actual_average_live_weight',
        'doa_count',
    ];

    public function harvest()
    {
        return $this->belongsTo('App\Harvest');
    }
}
