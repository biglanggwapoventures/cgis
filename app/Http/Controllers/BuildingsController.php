<?php

namespace App\Http\Controllers;

use App\Building;
use App\Farm;
use DB;
use Illuminate\Http\Request;
use Session;

class BuildingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Farm $farm)
    {
        return view('buildings.index', [
            'farm' => $farm->load('buildings'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($farm, Request $request)
    {
        $post = $request->validate([
            'name' => 'required|unique:buildings',
            'description' => 'present',
        ]);

        $post['farm_id'] = $farm;

        Building::create($post);

        return redirect(route('buildings.index', ['farm' => $farm]))
            ->with('message', ['success' => "New building has been created!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($farm, Request $request, $id)
    {
        $input = $request->validate([
            'item.*.id' => 'required|distinct|exists:buildings,id',
            'item.*.name' => 'required|distinct',
            'item.*.description' => 'present',
        ]);

        DB::transaction(function () use ($input) {
            $updates = collect($input['item'])->keyBy('id');
            Building::find($updates->keys())
                ->each(function ($building) use ($updates) {
                    $building->update($updates->get($building->id));
                });
        }, 3);

        Session::flash('message', ['success' => 'Building(s) has been successfully updated!']);
        return response()->json([
            'result' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($farm, $id)
    {
        Building::whereId($id)->whereFarmId($farm)->delete();

        Session::flash('message', ['success' => 'Selected building has been deleted!']);

        return response()->json([
            'result' => true,
        ]);
    }
}
