<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private function getUserCart()
    {
        $userEmail = Session::get('cred.email');
        
        if (!$userEmail) {
            return null;
        }

        return Cart::firstOrCreate(['user_email' => $userEmail]);
    }

    public function index()
    {
        $cart = $this->getUserCart();
        
        if (!$cart) {
            return redirect()->route('showLoginForm');
        }

        $cart->load(['items.product.store']);
        
        return view('warungku.cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $cart = $this->getUserCart();
        
        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Please login first'], 401);
        }

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < ($request->quantity ?? 1)) {
            return response()->json([
                'success' => false, 
                'message' => 'Stok tidak mencukupi'
            ], 400);
        }

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + ($request->quantity ?? 1);
            
            if ($product->stock < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi'
                ], 400);
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity ?? 1,
                'price' => $product->price,
            ]);
        }

        $cart->load('items');

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'cart_count' => $cart->total_items
        ]);
    }

    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getUserCart();
        
        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Please login first'], 401);
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('id', $itemId)
                            ->firstOrFail();

        if ($cartItem->product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi'
            ], 400);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        $cart->load('items');

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diupdate',
            'subtotal' => $cartItem->subtotal,
            'total' => $cart->total,
            'cart_count' => $cart->total_items
        ]);
    }

    public function remove($itemId)
    {
        $cart = $this->getUserCart();
        
        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Please login first'], 401);
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('id', $itemId)
                            ->firstOrFail();

        $cartItem->delete();

        $cart->load('items');

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus dari keranjang',
            'total' => $cart->total,
            'cart_count' => $cart->total_items
        ]);
    }

    public function clear()
    {
        $cart = $this->getUserCart();
        
        if (!$cart) {
            return redirect()->route('showLoginForm');
        }

        $cart->items()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan'
        ]);
    }

    public function getCount()
    {
        $cart = $this->getUserCart();
        
        if (!$cart) {
            return response()->json(['count' => 0]);
        }

        return response()->json(['count' => $cart->total_items]);
    }
}
