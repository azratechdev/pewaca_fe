<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;


class HomeController extends Controller
{
  
    public function index()
    {
      
        $user = Session::get('cred');
        $warga = Session::get('warga');
        $residence = Session::get('residence');
        $stories = $this->getStories();
       
        //dd($replays);
        return view('home.index', compact('user', 'warga', 'residence', 'stories'));
    }

    public function getStories()
    {
        
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get(env('API_URL') . '/api/stories/');
        $stories_response = json_decode($response->body(), true);
        //dd($stories_response);
        return $stories_response['data'];
    }

    public function getReplays(Request $request)
    {
        $request->validate([
            'story_id' => 'required|integer',
        ]);

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get(env('API_URL') . '/api/story-replays/?page=1&story_id='.$request->story_id);
        
        $replay_response = json_decode($response->body(), true);

        $data = $replay_response;
      
        // Render view dengan data
        $html = view('home.comment_default', ['data' => $data])->render();

        return response()->json(['html' => $html]);

    }

    public function getReplaysMore(Request $request)
    {
        $request->validate([
            'story_id' => 'required|integer',
            'url' => 'required|string'
        ]);
        
        if (str_starts_with($request->url, 'http://')) {
            $url = preg_replace('/^http:/', 'https:', $request->url);
        }
        else{
            $url = $request->url;
        }
        //dd($url);
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Token '.Session::get('token'),
        ])->get($url);
               
        $replay_response = json_decode($response->body(), true);

        $data = $replay_response;
        // Render view dengan data
        $html = view('home.comment_more', ['data' => $data])->render();

        return response()->json(['html' => $html]);

    }

    public function addpost()
    {
        return view('home.addpost');
    }

    public function postStory(Request $request)
    {
        $request->validate([
            'post_picture' => 'nullable|image|mimes:jpeg,jpg,png',
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
            \Log::info('Post Story Response:', [
                'status' => $response->status(),
                'body' => $response->body(),
                'parsed' => $data_response
            ]);

            // Validasi response
            if (!$data_response) {
                Session::flash('flash-message', [
                    'message' => 'Gagal mengirim story: Response tidak valid dari server',
                    'alert-class' => 'alert-danger',
                ]);
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
