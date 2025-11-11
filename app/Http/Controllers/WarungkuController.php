<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use App\Models\SellerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class WarungkuController extends Controller
{
    public function index()
    {
        $stores = Store::where('is_active', true)
            ->withCount('products')
            ->orderBy('rating', 'desc')
            ->get();

        $hasPendingRequest = false;
        
        if (Session::has('cred')) {
            $cred = Session::get('cred');
            $user = DB::table('users')->where('email', $cred['email'])->first();
            
            if ($user) {
                $hasPendingRequest = SellerRequest::where('user_id', $user->id)
                    ->where('status', SellerRequest::STATUS_PENDING)
                    ->exists();
            }
        }

        return view('warungku.index', compact('stores', 'hasPendingRequest'));
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
