<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $activities = Activities::all();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Activities retrieved successfully.',
                'data' => $activities
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching activities: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching activities.',
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
            $activity = Activities::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Activity created successfully.',
                'data' => $activity
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating activity: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the activity.',
                'data' => null
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $activity = Activities::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Activity retrieved successfully.',
                'data' => $activity
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching activity: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching the activity.',
                'data' => null
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $activity = Activities::findOrFail($id);
            $activity->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'activity updated successfully.',
                'data' => $activity
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating activity: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the activity.',
                'data' => null
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $activity = Activities::findOrFail($id);
            $activity->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Activity deleted successfully.',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting activity: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the activity.',
                'data' => null
            ], 500);
        }
    }
}
