<?php

namespace App\Http\Controllers;

use App\Models\EvennementSportif;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        /* Auth::logout();
        Auth::login(User::first()); */
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
