<?php

namespace App\Http\Controllers;

use App\Models\permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class permissionControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permission = permission::all();
        return response()->json($permission);
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
            'nom_permission' => 'required|string',
        ]);
    
        // Si la validation échoue, retourner les erreurs
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $cat = new permission();
        $cat->nom_permission=$request->nom_permission;
        $cat->save();
        return response()->json($cat, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id_permission)
    {
        $x= permission::find($id_permission);
        if(!$x){
            return response()->json(['message' => 'not found'], 404);
        }
        return response()->json($x);
    }

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id_permission)
    {
        $request->validate([
            'nom_permission' => 'string',
            
        ]);
        $cat= permission::findOrFail($id_permission);
        if(!$cat){
            return response()->json(['message' => 'not found'], 404);
        }
        $cat->update($request->all());
        return response()->json($cat);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id_permission)
    {
        $permission = permission::find($id_permission);
    
        if (!$permission) {
            return response()->json(['message' => 'permission non trouvée'], 404);
        }
        
        $permission->delete();
        
        return response()->json(['message' => 'permission supprimée avec succès']);
    }
}
