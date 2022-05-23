<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvennementSprotifRequest;
use App\Models\EvennementSportif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

use Str;

class EvennementSportifController extends Controller
{

    /* public function __construct(){
        
        $this->middleware('auth')->except('show');
    } */
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evennementSportifs=auth()->user()->evennementSportifs()->paginate();

        $data=[
            'title' => $description="Mes évènements sportifs",
            'description' => $description,
            'eventSportifs' => $evennementSportifs,

            'heading' => $description
        ];
        return view('events.mes-events',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=[
            'title' => $description="ajouter nouvel evenement",
            'description' => $description,

            'heading' => $description
        ];
        return view('events.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EvennementSprotifRequest $request)
    {
        DB::beginTransaction();
        try{
            $validated = $request->validated();
            $poster=null;
            $urlPoster=null;

            if(($request->file('poster')!==null)&&($request->file('poster')->isValid())){

                $ext=$request->file('poster')->extension();
                $fileName=Str::uuid().'.'.$ext;
                $poster=$request->file('poster')->storeAs('public/images',$fileName);
                $urlPoster=env('APP_URL').Storage::url($poster);
            }

            Auth::user()->evennementSportifs()->create([
                'nom'=> $validated['nom'],
                'description' => $validated['description'],
                'lieu' => $validated['lieu'],
                'poster' => $poster,
                'urlPoster' => $urlPoster,
                'dateDebut' => $validated['dateDebut'],
                'dateFin' => $validated['dateFin']
            ]);

        }catch(ValidationException $exception){
            DB::rollBack();
        }

        DB::commit();

        return redirect()->route('events.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EvennementSportif  $evennementSportif
     * @return \Illuminate\Http\Response
     */
    public function show(EvennementSportif $event)
    {

        $data=[
            'title' => 'Evènnement sportif: '.$event->nom,
            'description' => 'Détails event: '.$event->nom,
            'heading' => config('app.name'),
            'eventSportif' => $event
        ];
        return view('events.details-event', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EvennementSportif  $evennementSportif
     * @return \Illuminate\Http\Response
     */
    public function edit(EvennementSportif $event)
    {
        abort_if(auth()->user()->id !== $event->organisateur->id,403 );

        $data=[
            'title' => $description="Editer évenement Sportif ".$event->nom,
            'description' => $description,
            'heading' => $description,
            'eventSportif' =>$event
        ];
        return view('events.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EvennementSportif  $evennementSportif
     * @return \Illuminate\Http\Response
     */
    public function update(EvennementSprotifRequest $request, EvennementSportif $event)
    {
        abort_if($event->organisateur->id !== auth()->id(),403);

        DB::beginTransaction();
        try{
            $validated = $request->validated();

            $poster=$event->poster;
            $urlPoster=$event->urlPoster;

            if(($request->file('poster')!==null)&&($request->file('poster')->isValid())){

                $ext=$request->file('poster')->extension();
                $fileName=Str::uuid().'.'.$ext;
                $poster=$request->file('poster')->storeAs('public/images',$fileName);
                $urlPoster=env('APP_URL').Storage::url($poster);



                //Supprimer l'ancien poster s'il existe
                DB::afterCommit(function() use($event){
                    if($event->poster!=null){
                        Storage::delete($event->poster);
                    }

                });

            }
            Auth::user()->evennementSportifs()->where('id',$event->id)->update([
                'nom'=> $validated['nom'],
                'description' => $validated['description'],
                'lieu' => $validated['lieu'],
                'poster' => $poster,
                'urlPoster' => $urlPoster,
                'dateDebut' => $validated['dateDebut'],
                'dateFin' => $validated['dateFin']
            ]);

        }catch(ValidationException $exception){
            DB::rollback();
        }
        DB::commit();

        return redirect()->route('events.show',[$event]);

    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EvennementSportif  $evennementSportif
     * @return \Illuminate\Http\Response
     */
    public function destroy(EvennementSportif $event)
    {
        abort_if($event->organisateur->id !== auth()->id(),403);

        DB::beginTransaction();
        try{
            DB::afterCommit(function() use($event){

                if($event->poster!=null){
                    Storage::delete($event->poster);
                }

            });

            $event->delete();

        }catch(ValidationException $e){
            DB::rollback();
        }
        DB::commit();

        return redirect()->route('events.index');
    }
}
