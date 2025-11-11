<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\SellerRequest;

class SellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        if (!$user->isSeller()) {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses seller.');
            return redirect()->route('pengurus');
        }

        $stores = $user->stores;
        
        $totalStores = $stores->count();
        $totalProducts = Product::whereIn('store_id', $stores->pluck('id'))->count();
        $totalOrders = Order::whereIn('store_id', $stores->pluck('id'))->count();
        $totalRevenue = Order::whereIn('store_id', $stores->pluck('id'))
                            ->where('payment_status', 'paid')
                            ->sum('total_amount');

        $recentOrders = Order::whereIn('store_id', $stores->pluck('id'))
                            ->with(['store', 'user', 'items'])
                            ->latest()
                            ->take(10)
                            ->get();

        return view('pengurus.seller.dashboard', compact(
            'stores',
            'totalStores',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'recentOrders'
        ));
    }

    public function myStores()
    {
        $user = Auth::user();
        
        if (!$user->isSeller()) {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses seller.');
            return redirect()->route('pengurus');
        }

        $stores = $user->stores()->withCount(['products', 'orders'])->get();

        return view('pengurus.seller.my-stores', compact('stores'));
    }

    public function browseStores()
    {
        $user = Auth::user();
        
        if (!$user->isSeller()) {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses seller.');
            return redirect()->route('pengurus');
        }

        $myStoreIds = $user->stores->pluck('id');
        $availableStores = Store::whereNotIn('id', $myStoreIds)
                                ->where('is_active', true)
                                ->withCount('products')
                                ->get();

        return view('pengurus.seller.browse-stores', compact('availableStores'));
    }

    public function claimStore(Request $request, Store $store)
    {
        $user = Auth::user();
        
        if (!$user->isSeller()) {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses seller.');
            return redirect()->route('pengurus');
        }

        if ($user->stores->contains($store->id)) {
            Alert::warning('Sudah Terdaftar', 'Anda sudah menjadi seller di toko ini.');
            return back();
        }

        $user->stores()->attach($store->id, ['role' => 'seller']);

        Alert::success('Berhasil', 'Anda sekarang menjadi seller di ' . $store->name);
        return redirect()->route('pengurus.seller.products', $store->id);
    }

    public function leaveStore(Store $store)
    {
        $user = Auth::user();
        
        if (!$user->stores->contains($store->id)) {
            Alert::error('Error', 'Anda bukan seller di toko ini.');
            return back();
        }

        $user->stores()->detach($store->id);

        Alert::success('Berhasil', 'Anda telah keluar dari toko ' . $store->name);
        return redirect()->route('pengurus.seller.my-stores');
    }

    public function products(Store $store)
    {
        $user = Auth::user();
        
        if (!$user->stores->contains($store->id)) {
            Alert::error('Akses Ditolak', 'Anda bukan seller di toko ini.');
            return redirect()->route('pengurus.seller.dashboard');
        }

        $products = $store->products()->latest()->paginate(12);

        return view('pengurus.seller.products', compact('store', 'products'));
    }

    public function createProduct(Store $store)
    {
        $user = Auth::user();
        
        if (!$user->stores->contains($store->id)) {
            Alert::error('Akses Ditolak', 'Anda bukan seller di toko ini.');
            return redirect()->route('pengurus.seller.dashboard');
        }

        return view('pengurus.seller.product-form', compact('store'));
    }

    public function storeProduct(Request $request, Store $store)
    {
        $user = Auth::user();
        
        if (!$user->stores->contains($store->id)) {
            Alert::error('Akses Ditolak', 'Anda bukan seller di toko ini.');
            return redirect()->route('pengurus.seller.dashboard');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_available' => 'boolean',
            'image' => 'nullable|string',
        ]);

        $validated['store_id'] = $store->id;
        $validated['is_available'] = $request->has('is_available');

        $product = Product::create($validated);

        Alert::success('Berhasil', 'Produk berhasil ditambahkan!');
        return redirect()->route('pengurus.seller.products', $store->id);
    }

    public function editProduct(Store $store, Product $product)
    {
        $user = Auth::user();
        
        if (!$user->stores->contains($store->id) || $product->store_id != $store->id) {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses untuk mengedit produk ini.');
            return redirect()->route('pengurus.seller.dashboard');
        }

        return view('pengurus.seller.product-form', compact('store', 'product'));
    }

    public function updateProduct(Request $request, Store $store, Product $product)
    {
        $user = Auth::user();
        
        if (!$user->stores->contains($store->id) || $product->store_id != $store->id) {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses untuk mengupdate produk ini.');
            return redirect()->route('pengurus.seller.dashboard');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_available' => 'boolean',
            'image' => 'nullable|string',
        ]);

        $validated['is_available'] = $request->has('is_available');

        $product->update($validated);

        Alert::success('Berhasil', 'Produk berhasil diupdate!');
        return redirect()->route('pengurus.seller.products', $store->id);
    }

    public function deleteProduct(Store $store, Product $product)
    {
        $user = Auth::user();
        
        if (!$user->stores->contains($store->id) || $product->store_id != $store->id) {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses untuk menghapus produk ini.');
            return redirect()->route('pengurus.seller.dashboard');
        }

        $product->delete();

        Alert::success('Berhasil', 'Produk berhasil dihapus!');
        return redirect()->route('pengurus.seller.products', $store->id);
    }

    public function updateStock(Request $request, Store $store, Product $product)
    {
        $user = Auth::user();
        
        if (!$user->stores->contains($store->id) || $product->store_id != $store->id) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        $validated = $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Stock berhasil diupdate',
            'stock' => $product->stock
        ]);
    }

    public function orders(Store $store)
    {
        $user = Auth::user();
        
        if (!$user->stores->contains($store->id)) {
            Alert::error('Akses Ditolak', 'Anda bukan seller di toko ini.');
            return redirect()->route('pengurus.seller.dashboard');
        }

        $orders = $store->orders()
                        ->with(['user', 'items.product'])
                        ->latest()
                        ->paginate(20);

        return view('pengurus.seller.orders', compact('store', 'orders'));
    }

    public function orderDetail(Store $store, Order $order)
    {
        $user = Auth::user();
        
        if (!$user->stores->contains($store->id) || $order->store_id != $store->id) {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses untuk melihat order ini.');
            return redirect()->route('pengurus.seller.dashboard');
        }

        $order->load(['user', 'items.product']);

        return view('pengurus.seller.order-detail', compact('store', 'order'));
    }

    public function updateOrderStatus(Request $request, Store $store, Order $order)
    {
        $user = Auth::user();
        
        if (!$user->stores->contains($store->id) || $order->store_id != $store->id) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Status order berhasil diupdate',
            'status' => $order->status
        ]);
    }

    public function reports(Store $store)
    {
        $user = Auth::user();
        
        if (!$user->stores->contains($store->id)) {
            Alert::error('Akses Ditolak', 'Anda bukan seller di toko ini.');
            return redirect()->route('pengurus.seller.dashboard');
        }

        $totalRevenue = $store->orders()
                            ->where('payment_status', 'paid')
                            ->sum('total_amount');

        $totalOrders = $store->orders()->count();
        $completedOrders = $store->orders()->where('status', 'completed')->count();
        $pendingOrders = $store->orders()->where('status', 'pending')->count();

        $topProducts = DB::table('order_items')
                        ->join('orders', 'order_items.order_id', '=', 'orders.id')
                        ->join('products', 'order_items.product_id', '=', 'products.id')
                        ->where('orders.store_id', $store->id)
                        ->where('orders.payment_status', 'paid')
                        ->select(
                            'products.name',
                            DB::raw('SUM(order_items.quantity) as total_quantity'),
                            DB::raw('SUM(order_items.subtotal) as total_revenue')
                        )
                        ->groupBy('products.id', 'products.name')
                        ->orderByDesc('total_revenue')
                        ->limit(10)
                        ->get();

        $revenueByMonth = $store->orders()
                            ->where('payment_status', 'paid')
                            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_amount) as revenue')
                            ->groupBy('month')
                            ->orderBy('month', 'desc')
                            ->limit(12)
                            ->get();

        return view('pengurus.seller.reports', compact(
            'store',
            'totalRevenue',
            'totalOrders',
            'completedOrders',
            'pendingOrders',
            'topProducts',
            'revenueByMonth'
        ));
    }

    public function showRegisterForm()
    {
        if (!Session::has('cred')) {
            Alert::error('Error', 'Silakan login terlebih dahulu.');
            return redirect()->route('login');
        }
        
        $cred = Session::get('cred');
        
        if (($cred['is_seller'] ?? 0) == 1) {
            Alert::info('Info', 'Anda sudah terdaftar sebagai seller.');
            return redirect()->route('pengurus.seller.dashboard');
        }
        
        // Check if user has any approved or pending requests
        $user = DB::table('users')->where('email', $cred['email'])->first();
        if ($user) {
            $existingRequest = SellerRequest::where('user_id', $user->id)
                ->whereIn('status', [SellerRequest::STATUS_PENDING, SellerRequest::STATUS_APPROVED])
                ->first();
            
            if ($existingRequest) {
                return redirect()->route('pengurus.seller.request.status');
            }
        }

        return view('pengurus.seller.register');
    }

    public function processRegistration(Request $request)
    {
        if (!Session::has('cred')) {
            Alert::error('Error', 'Silakan login terlebih dahulu.');
            return redirect()->route('login');
        }
        
        $cred = Session::get('cred');
        
        if (($cred['is_seller'] ?? 0) == 1) {
            Alert::error('Error', 'Anda sudah terdaftar sebagai seller.');
            return redirect()->route('pengurus.seller.dashboard');
        }

        $request->validate([
            'store_name' => 'required|string|min:3|max:255',
            'store_address' => 'required|string|min:10|max:500',
            'product_type' => 'required|string',
            'terms_accepted' => 'required|accepted'
        ], [
            'store_name.required' => 'Nama toko harus diisi.',
            'store_name.min' => 'Nama toko minimal 3 karakter.',
            'store_name.max' => 'Nama toko maksimal 255 karakter.',
            'store_address.required' => 'Alamat toko harus diisi.',
            'store_address.min' => 'Alamat toko minimal 10 karakter.',
            'store_address.max' => 'Alamat toko maksimal 500 karakter.',
            'product_type.required' => 'Jenis produk harus dipilih.',
            'terms_accepted.required' => 'Anda harus menyetujui syarat dan ketentuan.',
            'terms_accepted.accepted' => 'Anda harus menyetujui syarat dan ketentuan.'
        ]);

        try {
            // Get user ID from database
            $user = DB::table('users')
                ->where('email', $cred['email'])
                ->first();
            
            if (!$user) {
                Alert::error('Error', 'User tidak ditemukan.');
                return redirect()->back()->withInput();
            }
            
            // Check if user already has pending or approved request
            $existingRequest = SellerRequest::where('user_id', $user->id)
                ->whereIn('status', [SellerRequest::STATUS_PENDING, SellerRequest::STATUS_APPROVED])
                ->first();
            
            if ($existingRequest) {
                if ($existingRequest->status == SellerRequest::STATUS_APPROVED) {
                    Alert::info('Info', 'Anda sudah terdaftar sebagai seller.');
                    return redirect()->route('pengurus.seller.dashboard');
                } else {
                    Alert::info('Info', 'Anda sudah memiliki pendaftaran seller yang sedang menunggu persetujuan pengurus.');
                    return redirect()->route('pengurus.seller.request.status');
                }
            }
            
            // Create seller request
            SellerRequest::create([
                'user_id' => $user->id,
                'store_name' => $request->store_name,
                'store_address' => $request->store_address,
                'product_type' => $request->product_type,
                'status' => SellerRequest::STATUS_PENDING
            ]);
            
            Alert::success('Berhasil!', 'Pendaftaran seller Anda telah dikirim. Silakan menunggu persetujuan dari pengurus.');
            return redirect()->route('pengurus.seller.request.status');
            
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function requestStatus()
    {
        if (!Session::has('cred')) {
            Alert::error('Error', 'Silakan login terlebih dahulu.');
            return redirect()->route('login');
        }
        
        $cred = Session::get('cred');
        
        // Get user from database
        $user = DB::table('users')
            ->where('email', $cred['email'])
            ->first();
        
        if (!$user) {
            Alert::error('Error', 'User tidak ditemukan.');
            return redirect()->route('login');
        }
        
        // Get latest seller request
        $sellerRequest = SellerRequest::where('user_id', $user->id)
            ->latest()
            ->first();
        
        if (!$sellerRequest) {
            Alert::info('Info', 'Anda belum memiliki pendaftaran seller.');
            return redirect()->route('warungku.index');
        }
        
        return view('pengurus.seller.status', compact('sellerRequest'));
    }
}
