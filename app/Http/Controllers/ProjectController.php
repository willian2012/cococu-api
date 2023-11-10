<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\ImageServiceTrait;

class ProjectController extends Controller
{
    use ImageServiceTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $projects = Project::all();
            // Mapea las imágenes para construir la URL completa
            $project = $projects->map(function ($project) {
                $project->image = url($project->image); // Asumiendo que la columna que almacena la URL de la imagen se llama 'url'
                $project->cost = number_format($project->cost, 0, ',', '.') . ' COP';
                return $project;
            });
            return response()->json([
                'status' => 'success',
                'message' => 'Projects retrieved successfully.',
                'data' => $projects
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching projects: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching projects.',
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
            $request->validate([
                'image' => 'required|image|max:2048', // El valor 2048 representa 2 MB (2 * 1024)
            ]);
            $project = Project::create($request->all());


            if($project) {
                $responseDataStorage = ($this->UploadImage($request, 'image', "images/projects"));
                $project->update(['image'=>$responseDataStorage['data']]);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Project created successfully.',
                'data' => $project
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating project: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the project.',
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
            $project = Project::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Projects retrieved successfully.',
                'data' => $project
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching project: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching the projects.',
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
            $request->validate([
                'image' => 'image|max:2048',
            ]);
            $project = Project::findOrFail($id);
            $save = $project->update($request->all());
            if ($save && $request->hasFile('image')) {
                $responseDataStorage = $this->uploadImage($request, 'image', "images/projects");
                $project->update(['image' => $responseDataStorage['data']]);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Project updated successfully.',
                'data' => $project
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating project: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the project.',
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
            $project = Project::findOrFail($id);
            $project->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Project deleted successfully.',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting project: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the project.',
                'data' => null
            ], 500);
        }
    }
}
