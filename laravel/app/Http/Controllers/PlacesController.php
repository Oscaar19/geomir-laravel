<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\File;
use App\Models\User;
use App\Models\Review;
use App\Models\Favourite;
use App\Models\Visibility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;


class PlacesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:places.list')->only('index');
        $this->middleware('permission:places.create')->only(['create','store']);
        $this->middleware('permission:places.read')->only('show');
        $this->middleware('permission:places.update')->only(['edit','update']);
        $this->middleware('permission:places.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("places.index", [
            "places" => Place::all(),
            "files" => File::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("places.create", [
            "visibilities" => Visibility::all()
        ]);
 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar dades del formulari
        $validatedData = $request->validate([
            'name'        => 'required',
            'description' => 'required',
            'upload'      => 'required|mimes:gif,jpeg,jpg,png,mp4|max:2048',
            'latitude'    => 'required',
            'longitude'   => 'required',
            'visibility_id'   => 'required',
        ]);
        
        // Obtenir dades del formulari
        $name        = $request->get('name');
        $description = $request->get('description');
        $upload      = $request->file('upload');
        $latitude    = $request->get('latitude');
        $longitude   = $request->get('longitude');
        $visibility_id  = $request->get('visibility_id');

        // Desar fitxer al disc i inserir dades a BD
        $file = new File();
        $fileOk = $file->diskSave($upload);

        if ($fileOk) {
            // Desar dades a BD
            Log::debug("Saving place at DB...");
            $place = Place::create([
                'name'        => $name,
                'description' => $description,
                'file_id'     => $file->id,
                'latitude'    => $latitude,
                'longitude'   => $longitude,
                'author_id'   => auth()->user()->id,
                'visibility_id'  => $visibility_id,
            ]);
            \Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('places.show', $place)
                ->with('success', __('Place successfully saved'));
        } else {
            \Log::debug("Disk storage FAILS");
            // Patró PRG amb missatge d'error
            return redirect()->route("places.create")
                ->with('error', __('ERROR Uploading file'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Place  $places
     * @return \Illuminate\Http\Response
     */
    public function show(Place $place)
    {
        $file=File::find($place->file_id);
        $user=User::find($place->author_id);
        $reviews = DB::table('reviews')->where('author_id',"=", $place->author_id)->get();
        \Log::debug("Les reviews son:");
        \Log::debug($reviews);
        $is_fav = false;
        try {
            if (Favourite::where('user_id', '=', auth()->user()->id)->where('place_id','=', $place->id)->exists()) {
                $is_fav = true;
            }
        } catch (Exception $error) {
            $is_fav = false;
        }
    
        return view("places.show",[
            'place'=> $place,
            'file'=>$file,
            'user'=>$user,
            'is_fav'=>$is_fav,
            'reviews'=>$reviews,
        ]);        
         

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Place  $places
     * @return \Illuminate\Http\Response
     */
    public function edit(Place $place)
    {
        if (auth()->user()->id == $place->author_id){
            return view("places.edit",[
                'place'  => $place,
                'file'   => $place->file,
                'author' => $place->user,
                "visibilities" => Visibility::all(),
            ]);
        }else{
            return redirect()->back()
                ->with('error', __('You are not the author of the place.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Place  $places
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Place $place)
    {
        
        // Validar dades del formulari
        $validatedData = $request->validate([
            'name'        => 'required',
            'description' => 'required',
            'upload'      => 'nullable|mimes:gif,jpeg,jpg,png,mp4|max:2048',
            'latitude'    => 'required',
            'longitude'   => 'required',
            'visibility_id'   => 'required',
        ]);
        
        // Obtenir dades del formulari
        $name        = $request->get('name');
        $description = $request->get('description');
        $upload      = $request->file('upload');
        $latitude    = $request->get('latitude');
        $longitude   = $request->get('longitude');
        $visibility_id  = $request->get('visibility_id');

        // Desar fitxer (opcional)
        if (is_null($upload) || $place->file->diskSave($upload)) {
            // Actualitzar dades a BD
            Log::debug("Updating DB...");
            $place->name        = $name;
            $place->description = $description;
            $place->latitude    = $latitude;
            $place->longitude   = $longitude;
            $place->visibility_id = $visibility_id;
            $place->save();
            \Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('places.show', $place)
                ->with('success', __('Place successfully saved'));
        } else {
            // Patró PRG amb missatge d'error
            return redirect()->route("places.create")
                ->with('error', __('ERROR Uploading file'));
        }              

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place  $places
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        if (auth()->user()->id == $place->author_id){
            $file=File::find($place->file_id);
            \Storage::disk('public')->exists($place->id);
            $place->delete();

            \Storage::disk('public')->exists($file->filepath);
            $file->delete();

            if (\Storage::disk('public')->exists($place->id)){
                return redirect()->route('places.show',$place)
                ->with('error', 'ERROR deleting place');
            }
            else{
                return redirect()->route('places.index', [
                    "places" => Place::all()
                ])
                    ->with('error', 'Place deleted!');
            
            }
        }else{
            return redirect()->back()
                ->with('error', __('You are not the author of the place.'));
        }
    }

    public function favourite(Place $place)
    {
        $favourite = Favourite::create([
            'user_id' => auth()->user()->id,
            'place_id' => $place->id,
        ]);
        return redirect()->back();
        
        
    }

    public function unfavourite(Place $place)
    {
        $favourite = Favourite::where([
            ['user_id', "=" ,auth()->user()->id],
            ['place_id', "=" ,$place->id],
        ]);

        $favourite->first();

        $favourite->delete();

        return redirect()->back();
    }
}
