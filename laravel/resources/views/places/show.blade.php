@extends('layouts.app')
 
@section('content')

<div class="divPlace wrapClass">
    <div class="divInfo">
        <div class="">
            <div class="divUserName centrar"><p class="userName">{{ $place->author->name }}</p></div>
            <div class="imgUser"><img src="../../../imatges/usuario.png" class="imgIndex"></div>
            @if(!$place->isfavourite)
                <form action="{{ route('places.favourite',$place) }}" method="post" class="favButton centrar" title="Add to favourites">
                    @csrf 
                    <button class="standardButton"><img src="../../../imatges/favoritos.png" class="imgFav"></button>
                </form>
            @else
                <form action="{{ route('places.unfavourite',$place) }}" method="post" class="favButton centrar" title="Remove from favourites">
                    @csrf 
                    <button class="standardButton"><img src="../../../imatges/favoritos.png" class="imgFav"></button>
                </form>
            @endif
        </div>
        <div class="placeInfo">
            <div class="placeName centrar"><p>{{ $place->name }}</p></div>
            <div class="placeDescr"><p>{{ $place->description }}</p></div>
            <div class="extraInfo">
                <div class="placeDate"><p>{{ $place->created_at }}</p></div>
                <div class="infoLatLong">
                    <div class="placeLat"><p>Latitud {{ $place->latitude }}</p></div>
                    <div class="placeLong"><p>Longitud {{ $place->longitude }}</p></div>
                </div>
            </div>
        </div>
        <div class="placePhoto">
            <img class="imgPlace" src="{{ asset("storage/{$file->filepath}") }}" />
        </div>
    </div>
    <div>
        <a class="btn btn-primary" href="{{ route('places.edit',$place) }}">Edita</a>
        <form method="post" action="{{ route('places.destroy',$place) }}" enctype="multipart/form-data">
            @csrf
            @method('DELETE')
            <button class="btn btn-secondary">Eliminar</button>
        </form>
        <a class="btn btn-primary" href="{{ route('places.index') }}">Veure fitxers</a>
    </div>
    @include('flash')
</div>           

@endsection