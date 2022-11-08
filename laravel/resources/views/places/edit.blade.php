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
            <label for="name">{{ _('Name') }}</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $place->name }}" />
        </div>
        <div class="form-group">
            <label for="description">{{ _('Description') }}</label>
            <textarea id="description" name="description" class="form-control">{{ $place->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="upload">{{ _('File') }}</label>
            <input type="file" id="upload" name="upload" class="form-control" />
        </div>
        <div class="form-group">            
                <label for="latitude">{{ _('Latitude') }}</label>
                <input type="text" id="latitude" name="latitude" class="form-control"
                    value="{{ $place->latitude }}"/>
        </div>
        <div class="form-group">            
                <label for="longitude">{{ _('Longitude') }}</label>
                <input type="text" id="longitude" name="longitude" class="form-control"
                    value="{{ $place->longitude }}"/>
        </div>
        <button type="submit" class="btn btn-primary">{{ _('Update') }}</button>
        <button type="reset" class="btn btn-secondary">{{ _('Reset') }}</button>
    </form>
@endsection