<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hasil Pemilihan - PT HEMITECH KARYA INDONESIA</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/logo.png') }}">
    <link href="{{ asset('assets/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --pewaca-green: #5FA782;
            --pewaca-green-dark: #4a9070;
            --pewaca-dark: #2c3e50;
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

        .result-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            gap: 30px;
            transition: all 0.3s ease;
        }

        .result-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.3);
        }

        .result-card.winner {
            border: 4px solid gold;
            background: linear-gradient(135deg, #fff9e6 0%, #ffffff 100%);
        }

        .rank {
            font-size: 4rem;
            font-weight: 700;
            color: var(--pewaca-green);
            min-width: 80px;
            text-align: center;
        }

        .result-card.winner .rank {
            color: gold;
        }

        .candidate-photo-small {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--pewaca-green);
        }

        .result-card.winner .candidate-photo-small {
            border-color: gold;
        }

        .candidate-info {
            flex: 1;
        }

        .candidate-name {
            font-size: 2rem;
            font-weight: 700;
            color: var(--pewaca-dark);
            margin-bottom: 5px;
        }

        .vote-info {
            font-size: 1.3rem;
            color: #666;
        }

        .vote-count {
            font-size: 3rem;
            font-weight: 700;
            color: var(--pewaca-green);
            text-align: center;
            min-width: 120px;
        }

        .result-card.winner .vote-count {
            color: gold;
        }

        .percentage {
            font-size: 1.4rem;
            color: #666;
            margin-top: 5px;
        }

        .crown {
            font-size: 3rem;
            color: gold;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .btn-back {
            background: white;
            color: var(--pewaca-green);
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            color: var(--pewaca-green);
        }

        @media (max-width: 768px) {
            .header h1 { font-size: 2.2rem; }
            .header p { font-size: 1.2rem; }
            .result-card {
                flex-direction: column;
                text-align: center;
            }
            .rank {
                font-size: 3rem;
            }
            .vote-count {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-chart-bar me-3"></i>Hasil Pemilihan Ketua Paguyuban</h1>
            <p>Transparansi untuk masa depan yang lebih baik</p>
        </div>

        <div class="stats-bar">
            <h3><i class="fas fa-users me-2"></i>Total Suara Masuk: <strong>{{ $totalVotes }}</strong></h3>
        </div>

        @foreach($candidates as $index => $candidate)
        <div class="result-card {{ $index === 0 ? 'winner' : '' }}">
            @if($index === 0)
                <i class="fas fa-crown crown"></i>
            @endif
            
            <div class="rank">#{{ $index + 1 }}</div>
            
            <img src="{{ $candidate->photo }}" alt="{{ $candidate->name }}" class="candidate-photo-small">
            
            <div class="candidate-info">
                <h2 class="candidate-name">{{ $candidate->name }}</h2>
                <p class="vote-info">
                    <i class="fas fa-lightbulb me-2"></i>{{ Str::limit($candidate->visi, 100) }}
                </p>
            </div>
            
            <div class="vote-count">
                <div>{{ $candidate->vote_count }}</div>
                <div class="percentage">
                    {{ $totalVotes > 0 ? number_format(($candidate->vote_count / $totalVotes) * 100, 1) : 0 }}%
                </div>
            </div>
        </div>
        @endforeach

        <div class="text-center mt-4">
            <a href="{{ route('voting.index') }}" class="btn-back">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Halaman Voting
            </a>
        </div>
    </div>
</body>
</html>
