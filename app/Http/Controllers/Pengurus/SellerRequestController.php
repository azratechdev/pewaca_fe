<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\SellerRequest;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class SellerRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:pengurus');
    }

    public function index(Request $request)
    {
        $query = SellerRequest::with(['user', 'approver'])->latest();
        
        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Search by store name or user name
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('store_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $sellerRequests = $query->paginate(15);
        $pendingCount = SellerRequest::where('status', SellerRequest::STATUS_PENDING)->count();
        
        return view('pengurus.seller-requests.index', compact('sellerRequests', 'pendingCount'));
    }

    public function show($id)
    {
        $sellerRequest = SellerRequest::with(['user', 'approver'])->findOrFail($id);
        
        return view('pengurus.seller-requests.show', compact('sellerRequest'));
    }

    public function approve($id)
    {
        // Verify session exists
        if (!Session::has('cred')) {
            Alert::error('Error', 'Sesi Anda telah berakhir. Silakan login kembali.');
            return redirect()->route('login');
        }
        
        try {
            DB::beginTransaction();
            
            // Lock the row to prevent race conditions
            $sellerRequest = SellerRequest::where('id', $id)->lockForUpdate()->first();
            
            if (!$sellerRequest) {
                DB::rollBack();
                Alert::error('Error', 'Pendaftaran tidak ditemukan.');
                return redirect()->back();
            }
            
            // Check if still pending (after lock)
            if (!$sellerRequest->isPending()) {
                DB::rollBack();
                Alert::warning('Perhatian', 'Pendaftaran ini sudah diproses sebelumnya.');
                return redirect()->back();
            }
            
            // Get approver info from session
            $cred = Session::get('cred');
            
            if (!isset($cred['user_id'])) {
                DB::rollBack();
                Alert::error('Error', 'Approver ID tidak ditemukan. Silakan login ulang.');
                return redirect()->route('login');
            }
            
            $approverId = $cred['user_id'];
            
            // Check if user already has a store
            $existingStore = Store::where('user_id', $sellerRequest->user_id)->first();
            
            if ($existingStore) {
                DB::rollBack();
                Alert::warning('Perhatian', 'User ini sudah memiliki toko: ' . $existingStore->name);
                return redirect()->back();
            }
            
            // Create store
            Store::create([
                'user_id' => $sellerRequest->user_id,
                'name' => $sellerRequest->store_name,
                'address' => $sellerRequest->store_address,
                'product_type' => $sellerRequest->product_type,
                'description' => 'Toko ' . $sellerRequest->product_type,
                'is_active' => true,
                'rating' => 4.50
            ]);
            
            // Update seller request status
            $sellerRequest->update([
                'status' => SellerRequest::STATUS_APPROVED,
                'approved_by' => $approverId,
                'approved_at' => now()
            ]);
            
            DB::commit();
            
            Alert::success('Berhasil!', 'Pendaftaran seller "' . $sellerRequest->store_name . '" telah disetujui.');
            return redirect()->route('pengurus.seller-requests.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Terjadi kesalahan saat menyetujui pendaftaran: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function reject(Request $request, $id)
    {
        // Verify session exists
        if (!Session::has('cred')) {
            Alert::error('Error', 'Sesi Anda telah berakhir. Silakan login kembali.');
            return redirect()->route('login');
        }
        
        $request->validate([
            'rejection_reason' => 'required|string|min:10|max:500'
        ], [
            'rejection_reason.required' => 'Alasan penolakan harus diisi.',
            'rejection_reason.min' => 'Alasan penolakan minimal 10 karakter.',
            'rejection_reason.max' => 'Alasan penolakan maksimal 500 karakter.'
        ]);
        
        try {
            DB::beginTransaction();
            
            // Lock the row to prevent race conditions
            $sellerRequest = SellerRequest::where('id', $id)->lockForUpdate()->first();
            
            if (!$sellerRequest) {
                DB::rollBack();
                Alert::error('Error', 'Pendaftaran tidak ditemukan.');
                return redirect()->back();
            }
            
            // Check if still pending (after lock)
            if (!$sellerRequest->isPending()) {
                DB::rollBack();
                Alert::warning('Perhatian', 'Pendaftaran ini sudah diproses sebelumnya.');
                return redirect()->back();
            }
            
            // Get approver info from session
            $cred = Session::get('cred');
            
            if (!isset($cred['user_id'])) {
                DB::rollBack();
                Alert::error('Error', 'Approver ID tidak ditemukan. Silakan login ulang.');
                return redirect()->route('login');
            }
            
            $approverId = $cred['user_id'];
            
            $sellerRequest->update([
                'status' => SellerRequest::STATUS_REJECTED,
                'rejection_reason' => $request->rejection_reason,
                'approved_by' => $approverId,
                'approved_at' => now()
            ]);
            
            DB::commit();
            
            Alert::success('Berhasil!', 'Pendaftaran seller telah ditolak.');
            return redirect()->route('pengurus.seller-requests.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Terjadi kesalahan saat menolak pendaftaran: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
