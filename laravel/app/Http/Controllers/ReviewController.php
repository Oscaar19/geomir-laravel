<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;

class ReviewController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Place $place)
    {
        return view("reviews.create",[
            'place'  => $place,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Place $place)
    {
        // Validar dades del formulari
        $validatedData = $request->validate([
            'review' => 'required',
            'rating' => 'required',
        ]);
        
        // Obtenir dades del formulari
        $review = $request->get('review');
        $rating = $request->get('rating');
        $place_id = $place->id;

        $newReview = Review::create([
            'place_id' => $place_id,
            'author_id' => auth()->user()->id,
            'review' => $review,
            'rating' => $rating,
        ]);
        // Patró PRG amb missatge d'èxit
        return redirect()->route('places.show', $place)
            ->with('success', __('Review successfully uploaded'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place  $places
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        if (auth()->user()->id == $review->author_id){

            $place=Place::find($review->place_id);
            $review->delete();

            return redirect()->route('places.show',$place)
            ->with('success', 'Review deleted.');
            
        }else{
            return redirect()->back()
                ->with('error', __('You are not the author of the review.'));
        }
    }
}
