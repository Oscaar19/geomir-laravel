<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\File;



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
            \Log::debug("Saving place at DB...");
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
            return response()->json([
                'success' => true,
                'data'    => $place
            ], 201); 
        } else {
            \Log::debug("Disk storage FAILS");
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
