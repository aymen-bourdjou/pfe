<?php

namespace App\Http\Controllers;

use App\Models\departement;
use Illuminate\Http\Request;

class departementControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departement= departement :: all();
        return response()->json($departement);
    }

    /**
     * Show the form for creating a new resource.
     */
    /**public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cat = new departement();
        $cat->id_zone=$request->id_zone;
        $cat->nom_departement=$request->nom_departement;
        $cat->save();
        return response()->json($cat, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id_departement)
    {
        $departement = Departement::find($id_departement);
    
        if (!$departement) {
            return response()->json(['message' => 'Departement not found'], 404);
        }
    
        return response()->json($departement);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
   /**public function edit(departement $departement)
    {

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'nom_departement' => 'required|string',
    ]);

    $departement = departement::findOrFail($id); 
    $departement->nom_departement = $request->nom_departement;

    $departement->save();

    return response()->json($departement);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_departement)
    {
        $departement = departement::find($id_departement);
    
        if (!$departement) {
            return response()->json(['message' => 'Zone non trouvée'], 404);
        }
        
        $departement->delete();
        
        return response()->json(['message' => 'Zone supprimée avec succès']);
    }
}
