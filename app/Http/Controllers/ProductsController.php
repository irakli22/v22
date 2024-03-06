<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Phone;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        // $query = Product::query();

        $query = Product::with('images');


        // Handle the 'order' parameter for sorting
        $order = $request->query('order');
        if ($order && in_array($order, ['asc', 'desc'])) {
            $query->orderBy('price', $order);
        }

        // Handle the 'priceFrom' and 'priceTo' parameters for price filtering
        $priceFrom = $request->query('priceFrom');
        $priceTo = $request->query('priceTo');
        if (isset($priceFrom)) {
            $query->where('price', '>=', $priceFrom);
        }
        if (isset($priceTo)) {
            $query->where('price', '<=', $priceTo);
        }

        $capacitiesString = $request->query('capacities');
        $ram = $request->query('ram');

        // Handle the 'capacities' parameter for storage capacity filtering
        if (!empty($capacitiesString)) {
            $capacities = explode(',', $capacitiesString);
            $query->whereHas('phone', function ($query) use ($capacities) {
                $query->whereIn('storage_capacity', $capacities);
            });
        }

        if (!empty($ram)) {
            $capacities = explode(',', $ram);
            $query->whereHas('phone', function ($query) use ($capacities) {
                $query->whereIn('ram', $capacities);
            });
        }

        // Retrieve distinct storage_capacity values from the phone table for filters
        $storageCapacities = Phone::select('storage_capacity')
            ->whereNotNull('storage_capacity')
            ->distinct()
            ->orderBy('storage_capacity', 'asc')
            ->pluck('storage_capacity');

        $ram = Phone::select('ram')
            ->whereNotNull('ram')
            ->distinct()
            ->orderBy('ram', 'asc')
            ->pluck('ram');

        // Pagination applied to the final query
        $products = $query->paginate(10); // Adjust the pagination size as needed

        // Get the minimum and maximum product prices for filters
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');


        return Inertia::render('Products/Index', [
            'products' => $products,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'storageCapacities' => $storageCapacities,
            'ram' => $ram,
        ]);
    }
}
