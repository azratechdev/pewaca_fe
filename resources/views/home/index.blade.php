@extends('layouts.residence.basetemplate')
@section('content')
<style>
    .election-banner {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 20px;
      border-radius: 15px;
      margin-bottom: 20px;
      text-align: center;
      box-shadow: 0 5px 20px rgba(102, 126, 234, 0.3);
    }

    .election-banner h5 {
      margin: 0 0 8px 0;
      font-weight: 700;
      font-size: 1.1rem;
    }

    .election-banner p {
      margin: 5px 0;
      font-size: 0.9rem;
    }

    .countdown {
      font-size: 1.4rem;
      font-weight: 700;
      margin: 12px 0;
      color: #ffd700;
    }

    .btn-vote {
      background: white;
      color: #667eea;
      border: none;
      padding: 10px 25px;
      border-radius: 25px;
      font-weight: 600;
      margin-top: 10px;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-block;
    }

    .btn-vote:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      color: #667eea;
      text-decoration: none;
    }
</style>
@php
use Carbon\Carbon;
$isPengurus = $user['is_pengurus'] ?? false;
$isChecker = $warga['is_checker'] ?? false;
@endphp
@if (!$isPengurus && !$isChecker)
<div class="container">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-center">
            <div class="max-w-sm w-full text-center">
                <img alt="Pewaca logo" class="mx-auto mt-4 mb-20" height="120" src="{{ asset('assets/plugins/images/mainlogo.png') }}" width="170"/>
                <div class="mb-10">
                    <img alt="Illustration of a document with a clock" class="mx-auto" height="200" src="{{ asset('assets/plugins/images/verified-wait.jpeg') }}" width="200"/>
                </div>
                <div>
                    <h1 class="text-xl font-semibold mb-2">
                    Pendaftaran menunggu di verifikasi pengurus
                    </h1>
                    <p class="text-gray-600">
                    Mohon menunggu untuk proses verifikasi oleh pengurus
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@else

<div class="container">
    <div class="container mx-auto">
       

        <div class="flex justify-between items-center" style="padding-top: 25px;">
            <div class="flex items-center">
                <img alt="Waca Logo" height="120"  width="170" src="{{ asset('assets/plugins/images/mainlogo.png') }}"/>
            </div>
            <a href="{{ route('addpost') }}" class="rounded-full border border-green-600 bg-green-600 w-10 h-10 flex items-center justify-center">
                <i class="fas fa-plus text-white"></i>
            </a>
        </div>
        <br>

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
            <p style="font-size: 0.85rem; margin-top: 5px;">Gunakan hak pilih Anda untuk masa depan yang lebih baik!</p>
            <a href="{{ route('voting.index') }}" class="btn-vote">
                <i class="fas fa-vote-yea"></i> Vote Sekarang
            </a>
        </div>
        @endif

        {{-- @if(empty($stories)) --}}
            @include('layouts.elements.flash')
        {{-- @endif --}}
              
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3">
            @foreach($stories as $story)
            @if(isset($story['warga']) && !empty($story['warga']))
            <div class="w-full max-w-full bg-white overflow-hidden" style="border-bottom: 0.5px solid #a7a7a7;">
                <!-- Header Section -->
                <div class="flex items-center">
                    <img 
                        alt="Foto profil {{ $story['warga']['full_name'] ?? 'Pengguna' }}" 
                        class="profile-picture rounded-full" 
                        src="{{ $story['warga']['profile_photo'] ?? asset('assets/plugins/images/default-avatar.png') }}" 
                        onerror="this.src='{{ asset('assets/plugins/images/default-avatar.png') }}'; this.onerror=null;"
                    />
                    <div class="ml-4">
                        <div class="text-gray-900 font-bold">
                            {{ $story['warga']['full_name'] ?? 'Pengguna' }}
                        </div>
                        <div class="text-gray-600 text-sm">
                            {{ Carbon::parse($story['created_on'])->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>
        
                <!-- Content Section -->
                <div class="pb-4 mt-2">
                    <div class="items-center">
                        <p class="text-gray-900 text-justify">
                            <div class="story-default{{ $story['id'] }}" style="display: block;">
                                {{ Str::limit($story['story'], 40) }}
                            </div>
                            <div class="story-full{{ $story['id'] }}" style="display: none;">
                                {{ $story['story'] }}
                            </div>
                            @if(Str::length($story['story']) > 40)
                                <a href="javascript:void(0)" class="toggle-story text-green-500" data-id="{{ $story['id'] }}">selengkapnya</a>
                            @endif
                        </p>
                        <br/>
                        @if(!empty($story['image']))
                            <img 
                                alt="Gambar dari {{ $story['warga']['full_name'] ?? 'Pengguna' }}" 
                                class="fixed-img" 
                                src="{{ $story['image'] }}" 
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='block';"
                            />
                            <div style="display:none; padding: 20px; background: #f5f5f5; border-radius: 8px; text-align: center; color: #999;">
                                <i class="fas fa-image fa-2x mb-2"></i>
                                <p>Gambar tidak tersedia</p>
                            </div>
                            <br/>
                        @endif
                    </div>   
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <a href="javascript:void(0)" class="toggle-comment text-green-500" data-id="{{ $story['id'] }}"><i class="bi bi-chat"></i> Comment</a> 
                        </div>
                        {{-- <div class="flex items-center">
                            <a href="javascript:void(0)" class="toggle-like text-green-500" data-id="{{ $story['id'] }}"> Like {{ $story['total_like'] }}</a>
                        </div> --}}
                    </div>
                </div>
                
                <div class="comment-full{{ $story['id'] }}" style="display:none;">
                    <div class="flex items-left max-w-full">
                        <img 
                            alt="Foto profil Anda" 
                            class="profile-picture rounded-full" 
                            style="width: 36px; height: 36px;"
                            src="{{ $warga['profile_photo'] }}" 
                            onerror="this.src='{{ asset('assets/plugins/images/default-avatar.png') }}'; this.onerror=null;"
                        />
                        <div class="ml-4 col-md-10 col-10 mb-2 input-comment" style="font-size: 12px;">
                            <form id="form-comment{{ $story['id'] }}" enctype="multipart/form-data" style="display: flex; align-items: stretch; gap: 8px;">
                                <input type="hidden" id="storyid{{ $story['id'] }}" value="{{ $story['id'] }}" />
                                <textarea id="story-comment{{ $story['id'] }}" class="form-control border rounded" style="font-size: 12px; flex: 1;" placeholder="Tulis Komentar" required></textarea>
                                <button data-id="{{ $story['id'] }}" class="btn btn-xs btn-success send-comment" type="submit" style="font-size: 12px;">
                                    <i class="fa fa-paper-plane fa-2x" aria-hidden="true"></i>
                                </button>
                            </form>
                        </div>
                        {{-- <div class="ml-4 col-md-9 col-9 mb-2 input-comment" style="font-size: 12px;">
                            <form id="form-comment{{ $story['id'] }}" enctype="multipart/form-data">
                                <input type="hidden" id="storyid{{ $story['id'] }}" value="{{ $story['id'] }}"/>
                                <textarea id="story-comment{{ $story['id'] }}" class="form-control border rounded" style="font-size: 12px;" placeholder="Tulis Komentar" required></textarea>
                                <button data-id="{{ $story['id'] }}" style="width: 65px;font-size: 12px;" class="btn btn-xs btn-success mt-2 send-comment" type="submit">
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                </button>
                            </form>
                        </div> --}}
                    </div>
                    {{-- <div class="comment-before"></div> --}}
                    @include('home.comment')
                </div>
                <div class="like-full{{ $story['id'] }}" style="display:none;">
                    @for ($i = 0; $i < 5; $i++)
                    <div class="flex items-left max-w-full mb-2">
                        <img 
                            alt="Foto profil {{ $story['warga']['full_name'] ?? 'Pengguna' }}" 
                            class="profile-picture rounded-full" 
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
            {{-- <div class="w-full max-w-full bg-white shadow-xs rounded-lg overflow-hidden">
                
            </div> --}}
            @endforeach
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

$(document).ready(function () {
    $(document).on("click", ".send-comment", function() {
        const formid = $(this).attr('data-id');
        
        $('#form-comment'+formid).off('submit').on('submit', function (e) {
            //alert('#form-comment'+formid);return;
            e.preventDefault();
            // Ambil data dari form
            const token = '{{ session::get('token') }}'; // Ambil token dari elemen HTML
            const storyId = $('#storyid'+formid).val();
            const commentText = $('#story-comment'+formid).val();
        
            const fullName = '{{ session()->get('warga.full_name') }}';
            const profile =  '{{ session()->get('warga.profile_photo') }}';
            const wargaData = { 'full_name': fullName};
                
            // Validasi input
            if (!commentText.trim()) {
                alert('Komentar tidak boleh kosong.');
                return;
            }

           // alert(storyId+' - '+commentText);return;

            // Kirim data ke API
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
                    if (response.success) {// Buat elemen HTML dari respons
                        // Kosongkan textarea setelah submit
                        $('#story-comment'+formid).val('');
                        const storyId = formid
                        $.ajax({
                            url: "{{ route('getReplays') }}", // URL endpoint ke Laravel
                            method: "POST",
                            cache: false,
                            data: {
                                story_id: storyId,
                                _token: "{{ csrf_token() }}" // Sertakan CSRF token
                            },
                            success: function (response) {
                                if (response.html) {
                                    $('.comment-show'+storyId).html(response.html);
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error('Error fetching comments:', xhr.responseText);
                            }
                        });
                        // Swal.fire('Success!', 'Warga successfully verified.', 'success');
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
                    alert(errorMsg);
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
       
        if (targetDiv1.css("display") === "block" && $(this).text() === 'selengkapnya') {
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
            targetOther.css("display", "none"); // Sembunyikan like
            //alert(dataId);
            const storyId = dataId
            fetchComments(storyId); // Panggil fungsi fetchComments

        } 
        // else {
        //     targetDiv.css("display", "none");
        // }

    });

    $(document).on("click", ".toggle-like", function() {
        const dataId = $(this).attr("data-id");
        const targetDiv = $(`.like-full${dataId}`);
        const targetOther = $(`.comment-full${dataId}`);
       
        if (targetDiv.css("display") === "none") {
            targetDiv.css("display", "block");
            targetOther.css("display", "none"); // Sembunyikan comment
        } else {
            targetDiv.css("display", "none");
        }

    });

    function fetchComments(storyId) {
        $.ajax({
            url: "{{ route('getReplays') }}", // URL endpoint ke Laravel
            method: "POST",
            cache: false,
            data: {
                story_id: storyId,
                _token: "{{ csrf_token() }}" // Sertakan CSRF token
            },
            success: function (response) {
                if (response.html) {
                    $('.comment-show'+storyId).html(response.html);
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

        //alert(dataId +' '+ url);

        $.ajax({
            url: "{{ route('getReplaysMore') }}", // URL endpoint ke Laravel
            method: "POST",
            data: {
                story_id: storyId,
                url : url,
                _token: "{{ csrf_token() }}" // Sertakan CSRF token
            },
            success: function (response) {
                if (response.html) {
                    $('.comment-more'+storyId).append(response.html);
                    // const next = $('#comment-more'+storyId).attr("data-next");
                    // if(next === null){
                    //     $('#load-more'+storyId).css("display", "none");
                    // }
                    // else{
                    //     $('#load-more'+storyId).css("display", "block");
                    // }
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
      const electionDate = new Date('2025-12-31 23:59:59').getTime();
      const now = new Date().getTime();
      const distance = electionDate - now;

      if (distance < 0) {
        document.getElementById('countdown').innerHTML = '<i class="fas fa-check-circle"></i> Pemilihan Sedang Berlangsung!';
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

      document.getElementById('countdown').innerHTML = countdownText;
    }

    updateCountdown();
    setInterval(updateCountdown, 60000);

</script>
@endsection 
@endif