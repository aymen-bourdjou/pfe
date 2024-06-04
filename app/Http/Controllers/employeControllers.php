<?php

namespace App\Http\Controllers;

use App\Models\employe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class employeControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employe= employe::all();
        return response()->json($employe);
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
     * 'nom_employe',
       * 'prenom_employe',
        *'username',
        *'password',
        *'profil',
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom_employe' => 'required|string',
            'prenom_employe' => 'required|string',
            'username' => 'required|string|unique:employes',
            'password' => 'required|string',
            'profil' => 'required|string',
        ]);

        // Si la validation échoue, retourner les erreurs
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $cat=new employe();
        $cat->nom_employe=$request->nom_employe;
        $cat->prenom_employe=$request->prenom_employe;
        $cat->username=$request->username;
        $cat->password=$request->password;
        $cat->profil=$request->profil;
        $cat->save();
        return response()->json($cat, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id_employe)
    {
        $x= employe::find($id_employe);
        if(!$x){
            return response()->json(['message' => 'not found'], 404);
        }
        return response()->json($x);
    }

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(employe $employe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id_employe)
    {
        $cat= employe::findOrFail($id_employe);
        if(!$cat){
            return response()->json(['message' => 'not found'], 404);
        }
        $cat->update($request->all());
        return response()->json($cat);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id_employe)
    {
        $employe = employe::find($id_employe);
    
        if (!$employe) {
            return response()->json(['message' => 'Zone non trouvée'], 404);
        }
        
        $employe->delete();
        
        return response()->json(['message' => 'Zone supprimée avec succès']);
    }
}
