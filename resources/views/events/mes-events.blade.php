@extends('layouts.app')

@section('content')

@if(Auth::user()->id !=null)
    <a type="button" href="{{route('events.create')}}" class="btn btn-primary">Ajouter</a>
@endif


    @include('layouts.liste-events')






@endsection
