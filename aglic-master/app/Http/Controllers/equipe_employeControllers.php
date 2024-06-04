<?php

namespace App\Http\Controllers;

use App\Models\equipe_employe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class equipe_employeControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipe_employe= equipe_employe::all();
        return response()->json($equipe_employe);
    }

    /**
     * Show the form for creating a new resource.
     */
   /* public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * 'id_equipe',
        *'id_employe',
        *'date_debut',
        *'date_fin',
        *'role',
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_equipe' => 'required|exists:equipes,id_equipe',
            'id_employe' => 'required|exists:employes,id_employe',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'role' => 'required|string',
        ]);

        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $cat = new equipe_employe();
        $cat->id_equipe=$request->id_equipe;
        $cat->id_employe=$request->id_employe;
        $cat->date_debut=$request->date_debut;
        $cat->date_fin=$request->date_fin;
        $cat->role=$request->role;
        $cat->save();
        return response()->json($cat, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id_equipe, $id_employe)
{
    $cat = equipe_employe::where('id_equipe', $id_equipe)
                                   ->where('id_employe', $id_employe)
                                   ->first();

    if(!$cat){
        return response()->json(['message' => 'not found'], 404);
    }

    return response()->json($cat);
}

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(equipe_employe $equipe_employe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /*public function update(Request $request, $id_equipe, $id_employe)
    {
        $update = equipe_employe::updatebycompositekey($id_equipe, $id_employe);

        if ($update) {
            return response()->json(['message' => 'modifier avec succès']);
        } else {
            return response()->json(['message' => 'Zone non trouvée'], 404);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_equipe,$id_employe)
    {
        $deleted = equipe_employe::deleteByCompositeKey($id_equipe, $id_employe);

        if ($deleted) {
            return response()->json(['message' => 'Supprimé avec succès']);
        } else {
            return response()->json(['message' => 'Zone non trouvée'], 404);
        }
    }
}
