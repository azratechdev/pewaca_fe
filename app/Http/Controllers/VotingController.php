<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class VotingController extends Controller
{
    public function index()
    {
        $candidates = Candidate::where('is_active', true)
            ->orderBy('name')
            ->get();

        $totalVotes = Vote::count();

        return view('voting.index', compact('candidates', 'totalVotes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'voter_name' => 'required|string|max:255',
            'house_block' => 'required|string|max:255',
        ], [
            'candidate_id.required' => 'Silakan pilih kandidat',
            'candidate_id.exists' => 'Kandidat tidak valid',
            'voter_name.required' => 'Nama pemilih wajib diisi',
            'house_block.required' => 'Blok rumah wajib diisi',
        ]);

        try {
            DB::beginTransaction();

            $vote = Vote::create([
                'candidate_id' => $request->candidate_id,
                'voter_name' => $request->voter_name,
                'house_block' => $request->house_block,
                'ip_address' => $request->ip(),
            ]);

            $candidate = Candidate::find($request->candidate_id);
            $candidate->increment('vote_count');

            DB::commit();

            Alert::success('Terima Kasih!', 'Vote Anda telah berhasil tersimpan.');
            return redirect()->route('voting.index');

        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan vote. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function results()
    {
        $candidates = Candidate::where('is_active', true)
            ->orderBy('vote_count', 'desc')
            ->get();

        $totalVotes = Vote::count();

        return view('voting.results', compact('candidates', 'totalVotes'));
    }
}
