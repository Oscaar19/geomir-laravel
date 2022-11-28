@extends('layouts.app')
 
@section('content')

    <div class="divPlace wrapClass">
        <div id="divInfo">
            <div id="divUserInfo">
                <div class="centrar"><b>@</b><b>{{ $place->author->name }}</b></div>
                <div class="centrar"><img src="../../../imatges/usuario.png" id="showPhoto"></div>
                @if($is_fav == false)
                    <form action="{{ route('places.favourite',$place) }}" method="post" class="favButton centrar" title="Add to favourites">
                        @csrf 
                        <button class="standardButton"><img src="../../../imatges/favoritos.png" class="imgFav"></button>
                    </form>
                @else
                    <form action="{{ route('places.unfavourite',$place) }}" method="post" class="favButton centrar" title="Remove from favourites">
                        @csrf 
                        @method('DELETE')
                        <button type="submit" class="standardButton"><img src="../../../imatges/estrella.png" class="imgFav"></button>
                    </form>
                @endif
            </div>
            <div id="divPlaceInfo">
                <div class="centrar divPlaceName"><p>{{ $place->name }}</p></div>
                <div id="divPlaceDescr"><p>{{ $place->description }}</p></div>
                <div id="divPlaceExtra">
                    <div id="divPlaceDate"><p>{{ $place->created_at }}</p></div>
                    <div id="divPlaceLoc">
                        <div id="divPlaceLong"><p>Latitud {{ $place->latitude }}</p></div>
                        <div id="divPlaceLat"><p>Longitud {{ $place->longitude }}</p></div>
                    </div>
                </div>
            </div>
            <div id="divImg">
                <img class="" src="{{ asset("storage/{$file->filepath}") }}" />
            </div>
        </div>
        <div id="divActions">
            <a class="actionButton centrar" href="{{ route('places.edit',$place) }}">Edita</a>
            <form method="post" action="{{ route('places.destroy',$place) }}" enctype="multipart/form-data">
                @csrf
                @method('DELETE')
                <button class="actionButton">Eliminar</button>
            </form>
            <a class="actionButton centrar" href="{{ route('places.index') }}">Torna enrere</a>
        </div>
        @include('flash')
    </div>           

@endsection