<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Images;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $images = Images::all();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Images retrieved successfully.',
                'data' => $images
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching images: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching images.',
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
            $image = Images::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Image created successfully.',
                'data' => $image
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating image: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the image.',
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
            $image = Images::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Images retrieved successfully.',
                'data' => $image
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching image: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching the images.',
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
            $image = Images::findOrFail($id);
            $image->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Image updated successfully.',
                'data' => $image
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating image: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the image.',
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
            $image = Images::findOrFail($id);
            $image->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Image deleted successfully.',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting image: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the image.',
                'data' => null
            ], 500);
        }
    }
}
