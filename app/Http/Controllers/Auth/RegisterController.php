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
    
    // http://43.156.75.206
    public function getResdetail($uuid)
    {
        $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Accept' => 'application/json',
            ])->get(env('API_URL') . '/api/residence-by-code/'.$uuid."/");
        $res_detail_response = json_decode($response->body(), true);
        
        // Fix image URL if it contains duplicate base URL
        if (isset($res_detail_response['data']['image'])) {
            $imageUrl = $res_detail_response['data']['image'];
            // Remove duplicate http://domain.com/http:// or https://
            $imageUrl = preg_replace('/^https?:\/\/[^\/]+\/https?:\/\//', 'https://', $imageUrl);
            $res_detail_response['data']['image'] = $imageUrl;
        }
        
        return $res_detail_response['data'];
    }

    public function getFamilies()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get(env('API_URL') . '/api/family-as/');
        $gender_response = json_decode($response->body(), true);
        return $gender_response['data'];
    }

    public function getUnits($uuid)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get(env('API_URL') . '/api/units/code/'.$uuid."/");
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

    public function postRegister(Request $request)
    {   
        $request->validate([
            'unit_id' => 'required|integer',
            'full_name' => 'required|string|max:255',
            'phone_no' => 'required|regex:/^\d{8,13}$/',
            'family_as' => 'required|integer',
            'code' => 'required|uuid',
            'email' => 'required|email',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required'
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

            'family_as.required' => 'Status dalam keluarga wajib dipilih.',
            'family_as.integer' => 'Status dalam keluarga tidak valid.',
                
            'code.required' => 'Kode tidak boleh kosong.',
            'code.uuid' => 'Kode tidak valid.',
        
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password tidak valid.',

            'g-recaptcha-response.required' => 'Captcha wajib diisi.',
            'g-recaptcha-response.string' => 'Captcha tidak valid.',
        ]);

        $recaptchaResponse = $request->input('g-recaptcha-response');

        // Verifikasi ke Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('recaptcha.secretkey'),
            'response' => $recaptchaResponse,
        ]);

        $result = $response->json();

        if (!$result['success']) {
            return back()->withErrors([
                'login' => 'Verifikasi CAPTCHA gagal. Anda mungkin dianggap bot.'
            ])->withInput();
        }


        $data = [
            'email' => $request->email,
            'password' => $request->password,
            'unit_id' => $request->unit_id,
            'full_name' => $request->full_name,
            'phone_no' => $request->phone_no,
            'family_as' => $request->family_as,
            'code' => $request->code
        ];
        //dd($data);
        try {
            //dd("here");
            $http = Http::withHeaders([
                'Accept' => 'application/json',
            ])->asMultipart();
                    
            $response = $http->post(env('API_URL') . '/api/auth/sign-up/'.$request->code."/", $data);
  
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
        ])->get(env('API_URL') . '/api/auth/verify/'.$request->code."/".$request->token."/");
        $verify_response = json_decode($response->body(), true);
        
        //dd($verify_response);
        
    }
    
}
