<?php

namespace App\Http\Controllers;

use App\Models\role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class roleControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = role::all();
        return response()->json($role);
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
            'nom_role' => 'required|string',
            
        ]);
    
        // Si la validation échoue, retourner les erreurs
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $cat = new role();
        $cat->nom_role=$request->nom_role;
        $cat->id_user_createure=Auth::user()->id_user;
        $cat->save();
        return response()->json($cat, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id_role)
    {
        $x= role::find($id_role);
        if(!$x){
            return response()->json(['message' => 'not found'], 404);
        }
        return response()->json($x);
    }

    public function show_etas()
    {
        
        $x= role::where('etas','actife')->get();
        if(!$x){
            return response()->json(['message' => 'not found'], 404);
        }
        return response()->json($x);
    }

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id_role)
    {
        $request->validate([
            'nom_role' => 'string',
            'etas' => 'string|in:actife,bloque',
        ]);
        $role = role::findOrFail($id_role); 
        if(!$role){
            return response()->json(['message' => 'not found'], 404);
        }
        $role->id_user_updateure = Auth::user()->id_user;
        if($request->has('etas')){
            $role->etas=$request->etas;
        }
        
        $role->update($request->all());
       

    return response()->json($role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id_role)
    {
        $role = role::find($id_role);
    
        if (!$role) {
            return response()->json(['message' => 'role non trouvée'], 404);
        }
        
        $role->delete();
        
        return response()->json(['message' => 'role supprimée avec succès']);
    }
}
