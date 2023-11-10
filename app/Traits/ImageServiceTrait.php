<?php 
    
    namespace App\Traits;
    use Exception;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
    use Intervention\Image\Facades\Image;

    trait ImageServiceTrait {

        /* Carga la imagen através de una ruta especificada */
        public function UploadImage(Request $request, $fileName, $route) {
            $path = storage_path("app/public/$route/");
            if($request->hasFile($fileName)) {
                try {
                    $file = $request->file($fileName);
                    $randomName = strtolower(Str::random(10));
                    $image = Image::make($file);
                    $image->encode('webp', 90);
                    Storage::disk('public')->makeDirectory($route);
                    $image->save($path.$randomName.'.webp');
                    return [
                        'message' => 'image upload successfully',
                        'data' => "$route/$randomName.webp"
                    ];

                }catch(Exception $error) {
                    Log::error("Failed the image upload");
                    Log::error($error->getMessage());
                    return response()->json([
                        'message' => 'Failed the image upload',
                        'data' => $error->getMessage(),
                    ], 500);
                }
            }
        }
    }
?>