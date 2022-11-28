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
                    <div class="divUserName centrar"><b>@</b><b class="userName">{{ $place->author->name }}</b></div>
                    <div class="userFoto centrar"><img src="../../../imatges/usuario.png" class="imgIndex"></div>
                </div>
                <div class="userImg">
                    <div id="placeName">
                        <b class="whiteName">{{ $place->name }}</b>
                    </div>
                    <div id="divPhoto">
                        <a href="{{ route('places.show',$place) }}">
                            @foreach ($files as $file)
                                @if ($file->id  == $place->file_id)
                                    <div class="placePhoto">
                                        <img class="imgPlace" src='{{ asset("storage/{$file->filepath}") }}' />
                                    </div>
                                @endif
                            @endforeach
                        </a>
                    </div>
                    
                </div>
            </div>        
        @endforeach
    </div>   
</div>
@endsection