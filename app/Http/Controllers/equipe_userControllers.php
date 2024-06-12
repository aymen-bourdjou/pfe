<?php

namespace App\Http\Controllers;

use App\Models\equipe_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class equipe_userControllers extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipe_user= equipe_user::all();
        return response()->json($equipe_user);
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
     * 'id_equipe',
        *'id_user',
        *'date_debut',
        *'date_fin',
        *'role',
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_equipe' => 'required|exists:equipes,id_equipe',
            'id_user' => 'required|exists:users,id_user',
            
        ]);

        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $cat = new equipe_user();
        $cat->id_equipe=$request->id_equipe;
        $cat->id_user=$request->id_user;
        $cat->id_user_createure=Auth::user()->id_user;
        $cat->save();
        return response()->json($cat, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id_equipe, $id_user)
{
    $cat = equipe_user::where('id_equipe', $id_equipe)
                                   ->where('id_user', $id_user)
                                   ->first();

    if(!$cat){
        return response()->json(['message' => 'not found'], 404);
    }

    return response()->json($cat);
}

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(equipe_user $equipe_user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /*public function update(Request $request, $id_equipe, $id_user)
    {
        $update = equipe_user::updatebycompositekey($id_equipe, $id_user);

        if ($update) {
            return response()->json(['message' => 'modifier avec succès']);
        } else {
            return response()->json(['message' => 'Zone non trouvée'], 404);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_equipe,$id_user)
    {
        $deleted = equipe_user::deleteByCompositeKey($id_equipe, $id_user);

        if ($deleted) {
            return response()->json(['message' => 'Supprimé avec succès']);
        } else {
            return response()->json(['message' => 'Zone non trouvée'], 404);
        }
    }
}
