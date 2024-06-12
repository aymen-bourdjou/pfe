<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\inventaire;
use App\Models\comptage;
use App\Models\comptage_bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Exports\inventaireExport;
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
            //'id_user_createure' => 'required|exists:users,id_user',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $cat= new inventaire();
        $cat->nom_inventaire=$request->nom_inventaire;
        $cat->observation=$request->observation;
        $cat->id_user_createure=Auth::user()->id_user;
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
            'etas' => 'string|in:en attente de lancement,en cours,annule,cloture',
         
        ]);
        $cat = inventaire::findOrFail($id_inventaire);
        if(!$cat){
            return response()->json(['message' => 'not found'], 404);
        }
        if ($request->has('etas') && $request->etas == 'cloture' ) {
            $comptages = comptage::where('id_inventaire', $id_inventaire)->get();
            $etatNonCloture = $comptages->contains(function ($comptage) {
                return $comptage->etas != 'cloture';
            });

            if ($etatNonCloture) {
                return response()->json([
                    'message' => 'Vous ne pouvez pas clôturer l\'inventaire tant que ses comptages ne sont pas clôturés'
                ], 400);
            }
        }
        if($cat->etas =='en attente de lancement' && $request->has('etas') && $request->etas == 'cloture'){
            return response()->json(['message' => 'impossible de cloture un inventaire en attente de lancement']);
        }
        if($cat->etas =='en cours' && $request->has('etas') && $request->etas == 'en attente de lancement'){
            return response()->json(['message' => 'impossible de rendre en attente de lancement  un inventaire en cours']);
        }
        if($cat->etas =='cloture' && $request->has('etas') && $request->etas == 'en cours'){
            return response()->json(['message' => 'impossible de relancer un inventaire cloture']);
        }
        if($cat->etas =='cloture' && $request->has('etas') && $request->etas == 'annule'){
            return response()->json(['message' => 'impossible d annuler un inventaire cloture']);
        }
        if($cat->etas =='cloture' && $request->has('etas') && $request->etas == 'en attente de lancement'){
            return response()->json(['message' => 'impossible de mettre en attente de lancement un inventaire cloture']);
        }
        if($cat->etas =='annule' && $request->has('etas') && $request->etas == 'en cours'){
            return response()->json(['message' => 'impossible de relancer un inventaire annule']);
        }
        if($cat->etas =='annule' && $request->has('etas') && $request->etas == 'en attente de lancement'){
            return response()->json(['message' => 'impossible de mettre en attente de lancement un inventaire annule']);
        }
        if($cat->etas =='annule' && $request->has('etas') && $request->etas == 'cloture'){
            return response()->json(['message' => 'impossible de cloture un inventaire annule']);
        }
        if($cat->etas =='annule' && $request->has('etas') && $request->etas == 'annule'){
            return response()->json($cat);
        }
        if($cat->etas =='cloture' && $request->has('etas') && $request->etas == 'cloture'){
            return response()->json($cat);
        }
        if($cat->etas =='en attente de lancement' && $request->has('etas') && $request->etas == 'en attente de lancement'){
            return response()->json($cat);
        }
        if($cat->etas =='en cours' && $request->has('etas') && $request->etas == 'en cours'){
            return response()->json($cat);
        }
        if($request->has('etas') &&  $request->etas == 'cloture'){
            $cat->date_fin = Carbon::now();
        }
        if($request->has('etas') && $request->etas == 'annule'){
            $comptages = comptage::where('id_inventaire', $id_inventaire)->get();
            foreach ($comptages as $comptage) {
                $comptage->etas = 'annule';
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
        if($request->etas){
        $cat->etas=$request->etas;
        }
        $user = $request->user();
if ($user) {
    $cat->id_user_updateure = Auth::user()->id_user;
} else {
    // Gérer le cas où l'utilisateur n'est pas authentifié
    // Ou rediriger vers la page de connexion, etc.
    return response()->json(['message' => 'Utilisateur non authentifié'], 401);
}
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
