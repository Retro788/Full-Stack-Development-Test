<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Api\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = User::query()
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return UserResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        // Verificar si el usuario está autenticado a través de JWT
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Validar y obtener los datos del request
        $data = $request->validated();
        $is_admin = $request->has('is_admin') ? true : false;
        
        // Asignar los valores recibidos al arreglo de datos
        $data['is_admin'] = $is_admin;
        $data['email_verified_at'] = now(); // Usar la función now() para obtener la fecha y hora actual
        $data['password'] = Hash::make($data['password']);
        $data['created_by'] = Auth::id(); // Obtener el ID del usuario autenticado a través de JWT
        $data['updated_by'] = Auth::id(); // Obtener el ID del usuario autenticado a través de JWT
        
        // Crear el usuario
        $user = User::create($data);
        
        // Devolver la respuesta con el recurso del usuario creado
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User         $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $data['updated_by'] = $request->user()->id;

        $user->update($data);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
   public function destroy(User $user)
    {
        $user->delete();

        return response("", 204);
    }   
    
   
}