<?php

namespace App\Http\Controllers;

use App\Column;
use App\Deck;
use Illuminate\Http\Request;

class ColumnsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Deck $deck)
    {
        return view('columns.index', [
            'deck' => $deck->load(['building.farm', 'columns']),
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
    public function store($deck, Request $request)
    {
        $post = $request->validate([
            'name' => 'required',
            'description' => 'present',
        ]);

        $post['deck_id'] = $deck;

        Column::create($post);

        return redirect(route('columns.index', ['deck' => $deck]));
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
    public function update($deck, Request $request, $id)
    {
        $post = $request->validate([
            'name' => 'required',
            'description' => 'present',
        ]);

        Column::whereId($id)->whereDeckId($deck)->update($post);

        return redirect(route('columns.index', ['deck' => $deck]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($deck, $id)
    {
        Columns::whereId($id)->whereDeckId($deck)->delete();

        return redirect(route('columns.index', ['deck' => $deck]));
    }
}
