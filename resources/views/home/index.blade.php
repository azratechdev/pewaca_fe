@extends('layouts.residence.basetemplate')
@section('content')

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
                <img alt="Pewaca logo" class="mx-auto mt-4 mb-20" height="120" src="{{ asset('assets/plugins/images/wacalogo.jpeg') }}" width="170"/>
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
       <div class="flex justify-between items-center" style="padding-top: 10px;">
            <div class="flex items-center">
                <img alt="Waca Logo" height="120"  width="170" src="{{ asset('assets/plugins/images/wacalogo.jpeg') }}"/>
            </div>
            <a href="{{ route('addpost') }}">
                <div class="flex items-center">
                    <span class="text-xl text-black mr-2">
                    Posting
                    </span>
                    <div class="flex items-center justify-center w-5 h-5 border border-black square-full">
                        <i class="fas fa-plus text-black"></i>
                    </div>
                </div>
            </a>
        </div>
        <br>
        @include('layouts.elements.flash')
        @include('layouts.elements.tagihan')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-3">
            @foreach($stories as $story)
            <div class="w-full max-w-full bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Header Section -->
                <div class="flex items-center p-4">
                    <img 
                        alt="Profile picture" 
                        class="profile-picture rounded-full" 
                        src="{{ $story['warga']['profile_photo'] }}" 
                    />
                    <div class="ml-4">
                        <div class="text-gray-900 font-bold">
                            {{ $story['warga']['full_name'] }}
                        </div>
                        <div class="text-gray-600 text-sm">
                            {{ Carbon::parse($story['created_on'])->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>
        
                <!-- Content Section -->
                <div class="px-4 pb-4 custom-item-content">
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
                        <img alt="No images uploaded" class="fixed-img" src="{{ $story['image'] }}" />
                        <br/>
                    @endif
                   
                   <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <a href="javascript:void(0)" class="toggle-comment text-green-500" data-id="{{ $story['id'] }}">Comment</a> 
                        </div>
                        <div class="flex items-center">
                            <a href="javascript:void(0)" class="toggle-like text-green-500" data-id="{{ $story['id'] }}"> Like {{ $story['total_like'] }}</a>
                        </div>
                    </div>
                </div>
                
                <div class="comment-full{{ $story['id'] }}" style="display:none;">
                    <div class="flex items-left max-w-full" style="padding-left: 20px;">
                        <img 
                            alt="Profile picture" 
                            class="profile-picture rounded-full" 
                            style="width: 36px; height: 36px;"
                            src="{{ $warga['profile_photo'] }}" 
                        />
                        <div class="ml-4 col-md-9 col-9 input-comment">
                            <div style="font-size: 12px;"> <!-- Ukuran font deskripsi -->
                                <form id="form-comment{{ $story['id'] }}" enctype="multipart/form-data">
                                <input type="hidden" id="storyid{{ $story['id'] }}" value="{{ $story['id'] }}"/>
                                <textarea id="story-comment{{ $story['id'] }}" class="form-control border rounded" style="font-size: 12px;" placeholder="Tulis Komentar" required></textarea>
                                <button data-id="{{ $story['id'] }}" style="font-size: 12px;" class="btn btn-sm btn-success mt-2 send-comment" type="submit">Send Comment</button>
                                </form>
                            </div><hr class="mt-2 mb-2">
                        </div>
                    </div>
                    {{-- <div class="comment-before"></div> --}}
                    @include('home.comment')
                </div>
                <div class="like-full{{ $story['id'] }}" style="display:none;">
                    @for ($i = 0; $i < 5; $i++)
                    <div class="flex items-left max-w-full mb-2" style="padding-left: 25px;">
                        <img 
                            alt="Profile picture" 
                            class="profile-picture rounded-full" 
                            style="width: 36px; height: 36px;"
                            src="{{ $story['warga']['profile_photo'] }}" 
                        />
                        <div class="ml-4">
                            <div class="text-gray-900 font-bold" style="font-size: 14px;">
                                {{ $story['warga']['full_name'] }}
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

$(document).ready(function () {
    $(document).on("click", ".send-comment", function() {
        const formid = $(this).attr('data-id');
        
        $('#form-comment'+formid).submit(function (e) {
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
                url: 'https://api.pewaca.id/api/story-replays/',
                type: 'POST',
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
                        
                        const commentHtml = `
                            <div class="flex items-left p-4 custom-card-content">
                                <img 
                                    alt="Profile picture" 
                                    class="profile-picture rounded-full" 
                                    style="width: 48px; height: 48px;"
                                    src="${profile}" 
                                />
                                <div class="ml-4">
                                    <div class="text-gray-900 font-bold" style="font-size: 14px;">
                                        ${fullName}
                                    </div>
                                    <div style="font-size: 12px;">
                                        <p>${response.data.replay}</p>
                                    </div>
                                </div>
                            </div>`;

                        // Append ke bagian atas elemen dengan class comment-append
                        $('.comment-before'+formid).prepend(commentHtml);

                        // Kosongkan textarea setelah submit
                        $('#story-comment'+formid).val('');
                        
                        Swal.fire('Success!', 'Warga successfully verified.', 'success');

                
                    } else {
                        alert('Gagal mengirim komentar. Respon tidak berhasil.');
                        // Swal.fire('Success!', 'Warga successfully verified.', 'success');
                    }
                },
                error: function (error) {
                    alert('Gagal mengirim komentar. Silakan coba lagi.');
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
            //fetchComments(storyId); // Panggil fungsi fetchComments

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

</script>
@endsection 
@endif