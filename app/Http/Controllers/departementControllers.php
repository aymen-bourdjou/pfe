<?php

namespace App\Http\Controllers;

use App\Models\departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($request->all(), [
            'id_zone' => 'required|exists:zones,id_zone',
            'nom_departement' => 'required|string',
            'id_user_createure' => 'required|exists:users,id_user',
        ]);
    
        // Si la validation échoue, retourner les erreurs
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $cat = new departement();
        $cat->id_zone=$request->id_zone;
        $cat->nom_departement=$request->nom_departement;
        $cat->id_user_createure=$request->id_user_createure;
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
        'id_user_updateure' => 'required|exists:users,id_user',
    ]);

    $departement = departement::findOrFail($id); 
    $departement->nom_departement = $request->nom_departement;
    $departement->id_user_updateure =$request->id_user_updateure ;
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
            return response()->json(['message' => 'departement non trouvée'], 404);
        }
        
        $departement->delete();
        
        return response()->json(['message' => 'departement supprimée avec succès']);
    }
}
