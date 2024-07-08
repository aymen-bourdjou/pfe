<?php
namespace App\Http\Controllers;
use App\Models\role;
use Carbon\Carbon;
use App\Models\role_permission;
use App\Models\permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthControllers extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $aujourdhui = Carbon::today();
            if($user->date_fin_session){
               if($user->date_debut_session <= $aujourdhui->toDateString() && $user->date_fin_session >  $aujourdhui->toDateString()){
                $token = $user->createToken('API Token')->plainTextToken;
                $role = role::where('id_role', $user->id_role)->first();
                $role_permissions = role_permission::where('id_role', $role->id_role)->get();
                $permissions = [];
                foreach ($role_permissions as $role_permissions) {
                    $permission = permission::where('id_permission',  $role_permissions->id_permission)->first();
                    $permissions[] =$permission->nom_permission;
            }
    
            
                return response()->json([
                    'token' => $token,
                    'user' => [
                        'id_user' => $user->id_user,  // Assurez-vous que 'id_user' existe dans votre modèle User
                        'name' => $user->name,
                        'role'=>$role->nom_role,
                        'email' => $user->email,
                        'permissions' => $permissions 
                    ]
                ]);
            }else{
                return response()->json(['message' => 'Invalid 1credentials'], 401); 
            }  
            }else{
                if($user->date_debut_session <= $aujourdhui->toDateString()){
                    $token = $user->createToken('API Token')->plainTextToken;
                    $role = role::where('id_role', $user->id_role)->first();
                    $role_permissions = role_permission::where('id_role', $role->id_role)->get();
                    $permissions = [];
                    foreach ($role_permissions as $role_permissions) {
                        $permission = permission::where('id_permission',  $role_permissions->id_permission)->first();
                        $permissions[] =$permission->nom_permission;
                }
        
                
                    return response()->json([
                        'token' => $token,
                        'user' => [
                            'id_user' => $user->id_user,  // Assurez-vous que 'id_user' existe dans votre modèle User
                            'name' => $user->name,
                            'role'=>$role->nom_role,
                            'email' => $user->email,
                            'permissions' => $permissions 
                        ]
                    ]);
                }else{
                    return response()->json(['message' => 'Invalid 1credentials'], 401); 
                }  
            }
           
          
        }

        return response()->json(['message' => 'Invalid 1credentials'], 401);
    }

    public function deconexion()
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return response()->json(['data' => "user deconecter "]);
    }
}

