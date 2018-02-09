<?php

namespace App\Http\Controllers;

use App\Column;
use App\Grow;
use App\Harvest;
use Illuminate\Http\Request;

class HarvestController extends Controller
{
    public function index(Grow $grow, Request $request)
    {
        return view('grows.harvests-index', [
            'grow' => $grow->load('harvests'),
        ]);
    }

    public function create(Grow $grow)
    {
        $columns = Column::with('deck')
            ->find($grow->chickIns->pluck('column_id'))
            ->mapWithKeys(function ($column) {
                return [$column->id => "{$column->deck->name} {$column->name}"];
            });

        return view('grows.harvests', [
            'grow' => $grow,
            'columns' => $columns,
            'data' => new Harvest,
        ]);
    }

    public function store(Grow $grow, Request $request)
    {
        $request->validate([
            'harvest_date' => 'required|date',
            'line' => 'required|array',
            'line.*.column_id' => 'required|exists:columns,id',
            'line.*.vehicle_plate_number' => 'required',
            'line.*.withdrawal_slip' => 'required',
            'line.*.farm_num_heads' => 'required|numeric',
            'line.*.actual_num_heads' => 'required|numeric',
            'line.*.farm_average_live_weight' => 'required|numeric',
            'line.*.actual_average_live_weight' => 'required|numeric',
            'line.*.doa_count' => 'required|numeric',
        ], [
            'line.*.column_id.required' => 'Please fill this up',
            'line.*.vehicle_plate_number.required' => 'Please fill this up',
            'line.*.withdrawal_slip.required' => 'Please fill this up',
            'line.*.farm_num_heads.required' => 'Please fill this up',
            'line.*.actual_num_heads.required' => 'Please fill this up',
            'line.*.farm_average_live_weight.required' => 'Please fill this up',
            'line.*.actual_average_live_weight.required' => 'Please fill this up',
            'line.*.doa_count.required' => 'Please fill this up',
        ]);

        $harvest = $grow->harvests()->create($request->all(['harvest_date', 'remarks']));
        $harvest->line()->createMany($request->line);

        return response()->json([
            'result' => true,
        ]);
    }

    public function update(Grow $grow, Harvest $harvest, Request $request)
    {
        $request->validate([
            'harvest_date' => 'required|date',
            'line' => 'required|array',
            'line.*.column_id' => 'required|exists:columns,id',
            'line.*.vehicle_plate_number' => 'required',
            'line.*.withdrawal_slip' => 'required',
            'line.*.farm_num_heads' => 'required|numeric',
            'line.*.actual_num_heads' => 'required|numeric',
            'line.*.farm_average_live_weight' => 'required|numeric',
            'line.*.actual_average_live_weight' => 'required|numeric',
            'line.*.doa_count' => 'required|numeric',
        ], [
            'line.*.column_id.required' => 'Please fill this up',
            'line.*.vehicle_plate_number.required' => 'Please fill this up',
            'line.*.withdrawal_slip.required' => 'Please fill this up',
            'line.*.farm_num_heads.required' => 'Please fill this up',
            'line.*.actual_num_heads.required' => 'Please fill this up',
            'line.*.farm_average_live_weight.required' => 'Please fill this up',
            'line.*.actual_average_live_weight.required' => 'Please fill this up',
            'line.*.doa_count.required' => 'Please fill this up',
        ]);

        $harvest->update($request->all(['harvest_date', 'remarks']));

        $new = [];
        $updated = [];

        foreach ($request->line as $row) {
            if (!isset($row['id'])) {
                $new[] = $row;
            } else {
                $updated[$row['id']] = array_except($row, ['id']);
            }
        }

        $harvest->line->each(function ($item) use ($updated) {
            if (in_array($item->id, array_keys($updated))) {
                $item->update($updated[$item->id]);
            } else {
                $item->delete();
            }
        });

        if (!empty($new)) {
            $harvest->line()->createMany($new);
        }

        return response()->json([
            'result' => true,
        ]);
    }

    public function edit(Grow $grow, Harvest $harvest, Request $request)
    {
        $columns = Column::with('deck')
            ->find($grow->chickIns->pluck('column_id'))
            ->mapWithKeys(function ($column) {
                return [$column->id => "{$column->deck->name} {$column->name}"];
            });

        return view('grows.harvests', [
            'grow' => $grow,
            'columns' => $columns,
            'data' => $harvest->load('line'),
        ]);
    }
}
