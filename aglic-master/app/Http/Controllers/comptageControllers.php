<?php

namespace App\Http\Controllers;

use App\Models\comptage_bien;
use App\Models\comptage;
use App\Models\departement_bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
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
    ]);

    // Si la validation échoue, retourner les erreurs
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $cat = new comptage();
    $cat->id_inventaire = $request->id_inventaire;
    $cat->id_departement = $request->id_departement;
    $cat->nom_comptage = $request->nom_comptage;
    $cat->date_creation = Carbon::now();

    $cat->save();
    $comptage = $cat;
    $departement_bien = null;
    if ($comptage) {
        $departement_bien = departement_bien::where('id_departement', $comptage->id_departement)->get();
        //return response()->json($comptage->id_departement, 201);
    }
    if ($departement_bien) {
        foreach ($departement_bien as $departement_bien) {
            $comptage_bien = new comptage_bien();
            $comptage_bien->id_comptage = $comptage->id_comptage;
            $comptage_bien->id_bien = $departement_bien->id_bien;
            $comptage_bien->save();
        }
    }
  }

    public function lancer($id_comptage)
    {
        $cat=comptage::findOrFail($id_comptage);
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
    public function update(Request $request,  $id_comptage)
    {
        $cat=comptage::findOrFail($id_comptage);
        if(!$cat){
            return response()->json(['message' => 'not found'], 404);
        }
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
        $cat->update($request->all());
        return response()->json($cat);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id_comptage)
    {
        $comptage = comptage::find($id_comptage);
    
        if (!$comptage) {
            return response()->json(['message' => 'Zone non trouvée'], 404);
        }
        
        $comptage->delete();
        
        return response()->json(['message' => 'Zone supprimée avec succès']);
    }
}
