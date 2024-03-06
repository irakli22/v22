<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
use App\Models\Phone;
use Illuminate\Support\Facades\Log;



class ProductUploadController extends Controller
{

    public function index()
    {
        $categories = Category::all(['id', 'name']);

        return Inertia::render('ProductUpload/Index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show($productId)
    {
        $categories = Category::all(['id', 'name']);
        $product = Product::with('phone')->findOrFail($productId);

        $productArray = $this->convertKeysToCamelCase($product->toArray());

        if ($product->phone) {

            $phoneDetails = $this->convertKeysToCamelCase($product->phone->toArray());

            foreach ($phoneDetails as $key => $value) {
                if ($key === 'id') {
                    continue; // Skip this iteration
                }
                $productArray[$key] = $value;
            }
        }

        unset($productArray['phone']);

        return Inertia::render('ProductUpload/Index', [
            'categories' => $categories,
            'product' => $productArray,
        ]);
    }

    protected function convertKeysToCamelCase(array $array)
    {
        $camelCaseArray = [];
        foreach ($array as $key => $value) {
            // Convert each key to camelCase
            $camelKey = \Illuminate\Support\Str::camel($key);
            $camelCaseArray[$camelKey] = $value;
        }
        return $camelCaseArray;
    }

    protected function convertKeysToSnakeCase(array $array)
    {
        $snakeCaseArray = [];
        foreach ($array as $key => $value) {
            // Convert each key to snake_case
            $snakeKey = \Illuminate\Support\Str::snake($key);
            $snakeCaseArray[$snakeKey] = $value;
        }
        return $snakeCaseArray;
    }

    public function store(Request $request)
    {
        Log::info($request->all());
        $validatedProduct = $request->validate([
            'name' => 'required|string|max:200',
            'price' => 'required|numeric',
            'categoryId' => 'required|exists:categories,id',
        ]);

        $validatedPhone = $request->validate([
            'storageCapacity' => 'nullable|integer',
            'ram' => 'nullable|integer',
            'color' => 'nullable|string|max:255',
            'screenSize' => 'nullable|numeric',
            'displayType' => 'nullable|string|max:255',
            'refreshRate' => 'nullable|integer',
            'bodyMaterial' => 'nullable|string|max:255',
            'connectivity' => 'nullable|string|max:255',
            'frontCameraResolution' => 'nullable|string|max:255',
            'cameraResolution' => 'nullable|string|max:255',
            'operatingSystem' => 'nullable|string|max:255',
            'simType' => 'nullable|string|max:255',
            'processor' => 'nullable|string|max:255',
            'waterResistant' => 'nullable|boolean',
            'wirelessCharging' => 'nullable|boolean',
            'fastCharging' => 'nullable|boolean',
            'fingerprintSensor' => 'nullable|boolean',
            'faceRecognition' => 'nullable|boolean',
        ]);


        $validatedProduct = $this->convertKeysToSnakeCase($validatedProduct);

        $product = Product::create($validatedProduct);

        $validatedPhone = $this->convertKeysToSnakeCase($validatedPhone);

        $validatedPhone['product_id'] = $product->id;
        $validatedPhone['category_id'] = $validatedProduct['category_id'];
        // Create Phone
        $phone = Phone::create($validatedPhone);

        return Inertia::render('ProductUpload/Index', ['id' => $validatedPhone]);
    }
}
