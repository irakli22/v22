<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    public function index(Product $images)
    {
        $images->load('image');

        return Inertia::render('ProductPage', [
            'image' => $images,
        ]);
    }

    function showProductImages(Product $product)
    {
        $images = $product->images;
        

        return response()->json($images);
    }

    public function store(Request $request, Product $product)
    {
        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                // Generate a unique file name to prevent overwriting
                $uniqueFileName = Str::random(10) . '_' . time() . '.' . $image->getClientOriginalExtension();

                // Define the custom path including the category_id and product name
                // Ensure you have a relationship set up to access the category of the product
                $category_id = $product->category_id; // Assuming the product has a 'category_id' field
                $productName = Str::slug($product->name); // Convert product name to a URL-friendly string

                // Adjust the storage path as per your requirement
                $customPath = "public/products/{$category_id}/{$productName}";

                // Store the image in the defined path
                $path = $image->storeAs($customPath, $uniqueFileName);

                // Convert storage path to URL accessible path if needed
                $urlPath = Storage::url($path);

                // Save the path or any other related information in the database
                $product->images()->create(['path' => $urlPath]);
            }

            return response()->json(['message' => 'Images uploaded successfully'], 200);
        }

        return response()->json(['message' => 'No images uploaded'], 400);
    }

}
