<?php 

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Inertia\Inertia;
use App\Models\Product;

class ProductListController extends Controller 
{
    public function show()
    {
        $query = Product::query();

        $products = $query->paginate(20);

        return Inertia::render('ProductListPage', [
            'products' => $products,
        ]);
        
    }
}