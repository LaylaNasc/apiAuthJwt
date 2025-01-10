<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function registra(StoreUserRequest $request)
        {
            try {
                // Criar o usuário
                $user = User::create([
                    'nome' => $request->nome,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'cargo' => $request->cargo,
                ]);
        
                $token = auth()->login($user);
        
                // Retornar o usuário com o token
                return $this->responderComToken($token)->setStatusCode(201);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Error ao criar novo usuário',
                    'details' => $e->getMessage(),
                ], 500);
            }
        }
    
     /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Invalid email or password.'], 401);
        }
    
        return $this->responderComToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function obterUsuario()
    {
        return response()->json(auth()->user());
    }
  
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
  
        return response()->json(['message' => 'Logout feito com sucesso!']);
    }
  
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function atualizarToken()
    {
        return $this->responderComToken(auth()->refresh());
    }
  
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responderComToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}
