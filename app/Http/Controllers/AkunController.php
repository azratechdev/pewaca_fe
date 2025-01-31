<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Validator;

class AkunController extends Controller
{
    public function akun()
    {
        $user = Session::get('cred');
        $warga = Session::get('warga');
        //dd($user);
        return view('akun.akunpage', compact('user', 'warga'));
    }

    public function infoakun()
    {   
       
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/auth/profil/');
        $warga_response = json_decode($response->body(), true);
        $data = $warga_response['data'];
        //dd($data);
        return view('akun.akuninfo', compact('data'));
    }

    public function inforekening()
    {   
        $residence = Session::get('warga');
        $residence_id = $residence['residence'];
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/residence-banks/list_banks/?residence_id='.$residence_id.'');
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

    public function addKeluarga()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/family-as/');
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
        ])->get('https://api.pewaca.id/api/auth/profil/');
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
        ])->get('https://api.pewaca.id/api/family-as/');
        $gender_response = json_decode($response->body(), true);
        return $gender_response['data'];
    }

    public function getUnits()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/units/');
        $unit_response = json_decode($response->body(), true);
        return $unit_response['data'];
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

    public function addRekening()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get('https://api.pewaca.id/api/banks/');
        $bank_response = json_decode($response->body(), true);
        $banks =  $bank_response['data'];
      
        //dd($residence_id);
        return view('akun.addrekening', compact('banks'));
    }

    public function postRekening(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'nama_lengkap' => 'required|string',
            'nomor_rekening' => 'required|string',
            'nama_bank' => 'required|integer',
        ]);

        $residence = Session::get('warga');
        $residence_id = $residence['residence'];

        $data = [
            'account_number' => $request->nomor_rekening,
            'account_holder_name' => $request->nama_lengkap,
            'isactive' => true,
            'residence' => $residence_id,
            'bank' => $request->nama_bank
        ];
        //dd($data);
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token '.Session::get('token'),
            ])->post('https://api.pewaca.id/api/residence-banks/', $data);
            $data_response = json_decode($response->body(), true);
            
            if ($response->successful()) {
                Session::flash('flash-message', [
                    'message' => 'Rekening baru berhasil ditambahkan',
                    'alert-class' => 'alert-success',
                ]);
                return redirect()->route('inforekening');
            } else {
                Session::flash('flash-message', [
                    'message' => 'Periksa Data Kembali',
                    'alert-class' => 'alert-warning',
                ]);
                return redirect()->route('addRekening');
            }
               
        } catch (\Exception $e) {
               
            Session::flash('flash-message', [
                'message' => 'Gagal Mengirim Data',
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('addRekening');
        }
    }

    public function updateAkun(Request $request)
    {
        
        $request->validate([
            'unit_id' => 'required|integer',
            'nik' => 'required|numeric',
            'full_name' => 'required|string|max:255',
            'phone_no' => 'required|string|min:8|max:13',
            'gender_id' => 'required|integer',
            'date_of_birth' => 'required|date',
            'religion' => 'required|integer',
            'place_of_birth' => 'required|string|max:255',
            'marital_status' => 'required|integer',
            'marriagePhoto' => 'nullable|image|mimes:jpeg,jpg|max:2048',
            'occupation' => 'required|integer',
            'education' => 'required|integer',
            'family_as' => 'required|integer',
            'profile_photo' => 'nullable|image|mimes:jpeg,jpg|max:2048',
            'email' => 'required|email',
            
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
                       
        ];

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
    
            $response = $http->put('https://api.pewaca.id/api/auth/profil/update/', $data);
            $response = json_decode($response->body(), true);


            if ($response->successful()) {
                Session::flash('flash-message', [
                    'message' => $response['data']['message'],
                    'alert-class' => 'alert-success',
                ]);
                return redirect()->route('akunEdit');
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
            return redirect()->route('addkeluarga')->withInput();
        }
    }

   
}
