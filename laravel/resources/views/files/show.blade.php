@extends('layouts.app')
 
@section('content')
@include('flash')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ __('File') }}</div>
               <div class="card-body">
                   <table class="table">
                       <thead>
                           <tr>
                               <td scope="col">ID</td>
                               <td scope="col">Filepath</td>
                               <td scope="col">Filesize</td>
                               <td scope="col">Created</td>
                               <td scope="col">Updated</td>
                           </tr>
                       </thead>
                       <tbody>                           
                           <tr>
                               <td>{{ $file->id }}</td>
                               <td>{{ $file->filepath }}</td>
                               <td>{{ $file->filesize }}</td>
                               <td>{{ $file->created_at }}</td>
                               <td>{{ $file->updated_at }}</td>
                           </tr>                           
                       </tbody>
                   </table>
                   <img class="img-fluid" src="{{ asset("storage/{$file->filepath}") }}" />
                </div>
                <a class="btn btn-primary" href="{{ route('files.edit',$file) }}">Edita</a>
                <form method="post" action="{{ route('files.destroy',$file) }}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-secondary">Eliminar</button>
                </form>
                <a class="btn btn-primary" href="{{ route('files.index') }}">Veure fitxers</a>

           </div>
       </div>
   </div>
</div>
@endsection