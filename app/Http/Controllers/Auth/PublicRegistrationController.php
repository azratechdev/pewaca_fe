<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
            Log::error('Failed to fetch residences from API', [
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
        // Validate input - unit_id is nullable for backward compatibility
        // Require EITHER unit_id (new dropdown) OR blok_rumah (fallback text input)
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_no' => 'required|regex:/^\d{8,13}$/',
            'residence_id' => 'required|integer',
            'unit_id' => 'nullable|integer',
            'unit_name' => 'nullable|string|max:50',
            'blok_rumah_fallback' => 'nullable|string|max:50',
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
            
            'unit_id.integer' => 'Unit tidak valid.',
            
            'account_type.required' => 'Jenis akun wajib dipilih.',
            'account_type.in' => 'Jenis akun tidak valid.',
            
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);
        
        // Custom validation: require EITHER unit_id OR blok_rumah_fallback
        if (empty($request->unit_id) && empty($request->blok_rumah_fallback)) {
            return redirect()->back()
                ->withErrors(['unit_id' => 'Blok rumah wajib diisi.'])
                ->withInput();
        }

        // Prepare data for Django API
        // Dual submission for backward compatibility until Django is updated
        $data = [
            'full_name' => $request->full_name,
            'phone_no' => $request->phone_no,
            'residence_id' => $request->residence_id,
            'email' => $request->email,
            'password' => $request->password,
            'account_type' => $request->account_type, // 'warga' or 'pengurus'
            'is_warga' => $request->account_type === 'warga',
            'is_staff' => $request->account_type === 'pengurus',
        ];
        
        // Add unit_id if available (new Django API)
        if (!empty($request->unit_id)) {
            $data['unit_id'] = $request->unit_id;
        }
        
        // Always send blok_rumah for backward compatibility
        if (!empty($request->unit_name)) {
            // From dropdown
            $data['blok_rumah'] = $request->unit_name;
        } elseif (!empty($request->blok_rumah_fallback)) {
            // From fallback text input
            $data['blok_rumah'] = $request->blok_rumah_fallback;
        } elseif (!empty($request->unit_id)) {
            // Fallback if only unit_id available
            $data['blok_rumah'] = 'Unit-' . $request->unit_id;
        }

        try {
            // Call Django API for public registration
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])
            ->timeout(15)
            ->post(env('API_URL') . '/api/auth/public-sign-up/', $data);

            $responseData = json_decode($response->body(), true);
            
            // Log response for debugging
            Log::info('Public registration API response', [
                'status_code' => $response->status(),
                'success' => $response->successful(),
                'has_data' => isset($responseData),
            ]);

            if ($response->successful()) {
                $message = $responseData['message'] ?? 'Registrasi berhasil! Silakan login dengan akun Anda.';
                
                return redirect()->route('register')
                    ->with('success', $message)
                    ->withInput(['email' => $data['email']]);
            } else {
                // Handle API validation errors
                $apiErrors = $responseData['errors'] ?? [];
                $errorMessage = $responseData['message'] ?? 'Registrasi gagal. Silakan periksa data Anda.';
                
                // If we have specific field errors, use Laravel validation
                if (!empty($apiErrors)) {
                    $validator = Validator::make([], []);
                    
                    foreach ($apiErrors as $field => $messages) {
                        foreach ((array) $messages as $message) {
                            $validator->errors()->add($field, $message);
                        }
                    }

                    return redirect()->route('register')
                        ->withErrors($validator)
                        ->withInput();
                } else {
                    // Generic error message
                    return redirect()->route('register')
                        ->with('error', $errorMessage)
                        ->withInput();
                }
            }
        } catch (\Exception $e) {
            // Log exception with full diagnostic telemetry (no sensitive data)
            Log::error('Public registration API call failed', [
                'error' => $e->getMessage(),
                'exception_class' => get_class($e),
                'trace_preview' => substr($e->getTraceAsString(), 0, 500),
                'email' => $data['email'] ?? null,
                'residence_id' => $data['residence_id'] ?? null,
            ]);

            $errorMsg = 'Terjadi kesalahan saat menghubungi server. ';
            
            if (strpos($e->getMessage(), 'Connection refused') !== false) {
                $errorMsg .= 'Server tidak dapat dijangkau.';
            } elseif (strpos($e->getMessage(), 'timed out') !== false) {
                $errorMsg .= 'Koneksi timeout.';
            } else {
                $errorMsg .= 'Silakan coba lagi.';
            }

            return redirect()->route('register')
                ->with('error', $errorMsg)
                ->withInput();
        }
    }
}
