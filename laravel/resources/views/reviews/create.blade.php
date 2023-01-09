@extends('layouts.app')


@section('content')



    <div class="divCreate">
        <form id="create" class="maxWidthMaxHeight" method="post" action="{{ route('reviews.store', $place) }}" enctype="multipart/form-data">
            @csrf
            <div id="review" class="divInput centrar marginTop">
                <input class="inputBackground" placeholder="Review" type="textarea" class="form-control" name="review"/>
            </div>
            <div class="divInput centrar marginTop">
                <p>Num. estrelles</p>             
                <select class="inputBackground"  name="rating" class="form-control">
                    @for ($i =1; $i <= 5; $i++)
                        <option>{{ $i }}</option>
                    @endfor  
                </select>
                                                
            </div>
            <div class="centrar">
                <button type="submit" class="actionButton marginTop marginBottom">Puja la ressenya</button>
                <button type="reset" class="actionButton marginTop marginBottom">Torna a omplir</button>
            </div>               
        </form>
    </div>

@endsection