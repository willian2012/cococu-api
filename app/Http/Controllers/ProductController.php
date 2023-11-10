<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Traits\ImageServiceTrait;

class ProductController extends Controller
{
    use ImageServiceTrait;
    //
    public function index()
    {
        try {
            $products = Product::all();
            
            // Formatear los precios en pesos colombianos
            $products = $products->map(function ($product) {
                $product->image = url($product->image); // Asumiendo que la columna que almacena la URL de la imagen se llama 'image'
                $product->price = number_format($product->price, 0, ',', '.') . ' COP'; // Formato con separador de miles y símbolo de moneda
                return $product;
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Products retrieved successfully.',
                'data' => $products,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error fetching products: ' . $e->getMessage());
            $message = 'An error occurred while fetching products.';
            return response()->json([
                'status' => 'error',
                'message' => $message,
                'data' => null
            ], 500);
        }
    }


    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request) 
    {
        try{
            $request->validate([
                'image' => 'required|image|max:2048', // El valor 2048 representa 2 MB (2 * 1024)
            ]);
            $product = Product::create($request->all());

            if($product) {
                $responseDataStorage = ($this->UploadImage($request, 'image', "images/products"));
                $product->update(['image'=>$responseDataStorage['data']]);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Product created successfully.',
                'data' => $product
            ], 201);
        }catch(Exception $e){
            Log::error('Error creating product: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while creating the product.',
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
            $product = Product::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Product retrieved successfully.',
                'data' => $product
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching product: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching the product.',
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
            $request->validate([
                'image' => 'image|max:2048',
            ]);
            $product = Product::findOrFail($id);
            $save = $product->update($request->all());
            if ($save && $request->hasFile('image')) {
                $responseDataStorage = $this->uploadImage($request, 'image', "images/products");
                $product->update(['image' => $responseDataStorage['data']]);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Role updated successfully.',
                'data' => $product
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the product.',
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
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted successfully.',
                'data' => null
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting the product.',
                'data' => null
            ], 500);
        }
    }
}
