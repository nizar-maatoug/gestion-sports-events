@extends('layouts.main')

@section('content')
    @foreach ($categories as $categorie)
        <p>{{$categorie->nom}}</p>
    @endforeach
@endsection
