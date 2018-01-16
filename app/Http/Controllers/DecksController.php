<?php

namespace App\Http\Controllers;

use App\Building;
use App\Deck;
use DB;
use Illuminate\Http\Request;
use Session;

class DecksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Building $building)
    {
        return view('decks.index', [
            'building' => $building->load(['farm', 'decks']),
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
    public function store($building, Request $request)
    {
        $post = $request->validate([
            'name' => 'required',
            'description' => 'present',
        ]);

        $post['building_id'] = $building;

        Deck::create($post);

        return redirect(route('decks.index', ['building' => $building]))
            ->with('message', ['success' => "New deck has been created!"]);
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
    public function update($building, Request $request, $id)
    {
        $input = $request->validate([
            'item.*.id' => 'required|distinct|exists:decks,id',
            'item.*.name' => 'required|distinct',
            'item.*.description' => 'present',
        ]);

        DB::transaction(function () use ($input) {
            $updates = collect($input['item'])->keyBy('id');
            Deck::find($updates->keys())
                ->each(function ($deck) use ($updates) {
                    $deck->update($updates->get($deck->id));
                });
        }, 3);

        Session::flash('message', ['success' => 'Deck(s) has been successfully updated!']);
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
    public function destroy($building, $id)
    {
        Deck::whereId($id)->whereBuildingId($building)->delete();

        Session::flash('message', ['success' => 'Selected deck has been deleted!']);

        return response()->json([
            'result' => true,
        ]);
    }
}
