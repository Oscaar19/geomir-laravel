@extends('layouts.app')
@vite('resources/js/files/create.js')


@section('content')
    @include('flash')

    <form id="create" method="post" action="{{ route('files.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="upload">File:</label>
            <input type="file" class="form-control" name="upload"/>
            <div id="alert"></div>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
    </form>
@endsection