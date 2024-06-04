<?php

namespace App\Http\Controllers;

use App\Models\role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
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
        $cat = new role();
        $cat->nom_role=$request->nom_role;
        $cat->date_creation = Carbon::now();
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
            'date_creation'=>'date',
        ]);
        $role = role::findOrFail($id_role); 
        if(!$role){
            return response()->json(['message' => 'not found'], 404);
        }
        $role->update($request->all());
        $role->save();

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
