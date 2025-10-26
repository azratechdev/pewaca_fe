<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class HomeController extends Controller
{
  
    public function index()
    {
      
        $user = Session::get('cred');
        $warga = Session::get('warga');
        $residence = Session::get('residence');
        
        \Log::info('=== HOME INDEX DEBUG ===');
        \Log::info('Session Warga Data:', [
            'is_checker' => $warga['is_checker'] ?? 'NOT SET',
            'isreject' => $warga['isreject'] ?? 'NOT SET',
            'full_name' => $warga['full_name'] ?? 'NOT SET',
            'is_checker_type' => isset($warga['is_checker']) ? gettype($warga['is_checker']) : 'NOT SET'
        ]);
        \Log::info('Session User Data:', [
            'is_pengurus' => $user['is_pengurus'] ?? 'NOT SET',
            'email' => $user['email'] ?? 'NOT SET'
        ]);
        
        $stories = $this->getStories();
       
        //dd($replays);
        return view('home.index', compact('user', 'warga', 'residence', 'stories'));
    }

    public function getStories()
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token '.Session::get('token'),
            ])->get(env('API_URL') . '/api/stories/');
            
            // Validasi response
            if (!$response->successful()) {
                Log::error('Get Stories Failed:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return [];
            }
            
            $stories_response = json_decode($response->body(), true);
            
            // Validasi JSON decode berhasil dan key 'data' ada
            if (!$stories_response || !isset($stories_response['data'])) {
                Log::error('Get Stories Invalid Response:', [
                    'body' => $response->body()
                ]);
                return [];
            }
            
            return $stories_response['data'];
        } catch (\Exception $e) {
            Log::error('Get Stories Exception:', [
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    public function getReplays(Request $request)
    {
        $request->validate([
            'story_id' => 'required|integer',
        ]);

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token '.Session::get('token'),
            ])->get(env('API_URL') . '/api/story-replays/?page=1&story_id='.$request->story_id);
            
            // Validasi response
            if (!$response->successful()) {
                Log::error('Get Replays Failed:', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'story_id' => $request->story_id
                ]);
                return response()->json([
                    'error' => 'Gagal mengambil komentar',
                    'html' => '<p class="text-center text-danger">Gagal memuat komentar</p>'
                ], 500);
            }
            
            $replay_response = json_decode($response->body(), true);
            
            // Validasi JSON decode berhasil dan struktur response
            if (!$replay_response || !isset($replay_response['results']) || !is_array($replay_response['results'])) {
                Log::error('Get Replays Invalid Response:', [
                    'body' => $response->body(),
                    'parsed' => $replay_response,
                    'results_type' => isset($replay_response['results']) ? gettype($replay_response['results']) : 'not set'
                ]);
                return response()->json([
                    'error' => 'Response tidak valid',
                    'html' => '<p class="text-center text-danger">Data tidak valid</p>'
                ], 500);
            }

            // Normalize response structure dengan default values
            $data = [
                'results' => $replay_response['results'],
                'next' => $replay_response['next'] ?? null,
                'previous' => $replay_response['previous'] ?? null
            ];
          
            // Render view dengan data
            $html = view('home.comment_default', ['data' => $data])->render();

            return response()->json(['html' => $html]);
            
        } catch (\Exception $e) {
            Log::error('Get Replays Exception:', [
                'error' => $e->getMessage(),
                'story_id' => $request->story_id
            ]);
            return response()->json([
                'error' => 'Terjadi kesalahan',
                'html' => '<p class="text-center text-danger">Terjadi kesalahan</p>'
            ], 500);
        }
    }

    public function getReplaysMore(Request $request)
    {
        $request->validate([
            'story_id' => 'required|integer',
            'url' => 'required|string'
        ]);
        
        try {
            if (str_starts_with($request->url, 'http://')) {
                $url = preg_replace('/^http:/', 'https:', $request->url);
            }
            else{
                $url = $request->url;
            }
            
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token '.Session::get('token'),
            ])->get($url);
            
            // Validasi response
            if (!$response->successful()) {
                Log::error('Get Replays More Failed:', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'url' => $url
                ]);
                return response()->json([
                    'error' => 'Gagal mengambil komentar lainnya',
                    'html' => '<p class="text-center text-danger">Gagal memuat komentar</p>'
                ], 500);
            }
                   
            $replay_response = json_decode($response->body(), true);
            
            // Validasi JSON decode berhasil dan struktur response
            if (!$replay_response || !isset($replay_response['results']) || !is_array($replay_response['results'])) {
                Log::error('Get Replays More Invalid Response:', [
                    'body' => $response->body(),
                    'parsed' => $replay_response,
                    'results_type' => isset($replay_response['results']) ? gettype($replay_response['results']) : 'not set'
                ]);
                return response()->json([
                    'error' => 'Response tidak valid',
                    'html' => '<p class="text-center text-danger">Data tidak valid</p>'
                ], 500);
            }

            // Normalize response structure dengan default values
            $data = [
                'results' => $replay_response['results'],
                'next' => $replay_response['next'] ?? null,
                'previous' => $replay_response['previous'] ?? null
            ];
            
            // Render view dengan data
            $html = view('home.comment_more', ['data' => $data])->render();

            return response()->json(['html' => $html]);
            
        } catch (\Exception $e) {
            Log::error('Get Replays More Exception:', [
                'error' => $e->getMessage(),
                'url' => $request->url
            ]);
            return response()->json([
                'error' => 'Terjadi kesalahan',
                'html' => '<p class="text-center text-danger">Terjadi kesalahan</p>'
            ], 500);
        }
    }

    public function addpost()
    {
        return view('home.addpost');
    }

    public function postStory(Request $request)
    {
        $request->validate([
            'post_picture' => 'nullable|image|mimes:jpeg,jpg,png|max:5120', // max 5MB
            'description' => 'required|string'
        ]);

        try {
            $http = Http::withHeaders([
                'Authorization' => 'Token ' . Session::get('token') // atau coba ganti ke 'Bearer '
            ]);
            // Siapkan multipart data
            $multipart = [
                [
                    'name' => 'story',
                    'contents' => $request->description
                ]
            ];

            // Tambahkan file jika ada
            if ($request->hasFile('post_picture')) {
                $file = $request->file('post_picture');
                $multipart[] = [
                    'name' => 'image',
                    'contents' => fopen($file->getRealPath(), 'r'),
                    'filename' => $file->getClientOriginalName()
                ];
            }

            // Kirim request dengan multipart
            $response = $http->asMultipart()->post(env('API_URL') . '/api/stories/', $multipart);

            $data_response = json_decode($response->body(), true);

            // Log response untuk debugging
            Log::info('Post Story Response:', [
                'status' => $response->status(),
                'body' => $response->body(),
                'parsed' => $data_response
            ]);

            // Validasi response
            if (!$data_response) {
                // Cek apakah error 413 (file terlalu besar)
                if ($response->status() == 413) {
                    Session::flash('flash-message', [
                        'message' => 'Gagal mengirim story: Gambar terlalu besar. Maksimal 5MB.',
                        'alert-class' => 'alert-danger',
                    ]);
                } else {
                    Session::flash('flash-message', [
                        'message' => 'Gagal mengirim story: Response tidak valid dari server (Status: ' . $response->status() . ')',
                        'alert-class' => 'alert-danger',
                    ]);
                }
                return redirect()->route('home');
            }

            // Cek apakah berhasil
            if (isset($data_response['success']) && $data_response['success'] == true) {
                Session::flash('flash-message', [
                    'message' => 'Story berhasil dikirim',
                    'alert-class' => 'alert-success',
                ]);
                return redirect()->route('home');
            } else {
                // Ambil pesan error dari response jika ada
                $errorMsg = 'Gagal mengirim story';
                if (isset($data_response['error'])) {
                    $errorMsg .= ': ' . $data_response['error'];
                } elseif (isset($data_response['message'])) {
                    $errorMsg .= ': ' . $data_response['message'];
                }
                
                Session::flash('flash-message', [
                    'message' => $errorMsg,
                    'alert-class' => 'alert-warning',
                ]);
                return redirect()->route('home');
            }

        } catch (\Exception $e) {
            Session::flash('flash-message', [
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'alert-class' => 'alert-danger',
            ]);
            return redirect()->route('home');
        }
    }
}
