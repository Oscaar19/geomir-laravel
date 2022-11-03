<?php

namespace App\Http\Controllers;

use App\Models\Places;
use App\Models\File;
use Illuminate\Http\Request;

class PlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("places.index", [
            "places" => Places::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("places.create");
 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
        ]);
        \Log::debug("Fichero valido");


    
        
        // Pujar fitxer al disc dur
        $all = $request->all();
        $upload = $request->file('upload');
        \Log::debug("Fichero subido");

        // Pujar fitxer al disc dur
        $fileName = $upload->getClientOriginalName();
        $uploadName = time() . '_' . $fileName;
        $fileSize = $upload->getSize();
        $filePath = $upload->storeAs(
            'uploads',      // Path
            $uploadName ,   // Filename
            'public'        // Disk
        );

        \Log::debug("Fichero nombrado");


    
        if (\Storage::disk('public')->exists($filePath)) {
            \Log::debug("Local storage OK");
            $fullPath = \Storage::disk('public')->path($filePath);
            \Log::debug("File saved at {$fullPath}");
            // Desar dades a BD
            
            $file = File::create([
                'filepath' => $filePath,
                'filesize' => $fileSize,
            ]);
            \Log::debug("Fichero guardado con id " . $file->id);
            $place = Places::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'file_id' => $file->id,
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                
            ]);
            \Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('places.show', $place)
                ->with('success', 'File successfully saved');
        } else {
            \Log::debug("Local storage FAILS");
            // Patró PRG amb missatge d'error
            return redirect()->route("places.create")
                ->with('error', 'ERROR uploading file');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Places  $places
     * @return \Illuminate\Http\Response
     */
    public function show(Places $place)
    {
        if (DB::table('places')->exists($place->id))
        {
            return view("places.show",[
                'place'=> $place
            ]);        
        }    
        else{
            return redirect()->route("files.index")
                ->with('error', 'ERROR uploading file');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Places  $places
     * @return \Illuminate\Http\Response
     */
    public function edit(Places $place)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Places  $places
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Places $place)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Places  $places
     * @return \Illuminate\Http\Response
     */
    public function destroy(Places $place)
    {
        //
    }
}
