<?php

namespace App\Http\Controllers;

use App\Models\EvennementSportif;
use Illuminate\Http\Request;

class EvennementSportifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EvennementSportif  $evennementSportif
     * @return \Illuminate\Http\Response
     */
    public function show(EvennementSportif $eventSportif)
    {

        $data=[
            'title' => 'Evènnement sportif: '.$eventSportif->nom,
            'description' => 'Détails event: '.$eventSportif->nom,
            'heading' => config('app.name'),
            'eventSportif' => $eventSportif
        ];
        return view('events.details-event', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EvennementSportif  $evennementSportif
     * @return \Illuminate\Http\Response
     */
    public function edit(EvennementSportif $evennementSportif)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EvennementSportif  $evennementSportif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EvennementSportif $evennementSportif)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EvennementSportif  $evennementSportif
     * @return \Illuminate\Http\Response
     */
    public function destroy(EvennementSportif $evennementSportif)
    {
        //
    }
}
