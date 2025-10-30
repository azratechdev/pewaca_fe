<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AkunController extends Controller
{
    public function akun()
    {
        $user = Session::get('cred');
        $warga = Session::get('warga');
        //dd($warga);
        return view('akun.akunpage', compact('user', 'warga'));
    }

    public function infoakun()
    {   
       
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get(env('API_URL') . '/api/auth/profil/');
        $warga_response = json_decode($response->body(), true);
        $data = $warga_response['data'];
        //dd($data);
        return view('akun.akuninfo', compact('data'));
    }

    public function inforekening()
    {   
       // dd(Session::all());
        $residence = Session::get('warga');
        $residence_id = $residence['residence'];
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get(env('API_URL') . '/api/residence-banks/list_banks/?residence_id='.$residence_id.'');
        $bank_response = json_decode($response->body(), true);
        $bank_list = $bank_response['data'];
        //dd($bank_list);
        return view('akun.rekeninginfo', compact('bank_list'));
    }

    public function infokeluarga()
    {   
        $user = Session::get('cred');
        $warga = Session::get('warga');
        $residence = Session::get('residence');
        return view('akun.familyinfo', compact('user', 'warga', 'residence'));
    }

    public function faq()
    {   
        
        return view('akun.faq');
    }

    public function policy()
    {   
        
        return view('akun.policy');
    }

    public function kontak()
    {   
        
        return view('akun.kontak');
    }

    public function addKeluarga()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get(env('API_URL') . '/api/family-as/');
        $warga_response = json_decode($response->body(), true);
        $families = $warga_response['data'];
        //dd($families);
        return view('akun.addkeluarga', compact('families'));
    }

    public function postKeluarga(Request $request)
    {
        dd($request->all());
    }

    public function editAkun()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get(env('API_URL') . '/api/auth/profil/');
        $warga_response = json_decode($response->body(), true);
        $data = $warga_response['data'];

        //dd($data);
    
        $units = $this->getUnits();//dd($units);
        $genders = $this->getGenders();
        $religions = $this->getReligions();
        $cities = $this->getCities();
        $statuses = $this->getStatus();
        $jobs = $this->getJobs();
        $educations = $this->getEducations();
        $families = $this->getFamilies();
        
        return view('akun.editakun', compact('data', 'units', 'genders', 'religions', 'cities', 'statuses', 
        'jobs', 'educations', 'families'));

    }

    public function getFamilies()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get(env('API_URL') . '/api/family-as/');
        $gender_response = json_decode($response->body(), true);
        return $gender_response['data'];
    }

    public function getUnits()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get(env('API_URL') . '/api/units/');
        $unit_response = json_decode($response->body(), true);
        return $unit_response['data'];
    }

    public function getGenders()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get(env('API_URL') . '/api/gender/');
        $gender_response = json_decode($response->body(), true);
        return $gender_response['data'];
    }

    public function getReligions()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get(env('API_URL') . '/api/religions/');
        $religion_response = json_decode($response->body(), true);
        return $religion_response['data'];
    }

    public function getCities()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get(env('API_URL') . '/api/cities/');
        $cities_response = json_decode($response->body(), true);
        return $cities_response['data'];
    }

    public function getStatus()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get(env('API_URL') . '/api/marital-statuses/');
        $status_response = json_decode($response->body(), true);
        return $status_response['data'];
    }

    public function getJobs()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get(env('API_URL') . '/api/ocupation/');
        $job_response = json_decode($response->body(), true);
        return $job_response['data'];
    }

    public function getEducations()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get(env('API_URL') . '/api/education/');
        $education_response = json_decode($response->body(), true);
        return $education_response['data'];
    }

    public function addRekening()
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token '.Session::get('token'),
            ])->get(env('API_URL') . '/api/banks/');
            
            if ($response->successful()) {
                $bank_response = json_decode($response->body(), true);
                $banks = $bank_response['data'] ?? [];
            } else {
                Log::error('Failed to get banks', ['status' => $response->status(), 'body' => $response->body()]);
                $banks = [];
                
                Session::flash('flash-message', [
                    'message' => 'Gagal mengambil data bank dari server. Silakan coba lagi.',
                    'alert-class' => 'alert-danger',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Exception in addRekening', ['error' => $e->getMessage()]);
            $banks = [];
            
            Session::flash('flash-message', [
                'message' => 'Terjadi kesalahan. Silakan coba lagi.',
                'alert-class' => 'alert-danger',
            ]);
        }
      
        return view('akun.addrekening', compact('banks'));
    }

    public function postRekening(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string',
            'nomor_rekening' => 'required|string',
            'nama_bank' => 'required|integer',
        ]);

        $residence = Session::get('warga');
        $residence_id = $residence['residence'] ?? null;

        if (!$residence_id) {
            Session::flash('flash-message', [
                'message' => 'Session warga tidak valid. Silakan login ulang.',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('addRekening');
        }

        $data = [
            'account_number' => $request->nomor_rekening,
            'account_holder_name' => $request->nama_lengkap,
            'isactive' => false,
            'residence' => $residence_id,
            'bank' => $request->nama_bank
        ];
        
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token '.Session::get('token'),
            ])->post(env('API_URL') . '/api/residence-banks/', $data);
            
            $data_response = json_decode($response->body(), true);
            
            if ($response->successful()) {
                Session::flash('flash-message', [
                    'message' => 'Rekening baru berhasil ditambahkan',
                    'alert-class' => 'alert-success',
                ]);
                return redirect()->route('inforekening');
            } else {
                // Log error details
                Log::error('Failed to add rekening', [
                    'status' => $response->status(),
                    'response' => $data_response,
                    'request_data' => $data
                ]);
                
                // Get error message from API if available
                $errorMessage = 'Periksa Data Kembali';
                if (isset($data_response['message'])) {
                    $errorMessage = $data_response['message'];
                } elseif (isset($data_response['error'])) {
                    $errorMessage = $data_response['error'];
                }
                
                Session::flash('flash-message', [
                    'message' => $errorMessage,
                    'alert-class' => 'alert-warning',
                ]);
                return redirect()->route('addRekening');
            }
               
        } catch (\Exception $e) {
            Log::error('Exception in postRekening', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            Session::flash('flash-message', [
                'message' => 'Gagal Mengirim Data: ' . $e->getMessage(),
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('addRekening');
        }
    }

    public function updateAkun(Request $request)
    {
        
        $request->validate([
            'unit_id' => 'required|integer',
            'nik' => 'nullable',
            // 'nik' => 'required|regex:/^\d{16}$/',
            'full_name' => 'required|string|max:255',
            'phone_no' => 'required|regex:/^\d{8,13}$/',
            'gender_id' => 'required|integer',
            'date_of_birth' => 'required|date',
            'religion' => 'required|integer',
            'place_of_birth' => 'required|string|max:255',
            'marital_status' => 'required|integer',
            'marriagePhoto' => 'nullable|image|mimes:jpeg,jpg',
            'occupation' => 'required|integer',
            'education' => 'required|integer',
            'family_as' => 'required|integer',
            'profile_photo' => 'nullable|image|mimes:jpeg,jpg',
        ], [
            'unit_id.required' => 'Unit wajib diisi.',
            'unit_id.integer' => 'Unit harus berupa angka.',
        
            // 'nik.required' => 'NIK wajib diisi.',
            // 'nik.regex' => 'NIK harus terdiri dari 16 digit angka.',
        
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'full_name.string' => 'Nama lengkap harus berupa teks.',
            'full_name.max' => 'Nama lengkap maksimal 255 karakter.',
        
            'phone_no.required' => 'Nomor HP / Telephon wajib diisi.',
            'phone_no.regex' => 'Nomor telepon harus terdiri dari 8 hingga 13 digit angka.',
        
            'gender_id.required' => 'Jenis kelamin wajib dipilih.',
            'gender_id.integer' => 'Jenis kelamin tidak valid.',
        
            'date_of_birth.required' => 'Tanggal lahir wajib diisi.',
            'date_of_birth.date' => 'Tanggal lahir tidak valid.',
        
            'religion.required' => 'Agama wajib dipilih.',
            'religion.integer' => 'Agama tidak valid.',
        
            'place_of_birth.required' => 'Tempat lahir wajib diisi.',
            'place_of_birth.string' => 'Tempat lahir harus berupa teks.',
            'place_of_birth.max' => 'Tempat lahir maksimal 255 karakter.',
        
            'marital_status.required' => 'Status pernikahan wajib dipilih.',
            'marital_status.integer' => 'Status pernikahan tidak valid.',
        
            'marriagePhoto.image' => 'Foto pernikahan harus berupa gambar.',
            'marriagePhoto.mimes' => 'Format foto pernikahan harus jpeg atau jpg.',
            
        
            'occupation.required' => 'Pekerjaan wajib dipilih.',
            'occupation.integer' => 'Pekerjaan tidak valid.',
        
            'education.required' => 'Pendidikan wajib dipilih.',
            'education.integer' => 'Pendidikan tidak valid.',
        
            'family_as.required' => 'Status keluarga wajib dipilih.',
            'family_as.integer' => 'Status keluarga tidak valid.',
        
            'profile_photo.image' => 'Foto profil harus berupa gambar.',
            'profile_photo.mimes' => 'Format foto profil harus jpeg atau jpg.',
            
        ]);

        $data = [
           // 'email' => $request->email,
           // 'password' => $request->password,
            'unit_id' => $request->unit_id,
            'nik' => $request->nik,
            'full_name' => $request->full_name,
            'phone_no' => $request->phone_no,
            'gender_id' => $request->gender_id,
            'date_of_birth' => $request->date_of_birth,
            'religion' => $request->religion,
            'place_of_birth' => $request->place_of_birth,
            'marital_status' => $request->marital_status,
            'occupation' => $request->occupation,
            'education' => $request->education,
            'family_as' => $request->family_as,
        ];

        //dd($data);

        try {

            $http = Http::asMultipart()
            ->withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token ' . Session::get('token'), // Sesuai dengan curl Swagger
            ]);
        
            if (isset($request->profile_photo) && $request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $http = $http->attach(
                    'profile_photo',
                    file_get_contents($file->getRealPath()),
                    $file->getClientOriginalName()
                );
            }

            if (isset($request->marriagePhoto) && $request->hasFile('marriagePhoto')) {
                $file = $request->file('marriagePhoto');
                $http = $http->attach(
                    'marriage_photo',
                    file_get_contents($file->getRealPath()),
                    $file->getClientOriginalName()
                );
            }
    
            $response = $http->put(env('API_URL') . '/api/auth/profil/update/', $data);
            $response = json_decode($response->body(), true);

            //dd($response);

            if ($response['success'] == true) {
                Session::flash('flash-message', [
                    'message' => 'Akun berhasil diedit',
                    'alert-class' => 'alert-success',
                ]);
                return redirect()->route('infoakun');

            } else {
               
                $data_errors = $data_response['errors'] ?? [];

                $validator = Validator::make([], []);
                
                foreach ($data_errors as $field => $messages) {
                    foreach ($messages as $message) {
                        $validator->errors()->add($field, $message);
                    }
                }

                return redirect()->route('akunEdit')
                                ->withErrors($validator)
                                ->withInput(); 
            }
        
        } catch (\Exception $e) {
            session()->flash('status', 'error');
            session()->flash('message', 'Gagal Mengirim Data');
            return redirect()->route('akunEdit')->withInput();
        }
    }

   
}
