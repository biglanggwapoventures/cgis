<?php

namespace App\Http\Controllers;

use App\Building;
use App\ChickIn;
use App\Grow;
use DB;
use Illuminate\Http\Request;

class GrowChickInController extends Controller
{
    public function index(Grow $grow, Request $request)
    {
        $buildings = Building::has('decks.columns')->with(['farm', 'decks.columns'])->get();
        $recorded = $grow->chickIns->keyBy('column_id');

        return view('grows.chick-in', [
            'grow' => $grow,
            'buildings' => $buildings,
            'recorded' => $recorded,
        ]);
    }

    public function update(Grow $grow, Request $request)
    {
        $validated = $request->validate([
            'in.*.id' => 'sometimes|exists:chick_ins,id',
            'in.*.column_id' => 'required|exists:columns,id',
            'in.*.reference_number' => 'present|nullable',
            'in.*.chick_in_date' => 'present|nullable|date_format:Y-m-d',
            'in.*.num_heads' => 'present|nullable|numeric',
            'in.*.num_dead' => 'present|nullable|numeric',
        ]);

        DB::transaction(function () use ($request, $grow) {
            $recent = [];
            $updated = [];

            foreach ($request->in as $item) {
                $input = array_except($item, ['id']);
                if (isset($item['id'])) {
                    $grow->chickIns()->whereId($item['id'])->update($input);
                    $updated[] = $item['id'];
                } else {
                    $recent[] = new ChickIn($input);
                }
            }

            if (empty($updated)) {
                $grow->chickIns()->delete();
            } else {
                $grow->chickIns()->whereNotIn('id', $updated)->delete();
            }

            if (!empty($recent)) {
                $grow->chickIns()->saveMany($recent);
            }
        }, 3);

        return redirect(route('grows.chick-in.index', ['grow' => $grow->id]));
    }
}
