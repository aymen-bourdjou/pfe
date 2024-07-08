<?php

namespace App\Http\Controllers;

use App\Models\comptage;
use App\Models\equipe_user;
use App\Models\equipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
        ]);

        // Si la validation échoue, retourner les erreurs
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $cat= new equipe();
        $cat->id_comptage=$request->id_comptage;
        $cat->nom_equipe=$request->nom_equipe;
        $cat->id_user_createure=Auth::user()->id_user;
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

    public function showparuser($id_user)
{
    // Trouver tous les enregistrements dans la table equipe_user correspondant à l'id_user donné
    $equipe_users = equipe_user::where('id_user', $id_user)->get();

    if ($equipe_users->isEmpty()) {
        return response()->json(['message' => 'not found'], 404);
    }

    $equipes = [];

    foreach ($equipe_users as $equipe_user) {
        $equipe = equipe::where('id_equipe', $equipe_user->id_equipe)->first();
        if ($equipe) {
            $equipes[] = $equipe;
        }
    }

    if (empty($equipes)) {
        return response()->json(['message' => 'not found'], 404);
    }

    return response()->json($equipes);
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
            //'id_comptage' => 'exists:comptages,id_comptage',
            'nom_equipe' => 'string',
        ]);
        $cat = equipe::findOrFail($id_equipe);
        if(!$cat){
            return response()->json(['message' => 'not found'], 404);
        }
        $cat->id_user_updateure = Auth::user()->id_user;
        $cat->update($request->all());
        return response()->json($cat);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_equipe)
{
    $equipe = Equipe::find($id_equipe);

    if (!$equipe) {
        return response()->json(['message' => 'Équipe non trouvée'], 404);
    }

    $comptage = Comptage::where('id_comptage', $equipe->id_comptage)->get();

    if ($comptage->isNotEmpty()) {
        return response()->json(['message' => 'Vous ne pouvez pas supprimer cette équipe car elle est affectée à un comptage']);
    } else {
        $equipe->delete();
        return response()->json(['message' => 'Équipe supprimée avec succès']);
    }
}

}
