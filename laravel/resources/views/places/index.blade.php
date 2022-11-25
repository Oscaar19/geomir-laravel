@extends('layouts.app')
 
@section('content')
<div class="container">
    <div id="addPlace">
        <a class="addButton" href="{{ route('places.create') }}" role="button">Add new place</a>
    </div>
    @foreach ($places as $place)
        <div class="divPlace">
            <div class="userInfo">
                <div class="userName centrar"><p>Oscar Buitrago</p></div>
                <div class="userFoto centrar"><img src="../../../imatges/usuario.png" class="imgIndex"></div>
                <form action="{{ route('places.favourite',$place) }}" method="post" class="favButton centrar">
                    @csrf 
                    <button class="standardButton"><img src="../../../imatges/favoritos.png" class="imgFav"></button>
                </form>
            </div>
            <a href="{{ route('places.show',$place) }}" class="aPlace">
                <div class="place">
                    <div class="placeInfo">
                        <div class="placeName centrar"><p>{{ $place->name }}</p></div>
                        <div class="placeDescr"><p>{{ $place->description }}</p></div>
                        <div class="placeDate"><p>{{ $place->created_at }}</p></div>
                        <div class="placeLat"><p>{{ $place->latitude }}</p></div>
                        <div class="placeLong"><p>{{ $place->longitude }}</p></div>
                    </div>
                    <div class="placePhoto">
                        <img src="../../../imatges/prado.jpg" class="imgPlace">
                    </div>
                </div>
            </a>
        </div>        
    @endforeach
   
</div>
@endsection