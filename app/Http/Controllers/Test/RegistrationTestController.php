<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RegistrationTestController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_URL', 'https://admin.pewaca.id') . '/api';
    }

    public function index()
    {
        return view('test.registration');
    }

    public function getMasterData(Request $request)
    {
        $type = $request->get('type');
        
        try {
            $endpoint = match($type) {
                'gender' => '/gender/',
                'religions' => '/religions/',
                'family-as' => '/family-as/',
                'education' => '/education/',
                'occupation' => '/ocupation/',
                'marital-statuses' => '/marital-statuses/',
                'cities' => '/cities/',
                default => null
            };

            if (!$endpoint) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid master data type'
                ], 400);
            }

            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get($this->apiBaseUrl . $endpoint);

            $statusCode = $response->status();
            $body = $response->body();
            $data = json_decode($body, true);

            return response()->json([
                'success' => $statusCode === 200,
                'status_code' => $statusCode,
                'data' => $data['data'] ?? $data,
                'raw_response' => $data
            ], $statusCode);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching master data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getResidenceByCode(Request $request)
    {
        $code = $request->get('code');
        
        if (!$code) {
            return response()->json([
                'success' => false,
                'message' => 'Code parameter is required'
            ], 400);
        }

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get($this->apiBaseUrl . '/residence-by-code/' . $code . '/');

            $statusCode = $response->status();
            $body = $response->body();
            $data = json_decode($body, true);

            return response()->json([
                'success' => $statusCode === 200,
                'status_code' => $statusCode,
                'data' => $data['data'] ?? $data,
                'raw_response' => $data
            ], $statusCode);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching residence: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getUnitsByCode(Request $request)
    {
        $code = $request->get('code');
        
        if (!$code) {
            return response()->json([
                'success' => false,
                'message' => 'Code parameter is required'
            ], 400);
        }

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get($this->apiBaseUrl . '/units/code/' . $code . '/');

            $statusCode = $response->status();
            $body = $response->body();
            $data = json_decode($body, true);

            return response()->json([
                'success' => $statusCode === 200,
                'status_code' => $statusCode,
                'data' => $data['data'] ?? $data,
                'raw_response' => $data
            ], $statusCode);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching units: ' . $e->getMessage()
            ], 500);
        }
    }

    public function testRegistration(Request $request)
    {
        try {
            $code = $request->input('code');
            
            $data = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'unit_id' => $request->input('unit_id'),
                'nik' => $request->input('nik'),
                'full_name' => $request->input('full_name'),
                'phone_no' => $request->input('phone_no'),
                'gender_id' => $request->input('gender_id'),
                'date_of_birth' => $request->input('date_of_birth'),
                'religion' => $request->input('religion'),
                'place_of_birth' => $request->input('place_of_birth'),
                'marital_status' => $request->input('marital_status'),
                'occupation' => $request->input('occupation'),
                'education' => $request->input('education'),
                'family_as' => $request->input('family_as'),
                'code' => $code
            ];

            $httpRequest = Http::withHeaders([
                'Accept' => 'application/json',
            ])->asMultipart();

            foreach ($data as $key => $value) {
                $httpRequest = $httpRequest->attach($key, $value);
            }

            if ($request->hasFile('profile_photo')) {
                $httpRequest = $httpRequest->attach(
                    'profile_photo',
                    file_get_contents($request->file('profile_photo')->getRealPath()),
                    $request->file('profile_photo')->getClientOriginalName()
                );
            }

            if ($request->hasFile('marital_photo')) {
                $httpRequest = $httpRequest->attach(
                    'marital_photo',
                    file_get_contents($request->file('marital_photo')->getRealPath()),
                    $request->file('marital_photo')->getClientOriginalName()
                );
            }

            $response = $httpRequest->post($this->apiBaseUrl . '/auth/sign-up/' . $code . '/');

            $statusCode = $response->status();
            $body = $response->body();
            $responseData = json_decode($body, true);

            return response()->json([
                'success' => $statusCode === 201 || $statusCode === 200,
                'status_code' => $statusCode,
                'data' => $responseData,
                'raw_response' => $responseData
            ], $statusCode);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration error: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function testLogin(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($this->apiBaseUrl . '/auth/login/', [
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ]);

            $statusCode = $response->status();
            $body = $response->body();
            $data = json_decode($body, true);

            return response()->json([
                'success' => $statusCode === 200,
                'status_code' => $statusCode,
                'data' => $data,
                'raw_response' => $data
            ], $statusCode);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function testVerify(Request $request)
    {
        try {
            $uidb64 = $request->input('uidb64');
            $token = $request->input('token');

            if (!$uidb64 || !$token) {
                return response()->json([
                    'success' => false,
                    'message' => 'uidb64 and token are required'
                ], 400);
            }

            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get($this->apiBaseUrl . '/auth/verify/' . $uidb64 . '/' . $token . '/');

            $statusCode = $response->status();
            $body = $response->body();
            $data = json_decode($body, true);

            return response()->json([
                'success' => $statusCode === 200,
                'status_code' => $statusCode,
                'data' => $data,
                'raw_response' => $data
            ], $statusCode);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Verification error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function testResendVerification(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($this->apiBaseUrl . '/auth/verify/resend/', [
                'email' => $request->input('email')
            ]);

            $statusCode = $response->status();
            $body = $response->body();
            $data = json_decode($body, true);

            return response()->json([
                'success' => $statusCode === 200,
                'status_code' => $statusCode,
                'data' => $data,
                'raw_response' => $data
            ], $statusCode);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Resend verification error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAllMasterData()
    {
        try {
            $endpoints = [
                'gender' => '/gender/',
                'religions' => '/religions/',
                'family_as' => '/family-as/',
                'education' => '/education/',
                'occupation' => '/ocupation/',
                'marital_statuses' => '/marital-statuses/',
            ];

            $results = [];

            foreach ($endpoints as $key => $endpoint) {
                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                ])->get($this->apiBaseUrl . $endpoint);

                if ($response->successful()) {
                    $data = json_decode($response->body(), true);
                    $results[$key] = $data['data'] ?? $data;
                } else {
                    $results[$key] = [];
                }
            }

            return response()->json([
                'success' => true,
                'data' => $results
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching all master data: ' . $e->getMessage()
            ], 500);
        }
    }
}
