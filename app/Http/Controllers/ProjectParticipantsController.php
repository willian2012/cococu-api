<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectParticipants;
use Illuminate\Support\Facades\Log;

class ProjectParticipantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $participants = ProjectParticipants::all();

            return response()->json([
                'status' => 'success',
                'message' => 'Project participants retrieved successfully.',
                'data' => $participants,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching project participants: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching project participants.',
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
            $participant = ProjectParticipants::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Project participant created successfully.',
                'data' => $participant
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating project participant: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the project participant.',
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
            $participant = ProjectParticipants::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Project participant retrieved successfully.',
                'data' => $participant
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching project participant: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching the project participant.',
                'data' => null
            ], 500);
        }
    }
    /* 
        display for the specified user
    */
    public function getProjectsForUser($user_id) 
    {
        try {
            // Obtén las actividades en las que el usuario está inscrito
            $projects = ProjectParticipants::where('user_id', $user_id)
                ->with('project') // Carga la relación "activity" para obtener los detalles de la actividad
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Projects for the user retrieved successfully',
                'data' => $projects
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching user projects: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching the user projects.',
                'data' => []
            ], 500);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $participant = ProjectParticipants::findOrFail($id);
            $participant->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Project participant updated successfully.',
                'data' => $participant
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating project participant: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the project participant.',
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
            $participant = ProjectParticipants::findOrFail($id);
            $participant->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Project participant deleted successfully.',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting project participant: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the project participant.',
                'data' => null
            ], 500);
        }
    }
}
