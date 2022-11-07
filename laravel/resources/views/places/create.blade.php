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

    <form method="post" action="{{ route('places.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Place:</label>
            <input type="text" class="form-control" name="name"/>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" class="form-control" name="description"/>
        </div>
        <div class="form-group">
            <label for="latitude">Latitude:</label>
            <input type="text" class="form-control" name="latitude"/>
        </div>
        <div class="form-group">
            <label for="longitude">Longitude:</label>
            <input type="text" class="form-control" name="longitude"/>
        </div>
        <div class="form-group">
                <label for="upload">Foto:</label>
                <input type="file" class="form-control" name="upload"/>
        </div>   
        <button type="submit" class="btn btn-primary">Create</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
    </form>

@endsection