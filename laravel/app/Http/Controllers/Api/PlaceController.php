<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\File;
use App\Models\Favourite;



class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places=Place::all();
        return response()->json([
            "success"=> true,
            "data"=>$places  
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
            'name'        => 'required|string',
            'description' => 'required|string',
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
            $place = Place::create([
                'name'        => $name,
                'description' => $description,
                'file_id'     => $file->id,
                'latitude'    => $latitude,
                'longitude'   => $longitude,
                'author_id'   => auth()->user()->id,
                'visibility_id'  => $visibility_id,
            ]);
            // Patró PRG amb missatge d'èxit
            return response()->json([
                'success' => true,
                'data'    => $place
            ], 201); 
        } else {
            // Patró PRG amb missatge d'error
            return response()->json([
                'success'  => false,
                'message' => 'Error storing place'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $place=Place::find($id);
        if (!$place){
            return response()->json([
                'success' => false,
                'message' => "Place not found"
            ], 404);
        }
        else{
            return response()->json([
                'success' => true,
                'data'    => $place
            ], 200);
       
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $place=Place::find($id);

        if ($place){
            // Validar dades del formulari
            $validatedData = $request->validate([
                'name'        => 'required|string',
                'description' => 'required|string',
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
            $file=File::find($place->file_id);
            $fileOk = $file->diskSave($upload);

            if ($fileOk) {
                // Desar dades a BD
                $place-> name = $name;
                $place-> description = $description;
                $place-> latitude = $latitude;
                $place-> longitude = $longitude;
                $place-> visibility_id = $visibility_id;
                $place->save();
                // Patró PRG amb missatge d'èxit
                return response()->json([
                    'success' => true,
                    'data'    => $place
                ], 201); 
            }
            else{
                return response()->json([
                    'success'  => false,
                    'message' => 'Error storing place'
                ], 500);
            }               
        } else {
            return response()->json([
                'success' => false,
                'message' => "Place not found"
            ], 404);
           
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $place=Place::find($id);

        if (!$place){
            return response()->json([
                'success' => false,
                'message' => "Place not found"
            ], 404);
        }
        else{
            $place->delete();
            return response()->json([
                'success' => true,
                'data'    => 'File deleted.'
            ], 200);
       
        }
    }

    public function favourite($id)
    {
        $place=Place::find($id);
        if (Favourite::where([['user_id', "=" ,auth()->user()->id],['place_id', "=" ,$place->id],])->exists()) {
            return response()->json([
                'success'  => false,
                'message' => 'The place is already favourite'
            ], 500);
        }else{
            $favourite = Favourite::create([
                'user_id' => auth()->user()->id,
                'place_id' => $place->id,
            ]);
            return response()->json([
                'success' => true,
                'data'    => $favourite
            ], 201);
        }        
    }

    public function unfavourite($id)
    {
        $place=Place::find($id);
        if (Favourite::where([['user_id', "=" ,auth()->user()->id],['place_id', "=" ,$place->id],])->exists()) {
            $favourite = Favourite::where([
                ['user_id', "=" ,auth()->user()->id],
                ['place_id', "=" ,$place->id],
            ]);
    
            $favourite->first();
    
            $favourite->delete();

            return response()->json([
                'success' => true,
                'data'    => $favourite
            ], 201);
        }else{
            return response()->json([
                'success'  => false,
                'message' => 'The place is not favourite'
            ], 500);
            
        }  
        
    }
}
