@extends('layouts.app')


@section('content')



    <div class="divCreate">
        <form id="create" class="maxWidthMaxHeight" method="post" action="{{ route('places.store') }}" enctype="multipart/form-data">
            @csrf
            @vite('resources/js/places/create.js')
            <div id="name" class="divInput centrar marginTop">
                <input class="inputBackground" placeholder="Name" type="text" class="form-control" name="name"/>
                <div class="error alert alert-danger alert-dismissible fade"></div>
            </div>
            <div id="description"  class="divInput centrar marginTop">
                <input class="inputBackground" placeholder="Description" type="text" class="form-control" name="description"/>
                <div class="error alert alert-danger alert-dismissible fade"></div>
            </div>
            <div id="latitude"  class="divInput centrar marginTop">
                <input class="inputBackground" placeholder="Latitude" type="text" class="form-control" name="latitude"/>
                <div class="error alert alert-danger alert-dismissible fade"></div>
            </div>
            <div id="longitude"  class="divInput centrar marginTop">
                <input class="inputBackground" placeholder="Longitude" type="text" class="form-control" name="longitude"/>
                <div class="error alert alert-danger alert-dismissible fade"></div>
            </div>
            <div class="divInput centrar marginTop">               
                <select class="inputBackground"  name="visibility_id" class="form-control">
                    @foreach($visibilities as $visibility)
                        <option value="{{__($visibility->id)}}">{{__($visibility->name)}}</option>
                    @endforeach 
                </select>
                                                
            </div>
            <div class="divInput centrar marginTop">
                <input class="inputBackground"  placeholder="Photo" type="file" class="form-control" name="upload"/>
            </div>
            <div class="centrar">
                <button type="submit" class="actionButton marginTop marginBottom">Create</button>
                <button type="reset" class="actionButton marginTop marginBottom">Reset</button>
            </div>               
        </form>
    </div>

@endsection