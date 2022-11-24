@extends('layouts.app')
 
@section('content')
<div class="container">
    <div id="addPlace">
        <a class="btn btn-primary" href="{{ route('places.create') }}" role="button">Add new place</a>
    </div>
    @foreach ($places as $place)
        <div class="divPlace">
            <tr>
                <td><a href="{{ route('places.show',$place) }}">{{ $place->name }}</a></td>
                <td>{{ $place->description }}</td>
                <td>{{ $place->latitude }}</td>
                <td>{{ $place->longitude }}</td>
                <td>{{ $place->created_at }}</td>
            </tr>
            <form action="{{ route('places.favourite',$place) }}" method="post">
                @csrf 
                <tr>
                    <button class="btn btn-primary">Add to favourite</button>
                </tr>
            </form>
        </div>
    @endforeach
   
</div>
@endsection