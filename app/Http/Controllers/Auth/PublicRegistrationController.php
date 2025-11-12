<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PublicRegistrationController extends Controller
{
    /**
     * Show public registration form for warga and pengurus
     */
    public function showRegister()
    {
        // Fetch residence list from Django API
        $residences = $this->getResidences();
        
        // Alert user if residence list is empty
        if (empty($residences)) {
            Alert::warning('Peringatan', 'Data residence tidak dapat dimuat. Silakan coba lagi nanti.');
        }
        
        return view('auth.public-register', compact('residences'));
    }

    /**
     * Get list of residences from Django API
     */
    private function getResidences()
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->timeout(10)->get(env('API_URL') . '/api/residences/');

            if ($response->successful()) {
                $data = json_decode($response->body(), true);
                return $data['data'] ?? [];
            }
            
            return [];
        } catch (\Exception $e) {
            \Log::error('Failed to fetch residences from API', [
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Handle registration form submission
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_no' => 'required|regex:/^\d{8,13}$/',
            'residence_id' => 'required|integer',
            'blok_rumah' => 'required|string|max:50',
            'account_type' => 'required|in:warga,pengurus',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'full_name.max' => 'Nama lengkap maksimal 255 karakter.',
            
            'phone_no.required' => 'Nomor HP wajib diisi.',
            'phone_no.regex' => 'Nomor HP harus terdiri dari 8 hingga 13 digit angka.',
            
            'residence_id.required' => 'Residence wajib dipilih.',
            'residence_id.integer' => 'Residence tidak valid.',
            
            'blok_rumah.required' => 'Blok rumah wajib diisi.',
            'blok_rumah.max' => 'Blok rumah maksimal 50 karakter.',
            
            'account_type.required' => 'Jenis akun wajib dipilih.',
            'account_type.in' => 'Jenis akun tidak valid.',
            
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Prepare data for Django API
        $data = [
            'full_name' => $request->full_name,
            'phone_no' => $request->phone_no,
            'residence_id' => $request->residence_id,
            'blok_rumah' => $request->blok_rumah,
            'email' => $request->email,
            'password' => $request->password,
            'account_type' => $request->account_type, // 'warga' or 'pengurus'
            'is_warga' => $request->account_type === 'warga',
            'is_pengurus' => $request->account_type === 'pengurus',
        ];

        try {
            // Call Django API for public registration
            // Use withoutDebugging() to prevent password logging in HTTP layer
            $response = Http::withoutDebugging()
                ->withHeaders([
                    'Accept' => 'application/json',
                ])
                ->timeout(15)
                ->post(env('API_URL') . '/api/auth/public-sign-up/', $data);

            $responseData = json_decode($response->body(), true);

            if ($response->successful()) {
                Alert::success('Berhasil!', $responseData['message'] ?? 'Registrasi berhasil! Silakan login dengan akun Anda.');
                return redirect()->route('login');
            } else {
                // Handle API validation errors
                $apiErrors = $responseData['errors'] ?? [];
                
                $validator = Validator::make([], []);
                
                foreach ($apiErrors as $field => $messages) {
                    foreach ((array) $messages as $message) {
                        $validator->errors()->add($field, $message);
                    }
                }

                return redirect()->route('register')
                    ->withErrors($validator)
                    ->withInput();
            }
        } catch (\Exception $e) {
            // Log exception with full diagnostic telemetry (no sensitive data)
            \Log::error('Public registration API call failed', [
                'error' => $e->getMessage(),
                'exception_class' => get_class($e),
                'trace' => $e->getTraceAsString(),
                'email' => $data['email'] ?? null,
                'residence_id' => $data['residence_id'] ?? null,
            ]);

            Alert::error('Gagal', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
            return redirect()->route('register')->withInput();
        }
    }
}
