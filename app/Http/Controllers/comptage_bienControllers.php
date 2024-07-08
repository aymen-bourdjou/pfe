<?php

namespace App\Http\Controllers;

use App\Models\comptage_bien;
use App\Models\bien;
use App\Models\comptage;
use App\Models\departement_bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class comptage_bienControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comptage_bien= comptage_bien::all();
        return response()->json($comptage_bien);
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
        *'id_comptage',
        *'date_affectation',
     */
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_bien' => 'required|exists:biens,id_bien',
            'id_comptage' => 'required|exists:comptages,id_comptage',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $comptage = comptage::where('id_comptage',$request->id_comptage )->first();
        $departement_bien = departement_bien::where('id_departement',$comptage->id_departement)->first();
        if($departement_bien){
        $cat = new comptage_bien();
        $cat->id_bien=$request->id_bien;
        $cat->id_comptage=$request->id_comptage;
        $cat->id_user_createure=Auth::user()->id_user;
        $cat->save();
        return response()->json($cat, 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( $id_comptage , $id_bien)
    {
        $x = comptage_bien::where('id_comptage', $id_comptage)
                                   ->where('id_bien', $id_bien)
                                   ->first();
        if(!$x){
            return response()->json(['message' => 'not found'], 404);
        }
        return response()->json($x);
    }





    public function showparcomptage($id_comptage)
    {
        // Récupérer tous les enregistrements de comptage_bien correspondant à l'id_comptage donné
        $comptage_biens = comptage_bien::where('id_comptage', $id_comptage)->get();
    
        // Vérifier si des enregistrements existent
        if ($comptage_biens->isEmpty()) {
            return response()->json(['message' => 'not found'], 404);
        }
    
        // Initialiser un tableau pour stocker les données finales
        $results = [];
    
        foreach ($comptage_biens as $comptage_bien) {
            // Récupérer les détails du bien associé à ce comptage_bien
            $bien = bien::where('id_bien', $comptage_bien->id_bien)->first();
    
            // Construire chaque objet x pour chaque comptage_bien
            $x = [
                'id_bien' => $comptage_bien->id_bien,
                'id_user_updateure' => $comptage_bien->id_user_updateure,
                'nom_bien' => $bien->nom_bien, // Utilisation des détails du bien
                'barcode' => $bien->barcode,
                'etas'=>$bien->etas,
                'etas_comptage' => $comptage_bien->etas,
                'created_at' => $comptage_bien->created_at,
                'updated_at' => $comptage_bien->updated_at,
            ];
    
            // Ajouter l'objet x au tableau des résultats
            $results[] = $x;
        }
    
        // Retourner la liste des résultats
        return response()->json($results);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(comptage_bien $comptage_bien)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /*public function update(Request $request, comptage_bien $id_comptage_bien)
    {
        $cat = comptage_bien::find($id_comptage_bien);
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
    public function updateEtas(Request $request,$id_comptage ,$id_bien)
    {
        $request->validate([
            'etas' => 'required|string|in:inventorie,non trouve',
            
        ]);
        $comptage = comptage::where('id_comptage',$id_comptage)->first();

        if($comptage){

            if($comptage->etas=='annule'){
                return response()->json(['message' => 'impossible d\'inventaurer ce bien car son comptage a été annulé']);
            }
        }
        $etas = $request->etas;
        $id_user_updateure = Auth::user()->id_user;
        $updateResult = comptage_bien::updatesansid($id_bien, $id_comptage, ['etas' => $etas ,  'id_user_updateure' =>  Auth::user()->id_user]);

        if ($updateResult) {
            if($request->etas=='non trouve'){
                return response()->json(['message' => 'Ce bien n\'a pas été trouvé '], 200);
            }else{
            return response()->json(['message' => 'Ce bien a été trouvé '], 200);
        }
        } else {
            return response()->json(['message' => 'Failed to update Etas'], 400);
        }
    }
    public function destroy( $id_comptage ,$id_bien)
    {
        $deleted = comptage_bien::deleteByCompositeKey($id_comptage ,$id_bien);

        if ($deleted) {
            return response()->json(['message' => 'Supprimé avec succès']);
        } else {
            return response()->json(['message' => 'comptage bien non trouvée'], 404);
        }
    }
}
