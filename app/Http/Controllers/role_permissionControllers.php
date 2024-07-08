<?php

namespace App\Http\Controllers;

use App\Models\role_permission;
use App\Models\permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class role_permissionControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role_permission= role_permission::all();
        return response()->json($role_permission);
    }


    public function showparrole($id_role)
    {
        // Récupère tous les id_permission associés au rôle donné
        $permissionsInRole = role_permission::where('id_role', $id_role)->pluck('id_permission');
    
        // Récupère toutes les permissions dont l'id_permission est dans la liste des permissions récupérées
        $permissions = permission::whereIn('id_permission', $permissionsInRole)->get();
    
        // Si aucune permission n'est trouvée, retourne une réponse 404
        if ($permissions->isEmpty()) {
            return response()->json(['message' => 'not found'], 404);
        }
    
        // Retourne les permissions en format JSON
        return response()->json($permissions);
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
            'id_role' => 'required|exists:roles,id_role',
            'id_permission' => 'required|exists:permissions,id_permission',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $role_permission= role_permission::where('id_role', $request->id_role)
                                   ->where('id_permission', $request->id_permission)
                                   ->first();

        if($role_permission){
            return response()->json(['message' => 'la combinaison existe deja']);
        }
        $cat = new role_permission();
        $cat->id_role=$request->id_role;
        $cat->id_permission=$request->id_permission;
        $cat->id_user_createure=Auth::user()->id_user;
        $cat->save();
        return response()->json($cat, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id_role , $id_permission)
    {
        $x = role_permission::where('id_role', $id_role)
        ->where('id_permission', $id_permission)
        ->first();
if(!$x){
return response()->json(['message' => 'not found'], 404);
}
return response()->json($x);
        
    }
    public function showparnonrole($id_role)
    {
        // Récupérer les id_permission qui sont dans l'équipe donnée
        $permissionsInrole = role_permission::where('id_role', $id_role)->pluck('id_permission');
    
        // Récupérer les utilisateurs qui ne sont pas dans cette équipe
        $permissions = permission::whereNotIn('id_permission', $permissionsInrole)->get();
    
        if($permissions->isEmpty()){
            return response()->json(['message' => 'No permissions found'], 404);
        }
    
        return response()->json($permissions);
    }
    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(role_permission $role_permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /*public function update(Request $request,  $id_role ,$id_permission)
    {
        $request->validate([
            'date_debut' => 'required|date',
        ]);

        $role_permission = role_permission::updatesansid($id_role, $id_permission, ['date_debut' =>$request->date_debut]);

        if ($role_permission) {
            return response()->json(['message' => 'date debut updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to update date debut'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id_role ,$id_permission)
    {
        $deleted = role_permission::deleteByCompositeKey($id_role ,$id_permission);

        if ($deleted) {
            return response()->json(['message' => 'combinaison Supprimé avec succès']);
        } else {
            return response()->json(['message' => 'combinaison non trouvée'], 404);
        }
    }
}
