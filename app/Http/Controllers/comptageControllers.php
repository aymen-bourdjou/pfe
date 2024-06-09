<?php

namespace App\Http\Controllers;

use App\Models\comptage_bien;
use App\Models\comptage;
use App\Models\inventaire;
use App\Models\departement_bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class comptageControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comptage = comptage::all();
        return response()->json($comptage);
    }
    public function import()
    {
        return view('comptage');
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
     * 'id_inventaire',
       * 'id_departement',
       * 'nom_comptage',
        **'date_creation',
        *'date_debut',
        *'date_fin',
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'id_inventaire' => 'required|exists:inventaires,id_inventaire',
        'id_departement' => 'required|exists:departements,id_departement',
        'nom_comptage' => 'required|string',
        'observation' => 'string',
        'id_user_createure' => 'required|exists:users,id_user',
    ]);

    // Si la validation échoue, retourner les erreurs
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $cat = new comptage();
    $cat->id_inventaire = $request->id_inventaire;
    $cat->id_departement = $request->id_departement;
    $cat->nom_comptage = $request->nom_comptage;
    $cat->id_user_createure=$request->id_user_createure;
    if($request->observation){
       $cat->observation=$request->observation;
    }
    
    $cat->save();
    $comptage = $cat;
    $departement_bien = null;
    if ($comptage) {
        $departement_bien = departement_bien::where('id_departement', $comptage->id_departement)
         ->where('etas_affectation','en cours')->get();
        //return response()->json($comptage->id_departement, 201);
    }
    if ($departement_bien) {
        foreach ($departement_bien as $departement_bien) {
            $comptage_bien = new comptage_bien();
            $comptage_bien->id_comptage = $comptage->id_comptage;
            $comptage_bien->id_bien = $departement_bien->id_bien;
            $comptage_bien->id_user_createure=$comptage->id_user_createure;
            $comptage_bien->save();
        }
    }
  }
    /**
     * Display the specified resource.
     */
    public function show( $id_comptage)
    {
        $x= comptage::find($id_comptage);
        if(!$x){
            return response()->json(['message' => 'not found'], 404);
        }
        return response()->json($x);
    }

    /**
     * Show the form for editing the specified resource.
     */
   /* public function edit(comptage $comptage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id_comptage)
    {
        $request->validate([
            'nom_comptage' => 'string',
            'observation' => 'string',
            'etas' => 'string|in:en attente de lancement,en cours,annulé,cloturé',
            'id_user_updateure' => 'required|exists:users,id_user',
        ]);
        $cat=comptage::findOrFail($id_comptage);
        if(!$cat){
            return response()->json(['message' => 'not found'], 404);
        }
        $inventaire =inventaire::where('id_inventaire',$cat->id_inventaire)->first();
        if($inventaire){
            if($inventaire->etas=='annulé'){
                return response()->json(['message' => 'impossible de modifier ce comptage car son inventaire a été annulé ']); 
            }
        if($inventaire->etas =='en attente de lancement' && ($request->etas == 'en cours' || $request->etas == 'cloturé' ) ){
            return response()->json(['message' => 'impossible de lancer ou cloturé le comptage avant de lancer l inventaire']);
        }}
        if ($request->has('etas') && $request->etas == 'cloturé') {
            $comptage_bien = comptage_bien::where('id_comptage', $id_comptage)->get();
            $etatNonCloture = $comptage_bien->contains(function ($comptage_bien) {
                return $comptage_bien->etas == 'non inventorié';
            });

            if ($etatNonCloture) {
                return response()->json([
                    'message' => 'Vous ne pouvez pas clôturer le comptage tant que ses bien ne sont pas clôturés'
                ], 400);
            }
        }
        if($cat->etas =='en attente de lancement' && $request->has('etas') && $request->etas == 'cloturé'){
            return response()->json(['message' => 'impossible de cloturé un comptage en attente de lancement']);
        }
        if($cat->etas =='en cours' && $request->has('etas') && $request->etas == 'en attente de lancement'){
            return response()->json(['message' => 'impossible de rendre en attente de lancement  un comptage en cours']);
        }
        if($cat->etas =='cloturé' && $request->has('etas') && $request->etas == 'en cours'){
            return response()->json(['message' => 'impossible de relancer un comptage cloturé']);
        }
        if($cat->etas =='cloturé' && $request->has('etas') && $request->etas == 'annulé'){
            return response()->json(['message' => 'impossible d annuler un comptage cloturé']);
        }
        if($cat->etas =='cloturé' && $request->has('etas') && $request->etas == 'en attente de lancement'){
            return response()->json(['message' => 'impossible de mettre en attente de lancement un comptage cloturé']);
        }
        if($cat->etas =='annulé' && $request->has('etas') && $request->etas == 'en cours'){
            return response()->json(['message' => 'impossible de relancer un comptage annulé']);
        }
        if($cat->etas =='annulé' && $request->has('etas') && $request->etas == 'en attente de lancement'){
            return response()->json(['message' => 'impossible de mettre en attente de lancement un comptage annulé']);
        }
        if($cat->etas =='annulé' && $request->has('etas') && $request->etas == 'cloturé'){
            return response()->json(['message' => 'impossible de cloturé un comptage annulé']);
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
        if($request->has('etas') && ($request->etas == 'annulé'|| $request->etas == 'cloturé')){
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
    public function destroy( $id_comptage)
    {
        $comptage = comptage::find($id_comptage);
    
        if (!$comptage) {
            return response()->json(['message' => 'comptage non trouvée'], 404);
        }
        comptage_bien::deleteByKey($comptage->id_comptage);
        $comptage->delete();
        
        return response()->json(['message' => 'comptage supprimée avec succès']);
    }
}
