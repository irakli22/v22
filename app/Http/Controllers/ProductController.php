<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load('phone');

        return Inertia::render('ProductPage', [
            'product' => $product,
        ]);
    }
}
