<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\OneSignalService;

class TestOneSignalController extends Controller
{
    protected $oneSignal;

    public function __construct(OneSignalService $oneSignal)
    {
        $this->oneSignal = $oneSignal;
    }

    public function index()
    {
        $warga = Session::get('warga');
        $wargaId = $warga['id'] ?? null;
        
        return view('test.onesignal', compact('wargaId'));
    }

    public function sendTest(Request $request)
    {
        $warga = Session::get('warga');
        $wargaId = $warga['id'] ?? null;

        if (!$wargaId) {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'User tidak ditemukan. Silakan login terlebih dahulu.'
            ]);
        }

        try {
            // Send test notification
            $result = $this->oneSignal->sendToUser(
                $wargaId,
                '🔔 Test Notification',
                'Ini adalah test notification dari OneSignal. Jika Anda melihat ini, berarti OneSignal sudah berfungsi dengan baik!',
                [
                    'type' => 'test',
                    'timestamp' => now()->toDateTimeString()
                ]
            );

            if ($result) {
                return redirect()->back()->with([
                    'status' => 'success',
                    'message' => 'Test notification berhasil dikirim! Cek browser Anda untuk melihat notifikasi.'
                ]);
            } else {
                return redirect()->back()->with([
                    'status' => 'error',
                    'message' => 'Gagal mengirim notification. Cek log untuk detail.'
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
