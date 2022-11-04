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
                                <td>{{ $place->created_at }}</td>
                           </tr>                           
                       </tbody>
                   </table>
                   <img class="img-fluid" src="{{ asset("storage/{$place->filepath}") }}" />
                </div>
                <form method="post" action="{{ route('places.update',$place) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="upload">Place:</label>
                        <input type="file" class="form-control" name="upload"/>
                    </div>
                    <button type="update" class="btn btn-primary">Cambia</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </form>
           </div>
       </div>
   </div>
</div>
@endsection