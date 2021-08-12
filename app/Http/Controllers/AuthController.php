<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.jwt', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        if(request(['username'])){
            $credentials = request(['username', 'password']);
        }else {
            $credentials = request(['email', 'password']);    
        }

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }   
    
    /**
    * Get a JWT via given credentials.
    *
    * @return \Illuminate\Http\JsonResponse
    */
   public function register()
   {
       $user = request(['name', 'email', 'password']);

        User::create([
           'username' => $user['username'],
           'first_name' => $user['first_name'],
           'last_name' => $user['last_name'],
           'email' => $user['email'],
           'password' => Hash::make($user['password']),
        ]);

        $credentials = [
            'email' => $user['email'],
            'password' => $user['password'],
        ];
        if (! $token = auth()->claims(['user' => $user['name']])->attempt($credentials)) {
           return response()->json(['error' => 'Unauthorized'], 401);
        }

       return $this->respondWithToken($token);
   }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        if(! auth()->check()){
            return response()->json(['error' => 'Unauthentificated'], 401); 
        }else {
          return response()->json(auth()->user());
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'username' => auth()->user()->username,
            'first_name' => auth()->user()->first_name,
            'last_name' => auth()->user()->last_name,
            'email' => auth()->user()->email,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
