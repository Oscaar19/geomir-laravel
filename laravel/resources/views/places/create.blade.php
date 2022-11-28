@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="divCreate">
        <form class="maxWidthMaxHeight" method="post" action="{{ route('places.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="divInput centrar marginTop">
                <input class="inputBackground" placeholder="Name" type="text" class="form-control" name="name"/>
            </div>
            <div class="divInput centrar marginTop">
                <input class="inputBackground" placeholder="Description" type="text" class="form-control" name="description"/>
            </div>
            <div class="divInput centrar marginTop">
                <input class="inputBackground" placeholder="Latitude" type="text" class="form-control" name="latitude"/>
            </div>
            <div class="divInput centrar marginTop">
                <input class="inputBackground" placeholder="Longitude" type="text" class="form-control" name="longitude"/>
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
                <button type="submit" class="actionButton marginTop">Create</button>
                <button type="reset" class="actionButton marginTop">Reset</button>
            </div>               
        </form>
    </div>
@endsection