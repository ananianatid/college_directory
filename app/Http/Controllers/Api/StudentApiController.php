<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentApiController extends Controller
{
    /**
     * V\u00e9rifier les identifiants de l'\u00e9tudiant et retourner ses donn\u00e9es
     * 
     * Route ouverte pour le moment comme demand\u00e9 par l'utilisateur.
     * M\u00e9thode POST: /api/students/verify
     */
    public function verify(Request $request)
    {
        // 1. Validation de base des donn\u00e9es re\u00e7ues
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation des donn\u00e9es.',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Recherche de l'utilisateur par email
        $user = User::where('email', $request->email)->first();

        // 3. V\u00e9rification de l'existence de l'utilisateur et du mot de passe
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email ou mot de passe incorrect.'
            ], 401);
        }

        // 4. V\u00e9rification que l'utilisateur est bien un \u00e9tudiant
        $student = $user->student()->with('filiere')->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun dossier \u00e9tudiant associ\u00e9 \u00e0 cet utilisateur.'
            ], 403);
        }

        // 5. Retourner les donn\u00e9es de l'\u00e9tudiant
        return response()->json([
            'success' => true,
            'message' => 'Authentification r\u00e9ussie.',
            'data' => $student
        ], 200);
    }
}