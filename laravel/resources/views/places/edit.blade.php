@extends('layouts.app')

@section('box-title')
    {{ __('Place') . " " . $place->id }}
@endsection

@section('content')
    <img class="img-fluid" src="{{ asset('storage/'.$file->filepath) }}" title="Image preview"/>
    <form method="POST" action="{{ route('places.update', $place) }}" enctype="multipart/form-data">
        @csrf
        @method("PUT")
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $place->name }}" />
        </div>
        <div class="form-group">
            <label for="description">{{ __('Description') }}</label>
            <textarea id="description" name="description" class="form-control">{{ $place->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="upload">{{ __('File') }}</label>
            <input type="file" id="upload" name="upload" class="form-control" />
        </div>
        <div class="form-group">            
                <label for="latitude">{{ __('Latitude') }}</label>
                <input type="text" id="latitude" name="latitude" class="form-control"
                    value="{{ $place->latitude }}"/>
        </div>
        <div class="form-group">            
            <label for="longitude">{{ __('Longitude') }}</label>
            <input type="text" id="longitude" name="longitude" class="form-control"
                value="{{ $place->longitude }}"/>
        </div>
        <div>
            <label for="visibility_id">Visibility</label>
            <select name="visibility_id" class="form-control">
                @foreach($visibilities as $visibility)
                    <option value="{{__($visibility->id)}}">{{__($visibility->name)}}</option>
                @endforeach 
            </select>                                   
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
        <button type="reset" class="btn btn-secondary">{{ __('Reset') }}</button>
    </form>
@endsection