<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthControllers extends Controller
{
    public function afficher()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
           $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;
        //return redirect()->intended('/api/bien/exel_bien');
            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
    public function deconexion(){
        $user = Auth :: user();
        $user->currentAccessToken()->delete();
        return response()->json(['data' => "user deconecter "]);
    }
}
