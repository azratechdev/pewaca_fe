<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;

class WarungkuController extends Controller
{
    public function index()
    {
        $stores = Store::where('is_active', true)
            ->withCount('products')
            ->orderBy('rating', 'desc')
            ->get();

        return view('warungku.index', compact('stores'));
    }

    public function showStore($id)
    {
        $store = Store::with(['products' => function($query) {
            $query->where('is_available', true);
        }])->findOrFail($id);

        return view('warungku.store', compact('store'));
    }

    public function showProduct($id)
    {
        $product = Product::with('store')->findOrFail($id);

        return view('warungku.product', compact('product'));
    }
}
