@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ __('Places') }}</div>
               <div class="card-body">
                   <table class="table">
                       <thead>
                           <tr>
                                <td scope="col">Name</td>
                                <td scope="col">Description</td>
                                <td scope="col">Latitude</td>
                                <td scope="col">Longitude</td>
                                <td scope="col">Created</td>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach ($places as $place)
                                <tr>
                                    <td><a href="{{ route('places.show',$place) }}">{{ $place->name }}</a></td>
                                    <td>{{ $place->description }}</td>
                                    <td>{{ $place->latitude }}</td>
                                    <td>{{ $place->longitude }}</td>
                                    <td>{{ $place->created_at }}</td>
                                </tr>
                           @endforeach
                       </tbody>
                   </table>
                   <form action="{{ route('places.favourite',$place) }}" method="post">
                       @csrf 
                       <tr>
                           <button class="btn btn-primary">Favourite</button>
                       </tr>
                   </form>
                   <a class="btn btn-primary" href="{{ route('places.create') }}" role="button">Add new place</a>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection