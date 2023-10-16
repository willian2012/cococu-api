<?php

namespace App\Http\Controllers;

use App\Models\ActivityParticipants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ActivityParticipantsController extends Controller
{
    //
    public function index()
    {
        try {
            $participants = ActivityParticipants::all();

            return response()->json([
                'status' => 'success',
                'message' => 'Activity participants retrieved successfully.',
                'data' => $participants,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching activity participants: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching activity participants.',
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
            $participant = ActivityParticipants::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Acivity participant created successfully.',
                'data' => $participant
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating activity participant: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the activity participant.',
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
            $participant = ActivityParticipants::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Activity participant retrieved successfully.',
                'data' => $participant
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching activity participant: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching the activity participant.',
                'data' => null
            ], 500);
        }
    }
    /* 
        Display the specified for user
    */
    public function getActivitiesForUser($user_id)
    {
        try {
            // Obtén las actividades en las que el usuario está inscrito
            $activities = ActivityParticipants::where('user_id', $user_id)
                ->with('activity') // Carga la relación "activity" para obtener los detalles de la actividad
                ->get();
            if ($activities->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'The user with activities is not registered',
                    'data' => null
                ], 404);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Activities for the user retrieved successfully',
                    'data' => $activities
                ], 200);
            }
            
        } catch (\Exception $e) {
            Log::error('Error fetching user activities: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching the user activities.',
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
            $participant = ActivityParticipants::findOrFail($id);
            $participant->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Activity participant updated successfully.',
                'data' => $participant
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating activity participant: ' . $e->getMessage());
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
            $participant = ActivityParticipants::findOrFail($id);
            $participant->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Activity participant deleted successfully.',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting activity participant: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the activity participant.',
                'data' => null
            ], 500);
        }
    }
}
