<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrateur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ApiAdminAuthController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->only("email", "password");
        $administrateur = Administrateur::where('email', $credentials['email'])
        ->where('password', $credentials['password']);
    
        if (!$administrateur->exists()) {
            $data = [
                'error' => true,
                'message' => "Mail ou mot de passe incorrect"
            ];

            return response()->json($data, 404);
        }

        $administrateur = $administrateur->first();

        $data = [
            "success" => true,
            "administrateur" => $administrateur
        ];

        return response()->json($data);

    }

    public function logout(Request $request) {
        $token = explode(" ", $request->header('Authorization'))[1];
        $administrateur = Administrateur::where('api_token', $token)->first();

        if (!$administrateur) {
            $data = [
                "error" => true,
                "message" => "Une erreure est survenue"
            ];

            return response()->json($data, 500);
        }

        $administrateur->api_token = Str::random(60);

        $administrateur->save();

        $data = [
            "success" => true,
        ];

        return response()->json($data, 200);
    }

    
}
