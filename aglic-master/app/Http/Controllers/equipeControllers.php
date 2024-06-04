<?php

namespace App\Http\Controllers;

use App\Models\equipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class equipeControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipe = equipe ::all();
        return response()->json($equipe);
    }

    /**
     * Show the form for creating a new resource.
     */
    /*public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * 'id_comptage',
        *'nom_equipe',
        *'date_debut',
        *'date_fin',
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_comptage' => 'required|exists:comptages,id_comptage',
            'nom_equipe' => 'required|string',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ]);

        // Si la validation échoue, retourner les erreurs
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $cat= new equipe();
        $cat->id_comptage=$request->id_comptage;
        $cat->nom_equipe=$request->nom_equipe;
        $cat->date_debut=$request->date_debut;
        $cat->date_fin=$request->date_fin;
        $cat->save();
        return response()->json($cat, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show( $id_equipe)
    {
        $x= equipe::find($id_equipe);
        if(!$x){
            return response()->json(['message' => 'not found'], 404);
        }
        return response()->json($x);
    }

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(equipe $equipe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id_equipe)
    {
        $request->validate([
            'id_comptage' => 'exists:comptages,id_comptage',
            'nom_equipe' => 'string',
            'date_debut' => 'nullable|before_or_equal:date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            
        ]);
        $cat = equipe::findOrFail($id_equipe);
        if(!$cat){
            return response()->json(['message' => 'not found'], 404);
        }
        $cat->update($request->all());
        return response()->json($cat);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id_equipe)
    {
        $equipe = equipe::find($id_equipe);
    
        if (!$equipe) {
            return response()->json(['message' => 'equipe non trouvée'], 404);
        }
        
        $equipe->delete();
        
        return response()->json(['message' => 'equipe supprimée avec succès']);
    }
}
