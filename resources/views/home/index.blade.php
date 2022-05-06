@extends('layouts.main')

@section('content')
    <div class="container">
        @foreach ($eventSportifs as $eventSportif)
            <div class="card" style="width: 18rem;">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                <h5 class="card-title">{{$eventSportif->nom}}</h5>
                <p class="card-text">{{$eventSportif->description}}</p>
                <a href="#" class="btn btn-primary">Détails</a>
                </div>
            </div>

        @endforeach


    </div>

@endsection
