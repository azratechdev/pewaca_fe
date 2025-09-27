<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
   
    public function showRegister($uuid = null)
    {
        //uuid: 1c99af82-cfa0-4d95-8f3e-32d1556bd6ba
        //token : cgbfol-fafbf9d5271dd1354a29c443289edcfd
        if (!$uuid) {
            abort(404, 'UUID tidak ditemukan');
        }

        $units = $this->getUnits($uuid);
        $genders = $this->getGenders();
        $religions = $this->getReligions();
        $cities = $this->getCities();
        $statuses = $this->getStatus();
        $jobs = $this->getJobs();
        $educations = $this->getEducations();
        $families = $this->getFamilies();
        $resdetail = $this->getResdetail($uuid);
        //dd($resdetail);
        //dd($status);
        return view('auth.register', compact('resdetail', 'units', 'genders', 'religions', 'cities', 'statuses', 
        'jobs', 'educations', 'families'));
    }

    public function getResdetail($uuid)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get('https://api.pewaca.id/api/residence-by-code/'.$uuid."/");
        $res_detail_response = json_decode($response->body(), true);
        return $res_detail_response['data'];
    }

    public function getFamilies()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get('https://api.pewaca.id/api/family-as/');
        $gender_response = json_decode($response->body(), true);
        return $gender_response['data'];
    }

    public function getUnits($uuid)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get('https://api.pewaca.id/api/units/code/'.$uuid."/");
        $unit_response = json_decode($response->body(), true);
        //dd($unit_response);
        if($unit_response['data']){
            return $unit_response['data'];
        }
        else{
            return [];
        }
    }

    public function getGenders()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get('https://api.pewaca.id/api/gender/');
        $gender_response = json_decode($response->body(), true);
        return $gender_response['data'];
    }

    public function getReligions()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get('https://api.pewaca.id/api/religions/');
        $religion_response = json_decode($response->body(), true);
        return $religion_response['data'];
    }

    public function getCities()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get('https://api.pewaca.id/api/cities/');
        $cities_response = json_decode($response->body(), true);
        return $cities_response['data'];
    }

    public function getStatus()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get('https://api.pewaca.id/api/marital-statuses/');
        $status_response = json_decode($response->body(), true);
        return $status_response['data'];
    }

    public function getJobs()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get('https://api.pewaca.id/api/ocupation/');
        $job_response = json_decode($response->body(), true);
        return $job_response['data'];
    }

    public function getEducations()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get('https://api.pewaca.id/api/education/');
        $education_response = json_decode($response->body(), true);
        return $education_response['data'];
    }

    public function postRegister(Request $request)
    {   
        $request->validate([
            'unit_id' => 'required|integer',
            'nik' => 'nullable',
            // 'nik' => 'nullable|regex:/^\d{16}$/',
            'full_name' => 'required|string|max:255',
            'phone_no' => 'required|regex:/^\d{8,13}$/',
            'gender_id' => 'required|integer',
            'date_of_birth' => 'required|date',
            'religion' => 'required|integer',
            'place_of_birth' => 'required|string|max:255',
            'marital_status' => 'required|integer',
            'marital_photo' => 'nullable|image|mimes:jpeg,jpg,png',
            'occupation' => 'required|integer',
            'education' => 'required|integer',
            'family_as' => 'required|integer',
            'profile_photo' => 'required|image|mimes:jpeg,jpg,png',
            'code' => 'required|uuid',
            'email' => 'required|email',
            'password' => 'required|string'
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
        
            'marital_photo.image' => 'Foto pernikahan harus berupa gambar.',
            'marital_photo.mimes' => 'Format foto pernikahan harus jpeg atau jpg.',
            
        
            'occupation.required' => 'Pekerjaan wajib dipilih.',
            'occupation.integer' => 'Pekerjaan tidak valid.',
        
            'education.required' => 'Pendidikan wajib dipilih.',
            'education.integer' => 'Pendidikan tidak valid.',
        
            'family_as.required' => 'Status dalam keluarga wajib dipilih.',
            'family_as.integer' => 'Status dalam keluarga tidak valid.',
        
            'profile_photo.image' => 'Foto profil harus berupa gambar.',
            'profile_photo.mimes' => 'Format foto profil harus jpeg atau jpg.',
            
        
            'code.required' => 'Kode tidak boleh kosong.',
            'code.uuid' => 'Kode tidak valid.',
        
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password tidak valid.',
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password,
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
            'code' => $request->code
           
        ];
        //'dd($data);
        try {
            //dd("here");
            $http = Http::withHeaders([
                'Accept' => 'application/json',
            ]);

            if (isset($request->profile_photo) && $request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $http->attach('profile_photo', file_get_contents($file->getRealPath()), $file->getClientOriginalName());
            }

            if (isset($request->marital_photo) && $request->hasFile('marital_photo')) {
                $file = $request->file('marital_photo');
                $http->attach('marriagePhoto', file_get_contents($file->getRealPath()), $file->getClientOriginalName());
            }
           
            $response = $http->post('http://43.156.75.206:8000/api/auth/sign-up/'.$request->code."/", $data);
  
            $data_response = json_decode($response->body(), true);

            //dd($data_response);

            if ($response->successful()) {
                session()->flash('status', 'success');
                session()->flash('message', $data_response['data']['message']);
                return redirect()->route('showRegister', ['uuid' => $request->code]);
            } else {
               
                $data_errors = $data_response['errors'] ?? [];

                $validator = Validator::make([], []);
                
                foreach ($data_errors as $field => $messages) {
                    foreach ($messages as $message) {
                        $validator->errors()->add($field, $message);
                    }
                }

                return redirect()->route('showRegister', ['uuid' => $request->code])
                                ->withErrors($validator)
                                ->withInput(); 
            }
        
        } catch (\Exception $e) {
            session()->flash('status', 'error');
            session()->flash('message', 'Gagal Mengirim Data');
            return redirect()->route('showRegister', ['uuid' => $request->code])->withInput();
        }
    }

    public function verified($uuid = null, $token = null)
    {
        return view('auth.verify');
    } 
    
    public function postVerified(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'token' => 'required|string'
        ]);

        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get('https://api.pewaca.id/api/auth/verify/'.$request->code."/".$request->token."/");
        $verify_response = json_decode($response->body(), true);
        
        //dd($verify_response);
        
    }
    
}
