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
        //code: 1c99af82-cfa0-4d95-8f3e-32d1556bd6ba
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
        ])->get('https://api.pewaca.id/api/unit/{$uuid}/');
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
       
        if(isset($request->marriagePhoto)){
            $file1 = $request->file('marriagePhoto');
            $fileData_bk = base64_encode(file_get_contents($file1));
        }
        else{  $fileData_bk = "";}
       
        if (isset($request->profile_photo)) {
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
   
        try {
          
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->attach(
                'profile_photo', $fileData_profile, $file2->getClientOriginalName()  // This will send the file as multipart data.
            )->post('https://api.pewaca.id/api/auth/sign-up/'.$request->code, $data);

        
            $data_response = json_decode($response->body(), true);
           
            if ($data_response['success'] == true) {
                session()->flash('status', 'success');
                session()->flash('message', $data_response['message']);
            } else {
                session()->flash('status', 'error');
                session()->flash('message', $data_response['message']);
            }
            return redirect()->route('showRegister', ['uuid' => $request->code]);

        } catch (\Exception $e) {
            session()->flash('status', 'error');
            session()->flash('message', 'Gagal Mengirim Data');
            return redirect()->route('showRegister', ['uuid' => $request->code]);
        }
    }

    public function showActivated()
    {
        return view('auth.activated');
    }
    
    public function postActivated(Request $request)
    {
        Session::flash('flash-message', [
            'message' => 'Aktifasi sukses',
            'alert-class' => 'alert-success',
        ]);
        return redirect()->route('home');
    
    }
    
}
