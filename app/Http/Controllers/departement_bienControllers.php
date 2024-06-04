<?php

namespace App\Http\Controllers;

use App\Models\departement_bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class departement_bienControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departement_bien= departement_bien::all();
        return response()->json($departement_bien);
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
     * 'id_bien',
        *'id_departement',
        *'date_affectation',
     */
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_bien' => 'required|exists:biens,id_bien',
            'id_departement' => 'required|exists:departements,id_departement',
            'date_affectation' => 'nullable|date',
            'affecter_a' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $cat = new departement_bien();
        $cat->id_bien=$request->id_bien;
        $cat->id_departement=$request->id_departement;
        $cat->date_affectation=$request->date_affectation;
        $cat->affecter_a=$request->affecter_a;
        $cat->save();
        return response()->json($cat, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id_departement , $id_bien)
    {
        $x = departement_bien::where('id_departement', $id_departement)
                                   ->where('id_bien', $id_bien)
                                   ->first();
        if(!$x){
            return response()->json(['message' => 'not found'], 404);
        }
        return response()->json($x);
    }

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(departement_bien $departement_bien)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /*public function update(Request $request, departement_bien $id_departement_bien)
    {
        $cat = departement_bien::find($id_departement_bien);
        if(!$cat){
            return response()->json(['message' => 'not found'], 404);
        }
        $cat->save();
        return $cat; $cat->save();
        return response()->json($cat);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id_departement ,$id_bien)
    {
        $deleted = departement_bien::deleteByCompositeKey($id_departement ,$id_bien);

        if ($deleted) {
            return response()->json(['message' => 'Supprimé avec succès']);
        } else {
            return response()->json(['message' => 'Zone non trouvée'], 404);
        }
    }
}
