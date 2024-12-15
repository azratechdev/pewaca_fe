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
        ])->get('https://api.pewaca.id/api/stories/');
        $stories_response = json_decode($response->body(), true);
        //dd($stories_response);
        return $stories_response['data'];
    }

    public function getReplays(Request $request)
    {
        $request->validate([
            'story_id' => 'required|integer',
        ]);

        // $response = Http::withHeaders([
        //     'Accept' => 'application/json',
        //     'Authorization' => 'Token '.Session::get('token'),
        // ])->get('https://api.pewaca.id/api/story-replays/?page=1&story_id='.$request->story_id);
        
        // $replay_response = json_decode($response->body(), true);

        $storyId = $request->input('story_id');

        $data = [
            'story_id' => $storyId,
            'comments' => [
                ['user' => 'John Doe', 'comment' => 'This is a test comment.'],
                ['user' => 'Jane Smith', 'comment' => 'Another test comment.']
            ]
        ];

        // Render view dengan data
        $html = view('home.comment_default', $data)->render();

        return response()->json(['html' => $html]);

    }

    public function addpost()
    {
        return view('home.addpost');
    }

    public function postStory(Request $request)
    {
        $request->validate([
            'post_picture' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'description' => 'required|string'
        ]);

        //dd($request->all());

        $data = [
            'story' => $request->description
        ];
        //dd($data);
        try {
            //dd('here');
            $http = Http::withHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Token '.Session::get('token'),
            ]);

            if (isset($request->post_picture) && $request->hasFile('post_picture')) {
                $file = $request->file('post_picture');
                $http->attach('image', file_get_contents($file->getRealPath()), $file->getClientOriginalName());
            }
           
            $response = $http->post('https://api.pewaca.id/api/stories/', $data);

            $data_response = json_decode($response->body(), true);

            //dd($data_response);

            if ($response->successful()) {
                session()->flash('status', 'success');
                session()->flash('message', $data_response['data']['message']);
                return redirect()->route('home');
            } else {
                session()->flash('message', $data_response['data']['message']);
                return redirect()->route('home');
            }
        
        } catch (\Exception $e) {
            session()->flash('status', 'error');
            session()->flash('message', 'Gagal Mengirim Story');
            return redirect()->route('home');
        }
    }
}
