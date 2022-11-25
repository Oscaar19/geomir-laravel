@extends('layouts.app')
 
@section('content')
<div class="contenidor">
    <div id="addPlace">
        <a class="addButton" href="{{ route('places.create') }}" role="button">Add new place</a>
    </div>
    <div class="listPlaces">
        @foreach ($places as $place)
            <div class="divPlace">
                <div class="userInfo">
                    <div class="divUserName centrar"><p class="userName">{{ $place->author->name }}</p></div>
                    <div class="userFoto centrar" title="Go to the place"><img src="../../../imatges/usuario.png" class="imgIndex"></div>
                </div>
                <div>
                    <a href="{{ route('places.show',$place) }}">
                        <div class="placePhoto">
                            <img class="imgPlace" src="{{ asset("storage/{$place->file->filepath}") }}" />
                        </div>
                    </a>
                </div>
            </div>        
        @endforeach
    </div>   
</div>
@endsection