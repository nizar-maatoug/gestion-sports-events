<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EvennementSprotifRequest;
use App\Http\Resources\EvennementSportifResource;
use App\Models\EvennementSportif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Str;
use Symfony\Component\HttpFoundation\Response;

class EvennementSprotifController extends Controller
{
   
    public function index()
    {
        return new EvennementSportifResource(EvennementSportif::paginate());
    }

  
    public function store(EvennementSprotifRequest $request)
    {
        //$user=User::find(1);

        $user=Auth::user();

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

            $event=EvennementSportif::create([
                'nom'=> $validated['nom'],
                'description' => $validated['description'],
                'lieu' => $validated['lieu'],
                'poster' => $poster,
                'urlPoster' => $urlPoster,
                'dateDebut' => $validated['dateDebut'],
                'dateFin' => $validated['dateFin'],
                'user_id' => $user->id
            ]);

        }catch(ValidationException $exception){
            DB::rollBack();
        }

        DB::commit();

        return response(new EvennementSportifResource($event), Response::HTTP_CREATED);
    }

  
    public function show($id)
    {
        return new EvennementSportifResource(EvennementSportif::with('categories')->find($id));  
    }

  
    public function update(EvennementSprotifRequest $request, $id)
    {
        //$user=User::find(1);

        $user=Auth::user();

        $event=EvennementSportif::find($id);

        
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
            $event->update([
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

        return response(new EvennementSportifResource($event), Response::HTTP_ACCEPTED); 
    }

  
    public function destroy($id)
    {
        $event=EvennementSportif::find($id);

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

        

        return response(null,Response::HTTP_NO_CONTENT);
    }
}
