<?php

namespace App\Http\Controllers;

use App\Models\inventaire;
use App\Models\comptage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
class inventaireControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventaire =inventaire::all();
        return response()->json($inventaire);
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
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_inventaire' => 'required|string',
            'date_creation' => 'nullable|date',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $cat= new inventaire();
        $cat->nom_inventaire=$request->nom_inventaire;
        $cat->date_creation = $cat->date_creation = Carbon::now();
        $cat->save();
        return response()->json($cat, 201);
    }
    public function lancer($id_inventaire)
    {
        $cat=inventaire::findOrFail($id_inventaire);
        if(!$cat){
            return response()->json(['message' => 'not found'], 404);
        }
        $cat->date_debut = Carbon::now();
        $cat->etas ='en cours';
        $cat->save();
        return response()->json($cat, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id_inventaire)
    {
        $x= inventaire::find($id_inventaire);
        if(!$x){
            return response()->json(['message' => 'not found'], 404);
        }
        return response()->json($x);
    }

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(inventaire $inventaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_inventaire)
    {
        $validator = Validator::make($request->all(), [
            'nom_inventaire' => 'string',
            'date_creation' => 'nullable|date',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'observation' => 'nullable|string',
            'etas' => 'nullable|string|in:en attente de lancement,en cours,annulé,cloturé',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cat = inventaire::findOrFail($id_inventaire);

        if ($request->has('etas') && $request->etas == 'cloturé') {
            $comptages = comptage::where('id_inventaire', $id_inventaire)->get();
            $etatNonCloture = $comptages->contains(function ($comptage) {
                return $comptage->etas != 'cloturé';
            });

            if ($etatNonCloture) {
                return response()->json([
                    'message' => 'Vous ne pouvez pas clôturer l\'inventaire tant que ses comptages ne sont pas clôturés'
                ], 400);
            }
        }

        $cat->update($validator->validated());

        return response()->json($cat);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id_inventaire)
    {
        $inventaire = inventaire::find($id_inventaire);
    
        if (!$inventaire) {
            return response()->json(['message' => 'Zone non trouvée'], 404);
        }
        
        $inventaire->delete();
        
        return response()->json(['message' => 'Zone supprimée avec succès']);
    }
}
