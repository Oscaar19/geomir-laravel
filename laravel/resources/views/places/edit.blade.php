@extends('layouts.app')

@section('box-title')
    {{ __('Place') . " " . $place->id }}
@endsection

@section('content')
<div class="divEdit">
    <form method="POST" action="{{ route('places.update', $place) }}" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <div class="divInput centrar marginTop">
                <input class="inputBackground" type="text" class="form-control" name="name" value="{{ $place->name }}" />
            </div>
            <div class="divInput centrar marginTop">
                <textarea id="editDescription" name="description" class="form-control">{{ $place->description }}</textarea>
            </div>
            <div class="divInput centrar marginTop">
                <input class="inputBackground" type="text" class="form-control" name="latitude" value="{{ $place->latitude }}"/>
            </div>
            <div class="divInput centrar marginTop">
                <input class="inputBackground" type="text" class="form-control" name="longitude" value="{{ $place->longitude }}"/>
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
            <div id="imgEdit">
                <img src="{{ asset("storage/{$file->filepath}") }}"/>
            </div>
            <div class="centrar">
                <button type="submit" class="actionButton marginTop marginBottom">{{ __('Update') }}</button>
                <button type="reset" class="actionButton marginTop marginBottom">{{ __('Reset') }}</button>
            </div>
    </form>
</div>
@endsection