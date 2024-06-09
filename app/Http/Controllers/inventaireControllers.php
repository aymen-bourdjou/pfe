<?php

namespace App\Http\Controllers;

use App\Models\inventaire;
use App\Models\comptage;
use App\Models\comptage_bien;
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
            'observation' => 'string',
            'id_user_createure' => 'required|exists:users,id_user',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $cat= new inventaire();
        $cat->nom_inventaire=$request->nom_inventaire;
        $cat->observation=$request->observation;
        $cat->id_user_createure=$request->id_user_createure;
        $cat->save();
        return response()->json($cat, 201);
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
        $request->validate([
             'nom_inventaire' => 'string',
            'observation' => 'string',
            'etas' => 'string|in:en attente de lancement,en cours,annulé,cloturé',
            'id_user_updateure' => 'required|exists:users,id_user',
        ]);
        $cat = inventaire::findOrFail($id_inventaire);
        if(!$cat){
            return response()->json(['message' => 'not found'], 404);
        }
        if ($request->has('etas') && $request->etas == 'cloturé' ) {
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
        if($cat->etas =='en attente de lancement' && $request->has('etas') && $request->etas == 'cloturé'){
            return response()->json(['message' => 'impossible de cloturé un inventaire en attente de lancement']);
        }
        if($cat->etas =='en cours' && $request->has('etas') && $request->etas == 'en attente de lancement'){
            return response()->json(['message' => 'impossible de rendre en attente de lancement  un inventaire en cours']);
        }
        if($cat->etas =='cloturé' && $request->has('etas') && $request->etas == 'en cours'){
            return response()->json(['message' => 'impossible de relancer un inventaire cloturé']);
        }
        if($cat->etas =='cloturé' && $request->has('etas') && $request->etas == 'annulé'){
            return response()->json(['message' => 'impossible d annuler un inventaire cloturé']);
        }
        if($cat->etas =='cloturé' && $request->has('etas') && $request->etas == 'en attente de lancement'){
            return response()->json(['message' => 'impossible de mettre en attente de lancement un inventaire cloturé']);
        }
        if($cat->etas =='annulé' && $request->has('etas') && $request->etas == 'en cours'){
            return response()->json(['message' => 'impossible de relancer un inventaire annulé']);
        }
        if($cat->etas =='annulé' && $request->has('etas') && $request->etas == 'en attente de lancement'){
            return response()->json(['message' => 'impossible de mettre en attente de lancement un inventaire annulé']);
        }
        if($cat->etas =='annulé' && $request->has('etas') && $request->etas == 'cloturé'){
            return response()->json(['message' => 'impossible de cloturé un inventaire annulé']);
        }
        if($cat->etas =='annulé' && $request->has('etas') && $request->etas == 'annulé'){
            return response()->json($cat);
        }
        if($cat->etas =='cloturé' && $request->has('etas') && $request->etas == 'cloturé'){
            return response()->json($cat);
        }
        if($cat->etas =='en attente de lancement' && $request->has('etas') && $request->etas == 'en attente de lancement'){
            return response()->json($cat);
        }
        if($cat->etas =='en cours' && $request->has('etas') && $request->etas == 'en cours'){
            return response()->json($cat);
        }
        if($request->has('etas') &&  $request->etas == 'cloturé'){
            $cat->date_fin = Carbon::now();
        }
        if($request->has('etas') && $request->etas == 'annulé'){
            $comptages = comptage::where('id_inventaire', $id_inventaire)->get();
            foreach ($comptages as $comptage) {
                $comptage->etas = 'annulé';
                $comptage->save();
            }
        
            $cat->date_fin = Carbon::now();
        }
        if($request->has('etas') && $request->etas == 'en cours'){
            $cat->date_debut = Carbon::now();
            
        }
        if($request->observation){
            $cat->observation=$request->observation;
        }
        $cat->etas=$request->etas;
        $cat->id_user_updateure=$request->id_user_updateure;
        $cat->save();

        return response()->json($cat);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id_inventaire)
    {
        $inventaire = inventaire::find($id_inventaire);
    
        if (!$inventaire) {
            return response()->json(['message' => 'inventaire non trouvee'], 404);
        }
        $comptages = comptage::where('id_inventaire', $id_inventaire)->get();
        foreach ($comptages as $comptage) {
            comptage_bien::deleteByKey($comptage->id_comptage);
            $comptage->delete();
        }
        $inventaire->delete();
        
        
        
        return response()->json(['message' => 'inventaire supprimee avec succes']);
    }
}
