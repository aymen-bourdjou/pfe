<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Models\employe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class userControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = user::all();
        return response()->json($user);
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
            'id_employe' =>'required|exists:employes,id_employe',
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'date_debut_session' =>'required|date',
            'date_fin_session' =>'date',
            
        ]);
    
        // Si la validation échoue, retourner les erreurs
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $cat = new user();
        $cat->name=$request->name;
        $cat->id_employe=$request->id_employe;
        $cat->email=$request->email;
        $cat->password=$request->password;
        $cat->id_role=$request->id_role;
        $cat->date_debut_session=$request->date_debut_session;
        $cat->id_user_createure=Auth::user()->id_user;
        if($request->date_fin_session){
        $cat->date_fin_session=$request->date_fin_session;
        }
        $cat->save();
        return response()->json($cat, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id_user)
    {
        $x= user::find($id_user);
        if(!$x){
            return response()->json(['message' => 'not found'], 404);
        }
        return response()->json($x);
    }

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(user $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_user)
{
    $request->validate([
        'id_role' => 'exists:roles,id_role',
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'date_debut_session' => 'date',
        'date_fin_session' => 'date',
        
    ]);
   
    $cat= user::findOrFail($id_user);
        if(!$cat){
            return response()->json(['message' => 'not found'], 404);
        }
        $cat->id_user_updateure = Auth::user()->id_user;
        $cat->update($request->all());
        return response()->json($cat);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id_user)
    {
        $user = user::find($id_user);
    
        if (!$user) {
            return response()->json(['message' => 'user non trouvée'], 404);
        }
        
        $user->delete();
        
        return response()->json(['message' => 'user supprimée avec succès']);
    }
}
