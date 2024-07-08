<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Models\employe;
use App\Models\role;
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
        $cat->password=bcrypt($request->password);
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


    public function index2()
{
    $users = user::all();
    $results = [];

    foreach ($users as $user) {
        $role = role::where('id_role', $user->id_role)->first();
        $employe = employe::where('id_employe', $user->id_employe)->first();

        // Vérifier si $role et $employe sont valides avant d'accéder à leurs propriétés
        if ($role && $employe) {
            // Construire chaque objet x pour chaque utilisateur
            $x = [
                'nom_employe' => $employe->nom_employe,
                'prenom_employe' => $employe->prenom_employe,
                'nom_role' => $role->nom_role,
                'id_user' => $user->id_user,
                'id_user_updateure' => $user->id_user_updateure,
                'email' => $user->email,
                'password' => $user->password,
                'id_user_createure' => $user->id_user_createure,
                'name' => $user->name,
                'date_debut_session' => $user->date_debut_session,
                'date_fin_session' => $user->date_fin_session,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
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
    /*public function edit(user $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_user)
    {
        // Validation des champs de la requête
        $request->validate([
            'id_role' => 'exists:roles,id_role',
            'name' => 'string',
            'email' => 'string',
            'password' => 'string|nullable', // Permettre un mot de passe nul
            'date_debut_session' => 'date|nullable',
            'date_fin_session' => 'date|nullable',
        ]);
       
        // Trouver l'utilisateur par son ID
        $user = User::findOrFail($id_user);
    
        // Exclure le mot de passe des données de mise à jour
        $updateData = $request->except(['password']); 
    
        // Crypter le mot de passe s'il est fourni
        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }
    
        // Mettre à jour le champ id_user_updateure
        $updateData['id_user_updateure'] = Auth::user()->id_user;
    
        // Appliquer les mises à jour à l'utilisateur
        $user->update($updateData);
    
        // Retourner les données de l'utilisateur mis à jour en réponse JSON
        return response()->json($user);
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
