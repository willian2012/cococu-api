<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\ImageServiceTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ImageServiceTrait;

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
            $userData = $request->all();
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

    /* _Cambia el avatar del usuario por su ID  */
    public function uploadAvatar(Request $request, $id) 
    {
        try{
            $user = User::findOrFail($id);
            if($user) {
                $responseDataStorage = ($this->UploadImage($request, 'avatar', "images/$user->first_name"));
                $user->update(['avatar'=>$responseDataStorage['data']]);

                // Obtener la URL completa del avatar
                $avatarUrl = $user->getAttribute('avatar');

                // Comprobar si la URL está vacía
                if (!empty($avatarUrl)) {
                    // Parsear la URL con la ruta completa
                    $avatarUrl = url($avatarUrl);
                }

                // Actualizar el campo "avatar" con la URL completa
                $user->setAttribute('avatar', $avatarUrl);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully',
                'data' => $user
            ], 200);

        }catch(\Exception $e){
            Log::error('Error uploading avatar: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the user.',
                'data' => null
            ], 500);
        }
    }

    /* Actualiza los datos del usuario por su ID */
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

    public function changePassword(Request $request, $id)
    {
        try {
            // Validación de la solicitud
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6',
            ]);
            // Obtener el usuario por su ID
            $user = User::findOrFail($id);
            
            // Verificar si la contraseña actual es correcta
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Contraseña actual incorrecta',
                ], 400);
            }
            
            // Actualizar la contraseña
            $user->update([
                'password' => $request->new_password,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'password updated successfully',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error changing password: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while changing the password.',
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
