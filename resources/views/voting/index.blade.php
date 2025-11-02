<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pemilihan Ketua Paguyuban - PT HEMITECH KARYA INDONESIA</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/logo.png') }}">
    <link href="{{ asset('assets/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --pewaca-green: #5FA782;
            --pewaca-green-dark: #4a9070;
            --pewaca-dark: #2c3e50;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }

        .header h1 {
            color: var(--pewaca-dark);
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 1.4rem;
        }

        .stats-bar {
            background: var(--pewaca-green);
            color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .stats-bar h3 {
            margin: 0;
            font-size: 1.8rem;
        }

        .candidate-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .candidate-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .candidate-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 50px rgba(95, 167, 130, 0.3);
        }

        .candidate-card.selected {
            border: 4px solid var(--pewaca-green);
            box-shadow: 0 15px 50px rgba(95, 167, 130, 0.5);
        }

        .candidate-photo {
            width: 100%;
            height: 250px;
            object-fit: cover;
            background: linear-gradient(135deg, var(--pewaca-green), var(--pewaca-green-dark));
        }

        .candidate-info {
            padding: 25px;
        }

        .candidate-name {
            font-size: 2rem;
            font-weight: 700;
            color: var(--pewaca-dark);
            margin-bottom: 15px;
        }

        .candidate-label {
            font-weight: 600;
            color: var(--pewaca-green);
            margin-top: 15px;
            margin-bottom: 5px;
            font-size: 1.2rem;
        }

        .candidate-text {
            color: #666;
            line-height: 1.6;
            margin-bottom: 10px;
            font-size: 1.15rem;
        }

        .candidate-bio {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
            font-style: italic;
            color: #555;
            font-size: 1.1rem;
        }

        .select-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--pewaca-green);
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            display: none;
            font-size: 1.1rem;
        }

        .candidate-card.selected .select-badge {
            display: block;
        }

        .voter-form {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            display: none;
        }

        .voter-form.show {
            display: block;
        }

        .voter-form h3 {
            color: var(--pewaca-dark);
            font-size: 2.2rem;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: var(--pewaca-dark);
            margin-bottom: 10px;
            font-size: 1.3rem;
        }

        .form-control {
            width: 100%;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--pewaca-green);
            box-shadow: 0 0 0 3px rgba(95, 167, 130, 0.1);
        }

        .btn-submit {
            background: var(--pewaca-green);
            color: white;
            padding: 18px 40px;
            border: none;
            border-radius: 50px;
            font-size: 1.3rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: var(--pewaca-green-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(95, 167, 130, 0.3);
        }

        .btn-cancel {
            background: #dc3545;
            color: white;
            padding: 18px 40px;
            border: none;
            border-radius: 50px;
            font-size: 1.3rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 10px;
        }

        .btn-cancel:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(220, 53, 69, 0.3);
        }

        .selected-info {
            background: #e8f5e9;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid var(--pewaca-green);
        }

        .selected-info h4 {
            color: var(--pewaca-green);
            margin-bottom: 5px;
            font-size: 1.4rem;
        }

        .selected-info p {
            margin: 0;
            color: #333;
            font-weight: 600;
            font-size: 1.3rem;
        }

        @media (max-width: 768px) {
            .header h1 { font-size: 2.2rem; }
            .header p { font-size: 1.2rem; }
            .candidate-name { font-size: 1.7rem; }
            .candidate-text { font-size: 1.05rem; }
            .voter-form { padding: 25px; }
            .candidate-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    @include('sweetalert::alert')

    <div class="container">
        <div class="header">
            <h1><i class="fas fa-vote-yea me-3"></i>Pemilihan Ketua Paguyuban</h1>
            <p>Gunakan hak pilih Anda dengan bijak untuk masa depan yang lebih baik</p>
        </div>

        <div class="stats-bar">
            <h3><i class="fas fa-users me-2"></i>Total Suara: <strong>{{ $totalVotes }}</strong></h3>
        </div>

        <div id="candidateSection">
            <div class="candidate-grid">
                @foreach($candidates as $candidate)
                <div class="candidate-card" data-id="{{ $candidate->id }}" data-name="{{ $candidate->name }}" onclick="selectCandidate({{ $candidate->id }}, '{{ $candidate->name }}')">
                    <span class="select-badge"><i class="fas fa-check-circle me-2"></i>Dipilih</span>
                    <img src="{{ $candidate->photo }}" alt="{{ $candidate->name }}" class="candidate-photo">
                    <div class="candidate-info">
                        <h2 class="candidate-name">{{ $candidate->name }}</h2>
                        
                        <div class="candidate-label">
                            <i class="fas fa-lightbulb me-2"></i>Visi:
                        </div>
                        <p class="candidate-text">{{ $candidate->visi }}</p>
                        
                        <div class="candidate-label">
                            <i class="fas fa-tasks me-2"></i>Misi:
                        </div>
                        <p class="candidate-text" style="white-space: pre-line;">{{ $candidate->misi }}</p>
                        
                        @if($candidate->bio)
                        <div class="candidate-bio">
                            <i class="fas fa-user-circle me-2"></i>{{ $candidate->bio }}
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="voter-form" id="voterForm">
            <h3><i class="fas fa-edit me-2"></i>Data Pemilih</h3>
            
            <div class="selected-info">
                <h4>Kandidat yang Anda Pilih:</h4>
                <p id="selectedCandidateName"></p>
            </div>

            <form action="{{ route('voting.store') }}" method="POST" id="voteForm">
                @csrf
                <input type="hidden" name="candidate_id" id="candidate_id">
                
                <div class="form-group">
                    <label for="voter_name"><i class="fas fa-user me-2"></i>Nama Pemilih *</label>
                    <input type="text" class="form-control" id="voter_name" name="voter_name" 
                           placeholder="Masukkan nama lengkap Anda" required value="{{ old('voter_name') }}">
                    @error('voter_name')
                        <div class="text-danger mt-2" style="font-size: 1.1rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="house_block"><i class="fas fa-home me-2"></i>Blok Rumah *</label>
                    <input type="text" class="form-control" id="house_block" name="house_block" 
                           placeholder="Contoh: A-12, B-5, C-23" required value="{{ old('house_block') }}">
                    @error('house_block')
                        <div class="text-danger mt-2" style="font-size: 1.1rem;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane me-2"></i>Kirim Suara
                </button>
                <button type="button" class="btn-cancel" onclick="cancelVote()">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
            </form>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('voting.results') }}" class="btn btn-light btn-lg" style="border-radius: 50px; padding: 15px 40px; font-size: 1.2rem;">
                <i class="fas fa-chart-bar me-2"></i>Lihat Hasil Voting
            </a>
        </div>
    </div>

    <script>
        let selectedCandidateId = null;

        function selectCandidate(candidateId, candidateName) {
            document.querySelectorAll('.candidate-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            const selectedCard = document.querySelector(`[data-id="${candidateId}"]`);
            selectedCard.classList.add('selected');
            
            selectedCandidateId = candidateId;
            document.getElementById('candidate_id').value = candidateId;
            document.getElementById('selectedCandidateName').textContent = candidateName;
            
            document.getElementById('candidateSection').style.display = 'none';
            document.getElementById('voterForm').classList.add('show');
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function cancelVote() {
            document.getElementById('voterForm').classList.remove('show');
            document.getElementById('candidateSection').style.display = 'block';
            document.querySelectorAll('.candidate-card').forEach(card => {
                card.classList.remove('selected');
            });
            selectedCandidateId = null;
            document.getElementById('voteForm').reset();
        }
    </script>
</body>
</html>
