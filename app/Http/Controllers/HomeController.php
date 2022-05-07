<?php

namespace App\Http\Controllers;

use App\Models\EvennementSportif;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $eventSportifs=EvennementSportif::paginate();
        $data=[
            'title' => 'Evènnements sportifs',
            'description' => 'Liste des évènnements sportifs',
            'heading' => config('app.name'),
            'eventSportifs' => $eventSportifs
        ];
        return view('home.index',$data);
    }
}
