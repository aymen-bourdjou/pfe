<?php

namespace App\Http\Controllers;

use App\Models\bien;
use App\Models\departement_bien;
use App\Models\departement;
use App\Models\zone;
use App\Imports\BienImport;
use App\Imports\BienImportsansinv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
class bienControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
   /* public function index()
    {
        $bien= bien::all();
        return response()->json($bien);
    }*/
    public function import()
    {
        return view('index');
    }
   
    public function importe_exel_data_sansinv(Request $request)
{
    $request->validate([
        'import_file' => [
            'required',
            'file'
        ],
    ]);

    try {
        Excel::import(new BienImportsansinv, $request->file('import_file'));
        return response()->json(['status' => 'Imported successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error ijojojojmporting file: ' . $e->getMessage()], 400);
    }
}

    public function importe_exel_data(Request $request){
        $request->validate([
            'import_file'=>[
                'required',
                'file'
            ],
        ]);
        try {
        Excel::import(new BienImport($request->id_inventaire), $request->file('import_file'));
        return response()->json(['status' => 'Imported successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error importing file: ' . $e->getMessage()], 400);
    }
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
            'nom_bien' => 'required|string',
            'prix_d_achat' => 'required|string',
            'barcode' => 'required|string',
            'date_achat' => 'required|date',
            'duree_vie' => 'required|integer',
            'fournisseure' => 'required|string',
            'etas' =>'required|string',
            'no_serie' =>'required|string',
            
            
        ]);
    
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $cat=new bien();
        $cat->nom_bien=$request->nom_bien;
        $cat->prix_d_achat=$request->prix_d_achat;
        $cat->barcode=$request->barcode;
        $cat->date_achat=$request->date_achat;
        $cat->duree_vie=$request->duree_vie;
        $cat->fournisseure=$request->fournisseure;
        $cat->etas=$request->etas;
        $cat->no_serie=$request->no_serie;
        $cat->id_user_importateure=Auth::user()->id_user;
        $cat->save();
        return $cat->id_bien;

    }

    /**
     * Display the specified resource.
     */
    public function show( $id_bien)
    {
        $x= bien::find($id_bien);
        if(!$x){
            return response()->json(['message' => 'not found'], 404);
        }
        return response()->json($x);
    }
    
    public function index()
    {
        $biens = bien::all();
        $results = [];
    
        foreach ($biens as $bien) {
            // Récupérer les détails du département associé à ce bien
            $departement_bien = departement_bien::where('id_bien', $bien->id_bien)
                ->where('etas_affectation', 'en cours')->first();
            
            if ($departement_bien) {
                $departement = departement::where('id_departement', $departement_bien->id_departement)->first();
                $zone = zone::where('id_zone', $departement->id_zone)->first();
    
                // Construire chaque objet x pour chaque bien
                $x = [
                    'nom_zone' => $zone->nom_zone,
                    'nom_departement' => $departement->nom_departement,
                    'affecter_a' => $departement_bien->affecter_a,
                    'id_bien' => $bien->id_bien,
                    'id_user_updateure' => $bien->id_user_updateure,
                    'prix_d_achat' => $bien->prix_d_achat,
                    'date_achat' => $bien->date_achat,
                    'duree_vie' => $bien->duree_vie,
                    'fournisseure' => $bien->fournisseure,
                    'no_serie' => $bien->no_serie,
                    'id_user_importateure' => $bien->id_user_importateure,
                    'nom_bien' => $bien->nom_bien,
                    'barcode' => $bien->barcode,
                    'etas' => $bien->etas,
                    'created_at' => $bien->created_at,
                    'updated_at' => $bien->updated_at,
                ];
    
                // Ajouter l'objet x au tableau des résultats
                $results[] = $x;
            }
        }
    
        // Retourner les résultats au format JSON
        return response()->json($results);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
   /* public function edit(bien $bien)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_bien' => 'string',
            'prix_d_achat' => 'string',
            'barcode' => 'string',
            'date_achat' => 'date',
            'duree_vie' => 'integer',
            'fournisseure' => 'string',
            'etas' =>'string',
            'no_serie' =>'string',
            
        ]);
        $bien = Bien::findOrFail($id);
        if (!$bien) {
            return response()->json(['message' => 'Bien non trouvé'], 404);
        }
        $bien->id_user_updateure = Auth::user()->id_user;
        
        $bien->update($request->all());

        return response()->json($bien);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id_bien)
    {
        $bien = bien::find($id_bien);
    
        if (!$bien) {
            return response()->json(['message' => 'bien non trouvee'], 404);
        }
        $departement_bien = departement_bien::where('id_bien', $id_bien)->first();
        if ($departement_bien) {
            departement_bien::deleteByCompositeKey($departement_bien->id_departement,$departement_bien->id_bien);
            $bien->delete();
        }
        $bien->delete();
        
        
        
        return response()->json(['message' => 'bien supprimee avec succes']);
    }
}
