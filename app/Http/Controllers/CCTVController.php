<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CCTVController extends Controller
{
    /**
     * Display CCTV dashboard
     */
    public function index()
    {
        $residence = Session::get('warga.residence');
        $isPengurus = Session::get('cred.is_pengurus') ?? false;
        
        // Get all cameras for this residence from MySQL
        $cameras = DB::table('cctv_cameras')
            ->where('residence_id', $residence)
            ->where('is_active', true)
            ->orderBy('location_name')
            ->get();
        
        // Get camera groups
        $groups = DB::table('cctv_cameras')
            ->select('location_group')
            ->where('residence_id', $residence)
            ->where('is_active', true)
            ->groupBy('location_group')
            ->pluck('location_group');
        
        return view('cctv.index', compact('cameras', 'groups', 'isPengurus'));
    }
    
    /**
     * Live Monitor - Multiple cameras in grid
     */
    public function monitor()
    {
        $residence = Session::get('warga.residence');
        
        // Get all active cameras for this residence
        $cameras = DB::table('cctv_cameras')
            ->where('residence_id', $residence)
            ->where('is_active', true)
            ->orderBy('location_name')
            ->get();
        
        return view('cctv.monitor', compact('cameras'));
    }
    
    /**
     * Show single camera view
     */
    public function show($id)
    {
        $residence = Session::get('warga.residence');
        
        $camera = DB::table('cctv_cameras')
            ->where('id', $id)
            ->where('residence_id', $residence)
            ->where('is_active', true)
            ->first();
        
        if (!$camera) {
            abort(404, 'Camera not found');
        }
        
        return view('cctv.show', compact('camera'));
    }
    
    /**
     * Get camera stream URL (for AJAX)
     */
    public function getStreamUrl($id)
    {
        $residence = Session::get('warga.residence');
        
        $camera = DB::table('cctv_cameras')
            ->where('id', $id)
            ->where('residence_id', $residence)
            ->where('is_active', true)
            ->first();
        
        if (!$camera) {
            return response()->json(['error' => 'Camera not found'], 404);
        }
        
        return response()->json([
            'stream_url' => $camera->stream_url,
            'camera_name' => $camera->camera_name,
            'location_name' => $camera->location_name
        ]);
    }
    
    /**
     * Manage cameras (Pengurus only)
     */
    public function manage()
    {
        $isPengurus = Session::get('cred.is_pengurus') ?? false;
        if (!$isPengurus) {
            abort(403, 'Unauthorized');
        }
        
        $residence = Session::get('warga.residence');
        
        $cameras = DB::table('cctv_cameras')
            ->where('residence_id', $residence)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('cctv.manage', compact('cameras'));
    }
    
    /**
     * Add new camera (Pengurus only)
     */
    public function store(Request $request)
    {
        $isPengurus = Session::get('cred.is_pengurus') ?? false;
        if (!$isPengurus) {
            abort(403, 'Unauthorized');
        }
        
        $request->validate([
            'camera_name' => 'required|string|max:255',
            'location_name' => 'required|string|max:255',
            'location_group' => 'required|string|max:100',
            'stream_url' => 'required|url',
            'description' => 'nullable|string'
        ]);
        
        $residence = Session::get('warga.residence');
        
        // Convert checkbox value to boolean
        $isActive = $request->has('is_active') ? true : false;
        
        DB::table('cctv_cameras')->insert([
            'residence_id' => $residence,
            'camera_name' => $request->camera_name,
            'location_name' => $request->location_name,
            'location_group' => $request->location_group,
            'stream_url' => $request->stream_url,
            'description' => $request->description,
            'is_active' => $isActive,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        return redirect()->route('cctv.manage')->with('success', 'Kamera berhasil ditambahkan');
    }
    
    /**
     * Update camera (Pengurus only)
     */
    public function update(Request $request, $id)
    {
        $isPengurus = Session::get('cred.is_pengurus') ?? false;
        if (!$isPengurus) {
            abort(403, 'Unauthorized');
        }
        
        $request->validate([
            'camera_name' => 'required|string|max:255',
            'location_name' => 'required|string|max:255',
            'location_group' => 'required|string|max:100',
            'stream_url' => 'required|url',
            'description' => 'nullable|string'
        ]);
        
        $residence = Session::get('warga.residence');
        
        // Convert checkbox value to boolean
        $isActive = $request->has('is_active') ? true : false;
        
        DB::table('cctv_cameras')
            ->where('id', $id)
            ->where('residence_id', $residence)
            ->update([
                'camera_name' => $request->camera_name,
                'location_name' => $request->location_name,
                'location_group' => $request->location_group,
                'stream_url' => $request->stream_url,
                'description' => $request->description,
                'is_active' => $isActive,
                'updated_at' => now()
            ]);
        
        return redirect()->route('cctv.manage')->with('success', 'Kamera berhasil diperbarui');
    }
    
    /**
     * Delete camera (Pengurus only)
     */
    public function destroy($id)
    {
        $isPengurus = Session::get('cred.is_pengurus') ?? false;
        if (!$isPengurus) {
            abort(403, 'Unauthorized');
        }
        
        $residence = Session::get('warga.residence');
        
        DB::table('cctv_cameras')
            ->where('id', $id)
            ->where('residence_id', $residence)
            ->delete();
        
        return redirect()->route('cctv.manage')->with('success', 'Kamera berhasil dihapus');
    }
}
