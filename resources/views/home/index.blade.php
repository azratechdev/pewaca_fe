@extends('layouts.residence.basetemplate')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      background: linear-gradient(to bottom, #f0f4f8 0%, #e2e8f0 100%);
      min-height: 100vh;
    }

    .modern-container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 20px;
      width: 100%;
    }

    @media (min-width: 1920px) {
      .modern-container {
        max-width: 1600px;
      }
    }

    /* Header Section */
    .header-section {
      background: white;
      border-radius: 16px;
      padding: 20px 24px;
      margin-bottom: 24px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
      display: flex;
      justify-content: space-between;
      align-items: center;
      animation: slideDown 0.5s ease-out;
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .logo-section img {
      height: 48px;
      width: auto;
      transition: transform 0.3s ease;
    }

    .logo-section img:hover {
      transform: scale(1.05);
    }

    .add-post-btn {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      width: 48px;
      height: 48px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      border: none;
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
      transition: all 0.3s ease;
      color: white;
      text-decoration: none;
    }

    .add-post-btn:hover {
      transform: translateY(-2px) scale(1.05);
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
      color: white;
    }

    /* Election Banner */
    .election-banner {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 28px;
      border-radius: 16px;
      margin-bottom: 24px;
      text-align: center;
      box-shadow: 0 8px 24px rgba(102, 126, 234, 0.25);
      animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: scale(0.95);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    .election-banner h5 {
      margin: 0 0 10px 0;
      font-weight: 700;
      font-size: 1.25rem;
      letter-spacing: 0.3px;
    }

    .election-banner p {
      margin: 6px 0;
      font-size: 0.95rem;
      opacity: 0.95;
    }

    .countdown {
      font-size: 1.5rem;
      font-weight: 700;
      margin: 16px 0;
      color: #ffd700;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .btn-vote {
      background: white;
      color: #667eea;
      border: none;
      padding: 12px 32px;
      border-radius: 25px;
      font-weight: 600;
      margin-top: 12px;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-block;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-vote:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
      color: #667eea;
      text-decoration: none;
    }

    /* Story Card */
    .story-card {
      background: white;
      border-radius: 16px;
      padding: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
      transition: all 0.3s ease;
      animation: fadeInUp 0.5s ease-out backwards;
      border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .story-card:hover {
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      transform: translateY(-4px);
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Story animation delays */
    .story-card:nth-child(1) { animation-delay: 0.1s; }
    .story-card:nth-child(2) { animation-delay: 0.2s; }
    .story-card:nth-child(3) { animation-delay: 0.3s; }
    .story-card:nth-child(4) { animation-delay: 0.15s; }
    .story-card:nth-child(5) { animation-delay: 0.25s; }
    .story-card:nth-child(6) { animation-delay: 0.35s; }

    /* Profile Header */
    .profile-header {
      display: flex;
      align-items: center;
      margin-bottom: 16px;
    }

    .profile-picture {
      width: 52px;
      height: 52px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #f3f4f6;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .profile-picture:hover {
      transform: scale(1.1);
    }

    .profile-info {
      margin-left: 14px;
      flex: 1;
    }

    .profile-name {
      font-weight: 700;
      font-size: 15px;
      color: #1f2937;
      margin: 0 0 4px 0;
    }

    .profile-time {
      font-size: 13px;
      color: #9ca3af;
      margin: 0;
    }

    /* Story Content */
    .story-text {
      color: #374151;
      line-height: 1.6;
      margin-bottom: 16px;
      font-size: 15px;
    }

    .story-image {
      width: 100%;
      border-radius: 12px;
      margin-bottom: 16px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      transition: transform 0.3s ease;
    }

    .story-image:hover {
      transform: scale(1.02);
    }

    .fixed-img {
      width: 100%;
      max-height: 400px;
      object-fit: cover;
      border-radius: 12px;
      margin: 12px 0;
    }

    .image-placeholder {
      display: none;
      padding: 24px;
      background: #f9fafb;
      border-radius: 12px;
      text-align: center;
      color: #9ca3af;
      margin: 12px 0;
    }

    .image-placeholder i {
      font-size: 32px;
      margin-bottom: 8px;
      opacity: 0.5;
    }

    /* Action Buttons */
    .action-buttons {
      display: flex;
      gap: 20px;
      padding-top: 12px;
      border-top: 1px solid #f3f4f6;
    }

    .action-btn {
      color: #667eea;
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      padding: 8px 16px;
      border-radius: 8px;
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .action-btn:hover {
      background: #f3f4f6;
      color: #764ba2;
      text-decoration: none;
      transform: translateY(-1px);
    }

    /* Comment Section */
    .comment-section {
      margin-top: 20px;
      padding-top: 20px;
      border-top: 2px solid #f3f4f6;
      animation: slideDown 0.3s ease-out;
    }

    .comment-input-wrapper {
      display: flex;
      gap: 12px;
      margin-bottom: 20px;
      align-items: flex-start;
    }

    .comment-input-wrapper img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #f3f4f6;
    }

    .comment-form {
      flex: 1;
      display: flex;
      gap: 10px;
      align-items: flex-start;
    }

    .comment-textarea {
      flex: 1;
      border: 2px solid #e5e7eb;
      border-radius: 12px;
      padding: 12px 16px;
      font-size: 14px;
      resize: none;
      transition: all 0.3s ease;
      font-family: 'Inter', sans-serif;
      background: #f9fafb;
    }

    .comment-textarea:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
      background: white;
    }

    .comment-submit-btn {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      border-radius: 10px;
      width: 44px;
      height: 44px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      transition: all 0.3s ease;
      box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    .comment-submit-btn:hover {
      transform: translateY(-2px) scale(1.05);
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    /* Read More Link */
    .read-more {
      color: #667eea;
      text-decoration: none;
      font-weight: 500;
      font-size: 14px;
      transition: color 0.2s ease;
    }

    .read-more:hover {
      color: #764ba2;
      text-decoration: underline;
    }

    /* Waiting Verification */
    .waiting-verification {
      max-width: 480px;
      margin: 80px auto;
      text-align: center;
      background: white;
      padding: 48px;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      animation: fadeIn 0.6s ease-out;
    }

    .waiting-verification img {
      margin-bottom: 24px;
      transition: transform 0.3s ease;
    }

    .waiting-verification img:hover {
      transform: scale(1.05);
    }

    .waiting-verification h1 {
      font-size: 20px;
      font-weight: 700;
      color: #1f2937;
      margin: 20px 0 12px 0;
    }

    .waiting-verification p {
      color: #6b7280;
      font-size: 15px;
      line-height: 1.6;
    }

    /* Responsive */
    @media (max-width: 768px) {
      body {
        background: linear-gradient(to bottom, #f0f4f8 0%, #e2e8f0 100%);
      }

      .modern-container {
        padding: 12px;
        max-width: 100%;
      }

      .header-section {
        padding: 14px 16px;
        margin-bottom: 16px;
        border-radius: 12px;
      }

      .logo-section img {
        height: 40px;
      }

      .add-post-btn {
        width: 44px;
        height: 44px;
      }

      .story-card {
        padding: 16px;
        margin-bottom: 14px;
        border-radius: 14px;
      }

      .election-banner {
        padding: 20px 16px;
        border-radius: 14px;
      }

      .election-banner h5 {
        font-size: 1.1rem;
      }

      .countdown {
        font-size: 1.3rem;
      }

      .btn-vote {
        padding: 10px 24px;
        font-size: 14px;
      }

      .profile-picture {
        width: 44px;
        height: 44px;
        border: 2px solid #f3f4f6;
      }

      .profile-name {
        font-size: 14px;
      }

      .profile-time {
        font-size: 12px;
      }

      .story-text {
        font-size: 14px;
        line-height: 1.5;
      }

      .fixed-img {
        border-radius: 10px;
        max-height: 350px;
      }

      .action-buttons {
        gap: 16px;
      }

      .action-btn {
        font-size: 13px;
        padding: 6px 12px;
      }

      .comment-textarea {
        font-size: 13px;
        padding: 10px 14px;
      }

      .comment-submit-btn {
        width: 40px;
        height: 40px;
        min-width: 40px;
      }

      .comment-submit-btn i {
        font-size: 14px;
      }

      .waiting-verification {
        margin: 40px auto;
        padding: 32px 20px;
        border-radius: 16px;
      }

      .waiting-verification h1 {
        font-size: 18px;
      }

      .waiting-verification p {
        font-size: 14px;
      }

      .empty-state {
        padding: 40px 16px;
      }

      .empty-state i {
        font-size: 40px;
      }

      .empty-state h3 {
        font-size: 16px;
      }
    }

    /* Extra small devices (phones, less than 375px) */
    @media (max-width: 375px) {
      .modern-container {
        padding: 8px;
      }

      .header-section {
        padding: 12px 14px;
      }

      .logo-section img {
        height: 36px;
      }

      .add-post-btn {
        width: 40px;
        height: 40px;
      }

      .story-card {
        padding: 14px;
        margin-bottom: 12px;
      }

      .election-banner {
        padding: 18px 14px;
      }

      .election-banner h5 {
        font-size: 1rem;
      }

      .countdown {
        font-size: 1.2rem;
      }

      .profile-picture {
        width: 40px;
        height: 40px;
      }

      .profile-name {
        font-size: 13px;
      }

      .profile-time {
        font-size: 11px;
      }

      .story-text {
        font-size: 13px;
      }

      .comment-textarea {
        font-size: 12px;
        padding: 8px 12px;
      }

      .comment-submit-btn {
        width: 36px;
        height: 36px;
      }

      .waiting-verification {
        margin: 30px auto;
        padding: 24px 16px;
      }
    }

    /* Touch-friendly improvements */
    @media (hover: none) and (pointer: coarse) {
      .action-btn {
        padding: 10px 16px;
        min-height: 44px;
      }

      .add-post-btn {
        min-width: 48px;
        min-height: 48px;
      }

      .comment-submit-btn {
        min-width: 44px;
        min-height: 44px;
      }
    }

    /* Loading State */
    .loading {
      text-align: center;
      padding: 40px;
      color: #9ca3af;
    }

    .loading i {
      font-size: 32px;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 60px 20px;
      background: white;
      border-radius: 16px;
      margin: 20px 0;
    }

    .empty-state i {
      font-size: 48px;
      color: #d1d5db;
      margin-bottom: 16px;
    }

    .empty-state h3 {
      font-size: 18px;
      color: #6b7280;
      margin: 0;
    }
</style>

@php
use Carbon\Carbon;
$isPengurus = $user['is_pengurus'] ?? false;
$isChecker = $warga['is_checker'] ?? false;
@endphp

@if (!$isPengurus && !$isChecker)
<div class="container">
    <div class="waiting-verification">
        <img alt="Pewaca logo" height="80" src="{{ asset('assets/plugins/images/mainlogo.png') }}" width="140"/>
        <img alt="Illustration of a document with a clock" height="180" src="{{ asset('assets/plugins/images/verified-wait.jpeg') }}" width="180"/>
        <h1>Pendaftaran menunggu di verifikasi pengurus</h1>
        <p>Mohon menunggu untuk proses verifikasi oleh pengurus</p>
    </div>
</div>
@else

<div class="modern-container">
    <!-- Header Section -->
    <div class="header-section">
        <div class="logo-section">
            <img alt="Waca Logo" src="{{ asset('assets/plugins/images/mainlogo.png') }}"/>
            <div style="font-size: 18px; color: #374151; margin-top: 6px; font-weight: 600;">
                {{ $residence['name'] ?? 'Residence' }}
            </div>
        </div>
        <a href="{{ route('addpost') }}" class="add-post-btn">
            <i class="fas fa-plus"></i>
        </a>
    </div>

    @php
        $residence = session('residence');
    @endphp
    
    @if($residence && $residence['id'] == 3)
    <div class="election-banner">
        <h5><i class="fas fa-bullhorn"></i> PEMILIHAN KETUA PAGUYUBAN</h5>
        <p>Teras Country Periode 2025 - 2029</p>
        <div class="countdown" id="countdown">
            <i class="fas fa-clock"></i> Menghitung waktu...
        </div>
        <p style="font-size: 0.9rem; margin-top: 8px; opacity: 0.95;">Gunakan hak pilih Anda untuk masa depan yang lebih baik!</p>
        <a href="{{ route('voting.index') }}" class="btn-vote">
            <i class="fas fa-vote-yea"></i> Vote Sekarang
        </a>
    </div>
    @endif

    @include('layouts.elements.flash')
          
    <!-- Stories Feed -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3 items-start">
        @forelse($stories as $story)
            @if(isset($story['warga']) && !empty($story['warga']))
            <div class="story-card">
                <!-- Profile Header -->
                <div class="profile-header">
                    <img 
                        alt="Foto profil {{ $story['warga']['full_name'] ?? 'Pengguna' }}" 
                        class="profile-picture" 
                        src="{{ $story['warga']['profile_photo'] ?? asset('assets/plugins/images/default-avatar.png') }}" 
                        onerror="this.src='{{ asset('assets/plugins/images/default-avatar.png') }}'; this.onerror=null;"
                    />
                    <div class="profile-info">
                        <p class="profile-name">{{ $story['warga']['full_name'] ?? 'Pengguna' }}</p>
                        <p class="profile-time">
                            <i class="far fa-clock"></i> {{ Carbon::parse($story['created_on'])->format('d M Y H:i') }}
                        </p>
                    </div>
                </div>
        
                <!-- Story Content -->
                <div class="story-text">
                    <div class="story-default{{ $story['id'] }}" style="display: block;">
                        {{ Str::limit($story['story'], 150) }}
                    </div>
                    <div class="story-full{{ $story['id'] }}" style="display: none;">
                        {{ $story['story'] }}
                    </div>
                    @if(Str::length($story['story']) > 150)
                        <a href="javascript:void(0)" class="toggle-story read-more" data-id="{{ $story['id'] }}">
                            selengkapnya
                        </a>
                    @endif
                </div>

                @if(!empty($story['image']))
                    <img 
                        alt="Gambar dari {{ $story['warga']['full_name'] ?? 'Pengguna' }}" 
                        class="fixed-img" 
                        src="{{ $story['image'] }}" 
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                    />
                    <div class="image-placeholder">
                        <i class="fas fa-image"></i>
                        <p>Gambar tidak tersedia</p>
                    </div>
                @endif
                
                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="javascript:void(0)" class="toggle-comment action-btn" data-id="{{ $story['id'] }}" data-total-comments="{{ $story['total_replay'] ?? 0 }}">
                        <i class="far fa-comment-dots"></i> Comment <span class="comment-count-{{ $story['id'] }}">({{ $story['total_replay'] ?? 0 }})</span>
                    </a>
                </div>
                
                <!-- Comment Section -->
                <div class="comment-full{{ $story['id'] }}" style="display:none;">
                    <div class="comment-section">
                        <div class="comment-input-wrapper">
                            <img 
                                alt="Foto profil Anda" 
                                src="{{ $warga['profile_photo'] }}" 
                                onerror="this.src='{{ asset('assets/plugins/images/default-avatar.png') }}'; this.onerror=null;"
                            />
                            <form id="form-comment{{ $story['id'] }}" class="comment-form" enctype="multipart/form-data">
                                <input type="hidden" id="storyid{{ $story['id'] }}" value="{{ $story['id'] }}" />
                                <textarea id="story-comment{{ $story['id'] }}" class="comment-textarea" rows="2" placeholder="Tulis komentar..." required></textarea>
                                <button data-id="{{ $story['id'] }}" class="comment-submit-btn send-comment" type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                        <div class="comment-show{{ $story['id'] }}">
                            @include('home.comment')
                        </div>
                    </div>
                </div>

                <div class="like-full{{ $story['id'] }}" style="display:none;">
                    @for ($i = 0; $i < 5; $i++)
                    <div class="flex items-left max-w-full mb-2">
                        <img 
                            alt="Foto profil {{ $story['warga']['full_name'] ?? 'Pengguna' }}" 
                            class="profile-picture" 
                            style="width: 36px; height: 36px;"
                            src="{{ $story['warga']['profile_photo'] ?? asset('assets/plugins/images/default-avatar.png') }}" 
                            onerror="this.src='{{ asset('assets/plugins/images/default-avatar.png') }}'; this.onerror=null;"
                        />
                        <div class="ml-4">
                            <div class="text-gray-900 font-bold" style="font-size: 14px;">
                                {{ $story['warga']['full_name'] ?? 'Pengguna' }}
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
            @endif
        @empty
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>Belum ada cerita untuk ditampilkan</h3>
            </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

// Function to update comment count
function updateCommentCount(storyId, count) {
    $('.comment-count-' + storyId).text('(' + count + ')');
    // Update the data attribute to maintain the count
    $('.toggle-comment[data-id="' + storyId + '"]').attr('data-total-comments', count);
}

// Function to get current comment count from data attribute
function getCommentCount(storyId) {
    return parseInt($('.toggle-comment[data-id="' + storyId + '"]').attr('data-total-comments') || 0);
}

$(document).ready(function () {
    $(document).on("click", ".send-comment", function() {
        const formid = $(this).attr('data-id');
        
        $('#form-comment'+formid).off('submit').on('submit', function (e) {
            e.preventDefault();
            const token = '{{ session::get('token') }}';
            const storyId = $('#storyid'+formid).val();
            const commentText = $('#story-comment'+formid).val();
        
            const fullName = '{{ session()->get('warga.full_name') }}';
            const profile =  '{{ session()->get('warga.profile_photo') }}';
            const wargaData = { 'full_name': fullName};
                
            if (!commentText.trim()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Komentar tidak boleh kosong!',
                    confirmButtonColor: '#667eea'
                });
                return;
            }

            $.ajax({
                url: '{{ env('API_URL') }}/api/story-replays/',
                type: 'POST',
                cache: false,
                headers: {
                    'accept': 'application/json',
                    'Authorization': `Token ${token}`,
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify({
                    story: storyId,
                    replay: commentText,
                    warga: wargaData
                }),
                success: function (response) {
                    if (response.success) {
                        $('#story-comment'+formid).val('');
                        const storyId = formid
                        $.ajax({
                            url: "{{ route('getReplays') }}",
                            method: "POST",
                            cache: false,
                            data: {
                                story_id: storyId,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (response) {
                                if (response.html) {
                                    $('.comment-show'+storyId).html(response.html);
                                    // Increment comment count by 1 after successful submit
                                    const currentCount = getCommentCount(storyId);
                                    updateCommentCount(storyId, currentCount + 1);
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error('Error fetching comments:', xhr.responseText);
                            }
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('API Error:', xhr.status, xhr.responseText);
                    let errorMsg = 'Gagal mengirim komentar. ';
                    try {
                        const errorData = JSON.parse(xhr.responseText);
                        if (errorData.error) {
                            errorMsg += errorData.error;
                        } else {
                            errorMsg += 'Silakan coba lagi.';
                        }
                    } catch (e) {
                        errorMsg += xhr.status ? `Error ${xhr.status}` : 'Silakan coba lagi.';
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMsg,
                        confirmButtonColor: '#667eea'
                    });
                }
            });
        });
    });    
});

$(document).ready(function () {
    $(document).on("click", ".toggle-story", function() {
        const dataId = $(this).attr("data-id");
        const targetDiv1 = $(`.story-default${dataId}`);
        const targetDiv2 = $(`.story-full${dataId}`);
       
        if (targetDiv1.css("display") === "block" && $(this).text().trim() === 'selengkapnya') {
            targetDiv2.css("display", "block");
            targetDiv1.css("display", "none"); 
            $(this).text('lebih sedikit');
        } else {
            targetDiv1.css("display", "block");
            targetDiv2.css("display", "none");
            $(this).text('selengkapnya');
        }
    });

    $(document).on("click", ".toggle-comment", function() {
        const dataId = $(this).attr("data-id");
        const targetDiv = $(`.comment-full${dataId}`);
        const targetOther = $(`.like-full${dataId}`);
       
        if (targetDiv.css("display") === "none") {
            targetDiv.css("display", "block");
            targetOther.css("display", "none");
            const storyId = dataId
            fetchComments(storyId);
        } else {
            targetDiv.css("display", "none");
        }
    });

    $(document).on("click", ".toggle-like", function() {
        const dataId = $(this).attr("data-id");
        const targetDiv = $(`.like-full${dataId}`);
        const targetOther = $(`.comment-full${dataId}`);
       
        if (targetDiv.css("display") === "none") {
            targetDiv.css("display", "block");
            targetOther.css("display", "none");
        } else {
            targetDiv.css("display", "none");
        }
    });

    function fetchComments(storyId) {
        $.ajax({
            url: "{{ route('getReplays') }}",
            method: "POST",
            cache: false,
            data: {
                story_id: storyId,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                if (response.html) {
                    $('.comment-show'+storyId).html(response.html);
                    // Keep existing counter from backend, don't change
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
});

$(document).ready(function () {
    $(document).on("click", ".load-more", function() {
        const storyId = $(this).attr("data-id");
        const url = $(this).attr("data-next");

        $.ajax({
            url: "{{ route('getReplaysMore') }}",
            method: "POST",
            data: {
                story_id: storyId,
                url : url,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                if (response.html) {
                    $('.comment-more'+storyId).append(response.html);
                    // Keep existing counter, don't change on load more
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});

// Election Countdown Timer
function updateCountdown() {
    const countdownElement = document.getElementById('countdown');
    
    // Guard: Only run if countdown element exists
    if (!countdownElement) {
        return;
    }

    const electionDate = new Date('2025-12-31 23:59:59').getTime();
    const now = new Date().getTime();
    const distance = electionDate - now;

    if (distance < 0) {
        countdownElement.innerHTML = '<i class="fas fa-check-circle"></i> Pemilihan Sedang Berlangsung!';
        return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

    let countdownText = '<i class="fas fa-clock"></i> ';
    
    if (days > 0) {
        countdownText += days + ' Hari ';
    }
    if (hours > 0 || days > 0) {
        countdownText += hours + ' Jam ';
    }
    countdownText += minutes + ' Menit';

    countdownElement.innerHTML = countdownText;
}

updateCountdown();
setInterval(updateCountdown, 60000);

</script>
@endif
@endsection
