<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\ImageServiceTrait;

class ActivityController extends Controller
{
    use ImageServiceTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $activities = Activities::all();

            $activities = $activities->map(function ($activity) {
                $activity->image = url($activity->image); // Asumiendo que la columna que almacena la URL de la imagen se llama 'image'
                $activity->cost = number_format($activity->cost, 0, ',', '.') . ' COP';
                return $activity;
            });

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
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|max:2048',
                // Puedes agregar más validaciones aquí según tus requisitos.
            ]);

            $activity = Activities::create($request->all());

            if ($activity) {
                $responseDataStorage = $this->uploadImage($request, 'image', "images/activities");
                $activity->update(['image' => $responseDataStorage['data']]);
            }

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
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'image' => 'image|max:2048',
            ]);

            $activity = Activities::findOrFail($id);
            $save = $activity->update($request->all());
            
            if ($save && $request->hasFile('image')) {
                $responseDataStorage = $this->uploadImage($request, 'image', "images/activities");
                $activity->update(['image' => $responseDataStorage['data']]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Activity updated successfully.',
                'data' => $activity
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating activity: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the activity.',
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
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting activity: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the activity.',
            ], 500);
        }
    }
}
