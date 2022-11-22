@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ __('Place') }}</div>
               <div class="card-body">
                   <table class="table">
                       <thead>
                           <tr> 
                               <td scope="col">ID</td>
                               <td scope="col">Name</td>
                               <td scope="col">Description</td>
                               <td scope="col">Latitude</td>
                               <td scope="col">Longitude</td>
                               <td scope="col">Author</td>
                               <td scope="col">Created</td>
                           </tr>
                       </thead>
                       <tbody>                           
                           <tr>
                                <td>{{ $place->id }}</td>
                                <td>{{ $place->name }}</td>
                                <td>{{ $place->description }}</td>
                                <td>{{ $place->latitude }}</td>
                                <td>{{ $place->longitude }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $place->created_at }}</td>
                           </tr>                           
                       </tbody>
                   </table>
                   <img class="img-fluid" src="{{ asset("storage/{$file->filepath}") }}" />
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
       </div>
   </div>
</div>
@endsection