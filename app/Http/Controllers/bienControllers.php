<?php

namespace App\Http\Controllers;

use App\Models\bien;
use App\Imports\BienImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class bienControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bien= bien::all();
        return response()->json($bien);
    }
    public function import()
    {
        return view('index');
    }
    public function importe_exel_data(Request $request){
        $request->validate([
            'import_file'=>[
                'required',
                'file'
            ],
        ]);
        $id_user_createure = 1;
        Excel::import(new BienImport($id_user_createure), $request->file('import_file'));
        //Excel::import(new BienImport, $request->file('import_file'));
        return redirect()->back()->with('status','imported successfuly');

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
            'id_user_importateure' => 'required|exists:users,id_user',
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
        $cat->id_user_importateure=$request->id_user_importateure;
        $cat->save();
        return response()->json($cat, 201);

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
            'id_user_updateure' => 'required|exists:users,id_user',
        ]);
        $bien = Bien::findOrFail($id);
        if (!$bien) {
            return response()->json(['message' => 'Bien non trouvé'], 404);
        }

        $bien->update($request->all());

        return response()->json($bien);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_bien)
    {
        $bien = bien::find($id_bien);
    
        if (!$bien) {
            return response()->json(['message' => 'bien non trouvée'], 404);
        }
        
        $bien->delete();
        
        return response()->json(['message' => 'bien supprimée avec succès']);
    }
}
