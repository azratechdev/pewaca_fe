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
    // REMOVED middleware('auth') - this app uses Django API auth (Session::get('cred'))
    // Each method has its own session check instead

    public function dashboard()
    {
        // Check session authentication
        if (!Session::has('cred')) {
            Alert::error('Akses Ditolak', 'Sesi Anda telah berakhir. Silakan login kembali.');
            return redirect()->route('login');
        }

        $cred = Session::get('cred');
        $userId = $cred['user_id'] ?? null;
        $isSeller = $cred['is_seller'] ?? 0;

        if (!$userId) {
            Alert::error('Akses Ditolak', 'Data user tidak valid.');
            return redirect()->route('pengurus');
        }

        if (!$isSeller) {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses seller.');
            return redirect()->route('pengurus');
        }

        // Get stores owned by this user
        $stores = Store::where('user_id', $userId)->get();
        $storeIds = $stores->pluck('id');
        
        $totalStores = $stores->count();
        $totalProducts = Product::whereIn('store_id', $storeIds)->count();
        $totalOrders = Order::whereIn('store_id', $storeIds)->count();
        $totalRevenue = Order::whereIn('store_id', $storeIds)
                            ->where('payment_status', 'paid')
                            ->sum('total_amount');

        $recentOrders = Order::whereIn('store_id', $storeIds)
                            ->with(['store'])
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
        // Check session authentication
        if (!Session::has('cred')) {
            Alert::error('Akses Ditolak', 'Sesi Anda telah berakhir. Silakan login kembali.');
            return redirect()->route('login');
        }

        $cred = Session::get('cred');
        $userId = $cred['user_id'] ?? null;
        $isSeller = $cred['is_seller'] ?? 0;

        if (!$userId) {
            Alert::error('Akses Ditolak', 'Data user tidak valid.');
            return redirect()->route('pengurus');
        }

        if (!$isSeller) {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses seller.');
            return redirect()->route('pengurus');
        }

        // Get stores owned by this user
        $stores = Store::where('user_id', $userId)
                    ->withCount(['products', 'orders'])
                    ->get();

        return view('pengurus.seller.my-stores', compact('stores'));
    }

    public function browseStores()
    {
        // NOTE: This feature is for multi-seller pivot table system (deprecated)
        // New ownership model uses direct Store::user_id assignment
        // Redirecting to dashboard for now
        Alert::info('Info', 'Fitur browse stores saat ini tidak tersedia.');
        return redirect()->route('pengurus.seller.dashboard');
    }

    public function claimStore(Request $request, Store $store)
    {
        // NOTE: This feature is for multi-seller pivot table system (deprecated)
        // New ownership model uses seller_requests approval workflow
        Alert::info('Info', 'Silakan gunakan form pendaftaran seller untuk mendaftar toko baru.');
        return redirect()->route('pengurus.seller.register');
    }

    public function leaveStore(Store $store)
    {
        // NOTE: This feature is for multi-seller pivot table system (deprecated)
        // New ownership model: Owners cannot leave their own stores
        Alert::warning('Akses Ditolak', 'Anda tidak dapat meninggalkan toko yang Anda miliki.');
        return redirect()->route('pengurus.seller.dashboard');
    }

    public function products(Store $store)
    {
        // Check session authentication
        if (!Session::has('cred')) {
            Alert::error('Akses Ditolak', 'Sesi Anda telah berakhir. Silakan login kembali.');
            return redirect()->route('login');
        }

        $cred = Session::get('cred');
        $userId = $cred['user_id'] ?? null;

        if (!$userId) {
            Alert::error('Akses Ditolak', 'Data user tidak valid.');
            return redirect()->route('pengurus');
        }

        // Check store ownership
        if ($store->user_id != $userId) {
            Alert::error('Akses Ditolak', 'Anda bukan pemilik toko ini.');
            return redirect()->route('pengurus.seller.dashboard');
        }

        $products = $store->products()->latest()->paginate(12);

        return view('pengurus.seller.products', compact('store', 'products'));
    }

    public function createProduct(Store $store)
    {
        // Check session authentication
        if (!Session::has('cred')) {
            Alert::error('Akses Ditolak', 'Sesi Anda telah berakhir. Silakan login kembali.');
            return redirect()->route('login');
        }

        $cred = Session::get('cred');
        $userId = $cred['user_id'] ?? null;

        if (!$userId) {
            Alert::error('Akses Ditolak', 'Data user tidak valid.');
            return redirect()->route('pengurus');
        }

        // Check store ownership
        if ($store->user_id != $userId) {
            Alert::error('Akses Ditolak', 'Anda bukan pemilik toko ini.');
            return redirect()->route('pengurus.seller.dashboard');
        }

        return view('pengurus.seller.product-form', compact('store'));
    }

    public function storeProduct(Request $request, Store $store)
    {
        \Log::info('=== STORE PRODUCT CALLED ===', [
            'store_id' => $store->id,
            'request_data' => $request->all(),
            'session_cred' => Session::get('cred')
        ]);

        // Check session authentication
        if (!Session::has('cred')) {
            \Log::warning('No session cred found');
            Alert::error('Akses Ditolak', 'Sesi Anda telah berakhir. Silakan login kembali.');
            return redirect()->route('login');
        }

        $cred = Session::get('cred');
        $userId = $cred['user_id'] ?? null;

        if (!$userId) {
            \Log::warning('No user_id in session');
            Alert::error('Akses Ditolak', 'Data user tidak valid.');
            return redirect()->route('pengurus');
        }

        // Check store ownership
        if ($store->user_id != $userId) {
            \Log::warning('Store ownership check failed', [
                'store_user_id' => $store->user_id,
                'session_user_id' => $userId
            ]);
            Alert::error('Akses Ditolak', 'Anda bukan pemilik toko ini.');
            return redirect()->route('pengurus.seller.dashboard');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string',
        ]);

        $validated['store_id'] = $store->id;
        $validated['is_available'] = $request->has('is_available') ? 1 : 0;

        \Log::info('Creating product', ['validated' => $validated]);

        $product = Product::create($validated);

        \Log::info('Product created successfully', ['product_id' => $product->id]);

        Alert::success('Berhasil', 'Produk berhasil ditambahkan!');
        return redirect()->route('pengurus.seller.products', $store->id);
    }

    public function editProduct(Store $store, Product $product)
    {
        // Check session authentication
        if (!Session::has('cred')) {
            Alert::error('Akses Ditolak', 'Sesi Anda telah berakhir. Silakan login kembali.');
            return redirect()->route('login');
        }

        $cred = Session::get('cred');
        $userId = $cred['user_id'] ?? null;

        if (!$userId) {
            Alert::error('Akses Ditolak', 'Data user tidak valid.');
            return redirect()->route('pengurus');
        }

        // Check store ownership and product belongs to store
        if ($store->user_id != $userId || $product->store_id != $store->id) {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses untuk mengedit produk ini.');
            return redirect()->route('pengurus.seller.dashboard');
        }

        return view('pengurus.seller.product-form', compact('store', 'product'));
    }

    public function updateProduct(Request $request, Store $store, Product $product)
    {
        // Check session authentication
        if (!Session::has('cred')) {
            Alert::error('Akses Ditolak', 'Sesi Anda telah berakhir. Silakan login kembali.');
            return redirect()->route('login');
        }

        $cred = Session::get('cred');
        $userId = $cred['user_id'] ?? null;

        if (!$userId) {
            Alert::error('Akses Ditolak', 'Data user tidak valid.');
            return redirect()->route('pengurus');
        }

        // Check store ownership and product belongs to store
        if ($store->user_id != $userId || $product->store_id != $store->id) {
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
        // Check session authentication
        if (!Session::has('cred')) {
            Alert::error('Akses Ditolak', 'Sesi Anda telah berakhir. Silakan login kembali.');
            return redirect()->route('login');
        }

        $cred = Session::get('cred');
        $userId = $cred['user_id'] ?? null;

        if (!$userId) {
            Alert::error('Akses Ditolak', 'Data user tidak valid.');
            return redirect()->route('pengurus');
        }

        // Check store ownership and product belongs to store
        if ($store->user_id != $userId || $product->store_id != $store->id) {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses untuk menghapus produk ini.');
            return redirect()->route('pengurus.seller.dashboard');
        }

        $product->delete();

        Alert::success('Berhasil', 'Produk berhasil dihapus!');
        return redirect()->route('pengurus.seller.products', $store->id);
    }

    public function updateStock(Request $request, Store $store, Product $product)
    {
        // Check session authentication
        if (!Session::has('cred')) {
            return response()->json(['success' => false, 'message' => 'Sesi berakhir. Silakan login kembali.'], 401);
        }

        $cred = Session::get('cred');
        $userId = $cred['user_id'] ?? null;

        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Data user tidak valid'], 401);
        }

        // Check store ownership and product belongs to store
        if ($store->user_id != $userId || $product->store_id != $store->id) {
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
        // Check session authentication
        if (!Session::has('cred')) {
            Alert::error('Akses Ditolak', 'Sesi Anda telah berakhir. Silakan login kembali.');
            return redirect()->route('login');
        }

        $cred = Session::get('cred');
        $userId = $cred['user_id'] ?? null;

        if (!$userId) {
            Alert::error('Akses Ditolak', 'Data user tidak valid.');
            return redirect()->route('pengurus');
        }

        // Check store ownership
        if ($store->user_id != $userId) {
            Alert::error('Akses Ditolak', 'Anda bukan pemilik toko ini.');
            return redirect()->route('pengurus.seller.dashboard');
        }

        $orders = $store->orders()
                        ->latest()
                        ->paginate(20);

        return view('pengurus.seller.orders', compact('store', 'orders'));
    }

    public function orderDetail(Store $store, Order $order)
    {
        // Check session authentication
        if (!Session::has('cred')) {
            Alert::error('Akses Ditolak', 'Sesi Anda telah berakhir. Silakan login kembali.');
            return redirect()->route('login');
        }

        $cred = Session::get('cred');
        $userId = $cred['user_id'] ?? null;

        if (!$userId) {
            Alert::error('Akses Ditolak', 'Data user tidak valid.');
            return redirect()->route('pengurus');
        }

        // Check store ownership and order belongs to store
        if ($store->user_id != $userId || $order->store_id != $store->id) {
            Alert::error('Akses Ditolak', 'Anda tidak memiliki akses untuk melihat order ini.');
            return redirect()->route('pengurus.seller.dashboard');
        }

        $order->load(['items.product']);

        return view('pengurus.seller.order-detail', compact('store', 'order'));
    }

    public function updateOrderStatus(Request $request, Store $store, Order $order)
    {
        // Check session authentication
        if (!Session::has('cred')) {
            return response()->json(['success' => false, 'message' => 'Sesi berakhir. Silakan login kembali.'], 401);
        }

        $cred = Session::get('cred');
        $userId = $cred['user_id'] ?? null;

        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Data user tidak valid'], 401);
        }

        // Check store ownership and order belongs to store
        if ($store->user_id != $userId || $order->store_id != $store->id) {
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
        // Check session authentication
        if (!Session::has('cred')) {
            Alert::error('Akses Ditolak', 'Sesi Anda telah berakhir. Silakan login kembali.');
            return redirect()->route('login');
        }

        $cred = Session::get('cred');
        $userId = $cred['user_id'] ?? null;

        if (!$userId) {
            Alert::error('Akses Ditolak', 'Data user tidak valid.');
            return redirect()->route('pengurus');
        }

        // Check store ownership
        if ($store->user_id != $userId) {
            Alert::error('Akses Ditolak', 'Anda bukan pemilik toko ini.');
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
        if (isset($cred['user_id'])) {
            $existingRequest = SellerRequest::where('user_id', $cred['user_id'])
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
            // Get user ID from session
            if (!isset($cred['user_id'])) {
                Alert::error('Error', 'User ID tidak ditemukan. Silakan login ulang.');
                return redirect()->route('login');
            }
            
            $userId = $cred['user_id'];
            
            // Check if user already has pending or approved request
            $existingRequest = SellerRequest::where('user_id', $userId)
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
                'user_id' => $userId,
                'store_name' => $request->store_name,
                'store_address' => $request->store_address,
                'product_type' => $request->product_type,
                'status' => SellerRequest::STATUS_PENDING
            ]);
            
            Alert::success('Pendaftaran Berhasil!', 'Pendaftaran seller Anda telah berhasil dikirim dan sudah masuk ke notifikasi pengurus. Silakan menunggu persetujuan.');
            return redirect()->route('pengurus.seller.request.status');
            
        } catch (\Exception $e) {
            \Log::error('Seller registration error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            Alert::error('Error', 'Terjadi kesalahan saat mendaftar: ' . $e->getMessage());
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
        
        // Get user ID from session
        if (!isset($cred['user_id'])) {
            Alert::error('Error', 'User ID tidak ditemukan. Silakan login ulang.');
            return redirect()->route('login');
        }
        
        // Get latest seller request
        $sellerRequest = SellerRequest::where('user_id', $cred['user_id'])
            ->latest()
            ->first();
        
        if (!$sellerRequest) {
            Alert::info('Info', 'Anda belum memiliki pendaftaran seller.');
            return redirect()->route('warungku.index');
        }
        
        return view('pengurus.seller.status', compact('sellerRequest'));
    }
}
