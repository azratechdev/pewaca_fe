<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;


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
        //dd($status);
        return view('auth.register', compact('units', 'genders', 'religions', 'cities', 'statuses', 
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

    public function getUnits($uuid)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get('https://api.pewaca.id/api/unit/'.$uuid."/");
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

    public function postRegister(Request $request)
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
            'code' => 'required|uuid',
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

       

        if(isset($request->marriagePhoto) && $request->hasFile('marriagePhoto')){
            $file1 = $request->file('marriagePhoto');
            $fileData_bk = base64_encode(file_get_contents($file1));
        }
        else{  $fileData_bk = "";}
       
        if (isset($request->profile_photo) && $request->hasFile('profile_photo')) {
            $file2 = $request->file('profile_photo');
            $fileData_profile = $file2;  // Directly pass the file object.
        } else {
            $fileData_profile = null;  // or an empty value depending on the API's requirement.
        }
              
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
        //dd($data);
        try {

            $http = Http::withHeaders([
                'Accept' => 'application/json',
            ]);
        
            // Attach file only if it exists
            if (isset($request->profile_photo) && $request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $http->attach('profile_photo', file_get_contents($file->getRealPath()), $file->getClientOriginalName());
            }
        
            // Send POST request
            $response = $http->post('https://api.pewaca.id/api/auth/sign-up/'.$request->code."/", $data);
          
            // $response = Http::withHeaders([
            //     'Accept' => 'application/json',
            // ])->attach('profile_photo', $fileData_profile, $file2->getClientOriginalName() 
            // )->post('https://api.pewaca.id/api/auth/sign-up/'.$request->code."/", $data);

        
            $data_response = json_decode($response->body(), true);

            //dd($data_response);
           
            if ($data_response['success'] == true) {
                session()->flash('status', 'success');
                session()->flash('message', $data_response['data']['message']);
            } else {
                session()->flash('status', 'error');
                session()->flash('message', $data_response['data']['message']);
            }
            return redirect()->route('showRegister', ['uuid' => $request->code]);

        } catch (\Exception $e) {
            session()->flash('status', 'error');
            session()->flash('message', 'Gagal Mengirim Data');
            return redirect()->route('showRegister', ['uuid' => $request->code]);
        }
    }

    public function verified($uuid = null, $token = null)
    {
       //dd($uuid, $token);
        return view('auth.verify', compact('uuid','token'));
    }
    
    public function postVerified(Request $request)
    {
        $request->validate([
            'code' => 'required|uuid',
            'token' => 'required|string'
        ]);

        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get('https://api.pewaca.id/api/auth/verify/'.$request->code."/".$request->token."/");
        $verify_response = json_decode($response->body(), true);
        
        dd($verify_response);
        
        // return redirect()->route('auth.verified');
    }
    
}
