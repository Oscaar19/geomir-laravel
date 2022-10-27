@extends('layouts.app')
 
@section('content')
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
                <form method="post" action="{{ route('files.update',$file) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="upload">File:</label>
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