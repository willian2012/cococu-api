<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Log;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $roles = Role::all();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Roles retrieved successfully.',
                'data' => $roles
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching roles: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching roles.',
                'data' => null
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $role = Role::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Role created successfully.',
                'data' => $role
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating role: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the role.',
                'data' => null
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $role = Role::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Role retrieved successfully.',
                'data' => $role
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching role: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching the role.',
                'data' => null
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Role updated successfully.',
                'data' => $role
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating role: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the role.',
                'data' => null
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Role deleted successfully.',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting role: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the role.',
                'data' => null
            ], 500);
        }
    }
}
