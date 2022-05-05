<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->only("email", "password");
    
        if (!Auth::guard('user')->once($credentials)) {
            $data = [
                'error' => true,
                'message' => "Mail ou mot de passe incorrect"
            ];

            return response()->json($data, 404);
        }

        $utilisateur = Utilisateur::where('email', $credentials['email'])->first();

        $data = [
            "success" => true,
            "utilisateur" => $utilisateur
        ];

        return response()->json($data);

    }

    public function logout(Request $request) {
        $token = explode(" ", $request->header('Authorization'))[1];
        $utilisateur = Utilisateur::where('api_token', $token)->first();

        if (!$utilisateur) {
            $data = [
                "error" => true,
                "message" => "Une erreure est survenue"
            ];

            return response()->json($data, 500);
        }

        $utilisateur->api_token = Str::random(60);

        $utilisateur->save();

        $data = [
            "success" => true,
        ];

        return response()->json($data, 200);
    }

    
}
