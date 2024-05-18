<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function signup(CreateUserRequest $request)
    {
        $data = $request->validated();
    
    
        /** @var \App\Models\User $user */
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'is_admin' => $data['is_admin'] ?? false
            
           
        ]);

        $token = $user->createToken('main')->plainTextToken;
        return response(compact('user', 'token'));
    }
    public function login(LoginRequest $request)
    {
         // Validar las credenciales del usuario
         $credentials = $request->only('email', 'password');

         try {
             // Intentar autenticar al usuario y generar el token JWT
             if (!$token = JWTAuth::attempt($credentials)) {
                 return response()->json(['message' => 'Email or password is incorrect'], 422);
             }
         } catch (JWTException $e) {
             return response()->json(['message' => 'Could not create token'], 500);
         }
 
         // Obtener el usuario autenticado
         $user = auth()->user();
 
         // Verificar si el usuario es un administrador
         if (!$user->is_admin) {
             return response()->json(['message' => 'You don\'t have permission to authenticate as admin'], 403);
         }
 
         // Verificar si el email del usuario está verificado
         if (!$user->email_verified_at) {
            Auth::logout();
            return response()->json(['message' => 'Your email address is not verified'], 403);
        }
 
         // Devolver la respuesta con el usuario y el token JWT
         return response()->json([
             'user' => new UserResource($user),
             'token' => $token
         ]);
     

    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }
        return response('', 204);
    }

    public function getUser(Request $request)
    {
        return new UserResource($request->user());
    }
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            // El usuario no existe en la base de datos
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    
        $token = Password::createToken($user);
        
        Notification::send($user, new ResetPasswordNotification($token));
        return response()->json(['message' => 'Password reset email sent successfully']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(40), // Generar nuevo token de recordar sesión
                ])->save();
    
                event(new PasswordReset($user));
            }
        );
    
        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Contraseña cambiada con éxito'])
            : response()->json(['message' => 'Error al cambiar la contraseña'], 500);
    }
}