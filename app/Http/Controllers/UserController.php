<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{   
    /* Mostrar todos los usuarios */
    public function index()
    {
        try {
            $users = User::all();
            return response()->json([
                'status' => 'success',
                'message' => 'Users retrieved successfully',
                'data' => $users,
            ], 200);
        } catch (\Exception $e) {
            $errorMessage = 'An error occurred while fetching users.';
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /* Crear un usuario */
    public function store(Request $request)
    {
        try {
            $userData = $request->validated();
            $user = User::create($userData);
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'data' => $user,
            ], 201);
        } catch (\Exception $e) {
            $errorMessage = 'An error occurred while creating the user.';
            return response()->json(['error' => $errorMessage], 500);
        }
    }

    /* Muestra un usuario en especifico por su ID */
    public function show(string $user_id)
    {
        try {
            $user = User::findOrFail($user_id);
            return response()->json([
                'status' => 'success',
                'message' => 'User retrieved successfully',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            $errorMessage = 'User not found.';
            return response()->json(['error' => $errorMessage], 404);
        }
    }

    /* Actualiza los datos del usuario por su ID */
    /* 
        1. Obtener la imagen
        2. Obtener los datos binarios de la image, size, name, etc. 
        3. Definir la ruta de almacenamiento
        4. Crea una copia en el disk Storage
        5. Crear el servicio para las imagenes - validar la imagen, almacenarla
        6. Consumir el servicio desde update -> id (PHP STORM)     
    */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $user->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the user.',
                'data' => null
            ], 500);
        }
    }
    /* Elimina un usuario por su ID */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'User eliminated successfully.'
            ], 200);
        } catch (\Exception $e) {
            $errorMessage = 'An error occurred while deleting the user.';
            return response()->json(['error' => $errorMessage], 500);
        }
    }
}
