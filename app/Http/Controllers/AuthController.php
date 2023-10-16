<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService; // Importa el servicio de autenticación
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        // autentica al usuario
        if (!Auth::attempt($request->only('email', 'password'))) 
        {
            error_log('Intento de inicio de sesión fallido para el correo electrónico: ' . $request->input('email'));
            return response()
                ->json(['message' => 'Correo electrónico o contraseña incorrectos.', 'status'=> 401]);
        } 

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json([
                'message' => 'Authentiqued',
                'accessToken' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ], 200);
        
    }
    
    public function register(RegisterRequest $request)
    {
        try {
            
            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;//Poner tiempo limite de 6 meses

            return response()->json([
                'data' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 200);

        } catch (\Exception $e) {
            
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return ['message' => 'You hace successfully logged out and the token was successfully deleted'];
    }
}
