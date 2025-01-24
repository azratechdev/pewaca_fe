@extends('layouts.residence.basetemplate')
@section('content')
<style>
   <style>
    /* Custom Switch Styles */
    .custom-switch .form-check-input {
      width: 4rem;
      height: 2rem;
      border-radius: 2rem;
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }
    .custom-switch .form-check-input:not(:checked) {
      background-color: #ccc;
      border-color: #ccc;
    }
    .custom-switch .form-check-input:checked {
      background-color: #198754;
      border-color: #198754;
      box-shadow: 0 0 10px rgba(25, 135, 84, 0.5); */
    }

    #repeat-container {
      display: none;
    }
    
  </style>
</style>
<div class="container">
  <div class="container mx-auto px-4">
    <div class="flex justify-between items-center" style="padding-top: 10px;">
      <div class="flex items-center">
        <h1 class="text-xl font-semibold text-gray-800">
          <a href="{{ route('pembayaran') }}" class="text-dark">
              <i class="fas fa-arrow-left"></i>
          </a>&nbsp;Pembayaran Tagihan
      </h1>
      </div>
    </div>
    <br>
    <div class="mb-3">
        @include('layouts.elements.flash')
    </div>
   
    <div class="flex justify-between items-center">
        <div class="flex items-center">
            <p class="d-flex align-items-center">
              <strong>{{ $tagihan['data']['tagihan']['name'] ?? 'Nama Tagihan' }}</strong>
            </p>
        </div>
    </div>

    <div class="flex justify-between items-center mt-2">
        <div class="flex items-center">
            <p class="d-flex align-items-center">
                {{ $tagihan['data']['tagihan']['description'] ?? 'Deskripsi tidak ada' }}
            </p>
        </div>
    </div> 
    <div class="flex justify-between items-center mt-1">
        <div class="flex items-center">
            <p class="d-flex align-items-center">
                Nominal
            </p>
        </div>
        
        <div class="flex items-center">
            <p class="d-flex align-items-center">
                @php
                    $formattedAmount = number_format((int) $tagihan['data']['tagihan']['amount'], 0, ',', '.');
                @endphp
                <strong>Rp {{ $formattedAmount }}</strong>
            </p>
        </div>
    </div> 

    <hr class="mt-2">

    <div class="flex justify-between items-center mt-1">
        <div class="flex items-center">
            <p class="d-flex align-items-center">
                Transfer ke :
            </p>
        </div>
        
    </div> 
    
    <div class="flex justify-between items-center mt-1">
        <div class="flex items-center">
            <p class="d-flex align-items-center" style="font-size:10px;">
               No. Rekening
            </p>
        </div>
       
    </div> 
    
    <div class="flex justify-between items-center mt-1">
        <div class="flex items-center">
            <div class="d-flex align-items-center norek">
                <strong>
                    {{ $tagihan['residence_bank'] ?? '123456789' }}
                </strong>
            </div>
        </div>
        
        <div class="flex items-center">
            <p class="d-flex align-items-center salin" style="color:lightgreen;">
                Salin
            </p>
        </div>
    </div> 
    <div class="flex justify-between items-center mt-1">
        <div class="flex items-center">
            <p class="d-flex align-items-center">
                Atas Nama
            </p>
        </div>
        
        <div class="flex items-center">
            <p class="d-flex align-items-center">
                <strong>Darik</strong>
            </p>
        </div>
    </div> 
    <div class="flex justify-between items-center mt-1">
        <div class="flex items-center">
            <p class="d-flex align-items-center">
                Nama Bank
            </p>
        </div>
        
        <div class="flex items-center">
            <p class="d-flex align-items-center">
                <strong>BCA</strong>
            </p>
        </div>
    </div> 
    <hr class="mt-2">
    <form id="pembayaran_tagihan" method="post" action="{{ route('tagihan.post') }}" enctype="multipart/form-data">
      @csrf
        <div class="flex justify-between items-center mt-3">
            <div class="flex items-center">
                <p class="d-flex align-items-center">
                    Upload Photo Bukti Pembayaran
                </p>
            </div>
        </div> 
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <div class="relative mb-2 mt-4">
                   
                    <input 
                      accept="image/*" 
                      class="hidden" 
                      id="imageUpload" 
                      type="file" 
                      name="post_picture"
                    />
                    
                    <label class="cursor-pointer relative" for="imageUpload">
                        <div class="img-upload h-48 object-cover rounded-lg bg-gray-200 flex items-center justify-center relative">
                            <img 
                                alt="Preview of uploaded image" 
                                class="absolute inset-0 h-full w-full object-cover rounded-lg hidden" 
                                id="imagePreview"
                                src=""
                            />
                            <div class="text-center">
                                <i class="fas fa-plus text-white text-4xl mb-2"></i><br>
                                <span class="text-white text-lg">Upload Foto</span>
                                <span class="text-white text-sm block">(Wajib Disertakan)</span>
                            </div>
                            <button 
                              class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hidden" 
                              id="removeImageButton">
                              <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </label>
                    <div class="alert-upload"></div>
                </div>
            </div>
        </div> 
        {{-- <div class="flex justify-between items-center">
            <div class="flex items-center">
                
            </div>
        </div> --}}
        <div>
            <div class="form-floating mt-4">
                <input type="text" class="form-control rupiah-input @error('nominal') is-invalid @enderror" value="" id="nominal" name="nominal"
                placeholder="Rp. 0" pattern="^Rp\.\s?(\d{1,3}(\.\d{3})*|\d+)$" required>
                <label for="nominal">Nominal</label>

                <input type="hidden" name="residence_bank" value="1234567" required/>
                <input type="hidden" name="id" value="{{ $tagihan['data']['id'] }}" required/>
                <input type="hidden" id="type" name="tipe" value="{{ $tagihan['data']['tagihan']['tipe'] }}" required/>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" id="submitBtn" class="btn btn-success form-control" disabled>Lanjutkan</button>
            </div>
        </div>
    </form>
  </div>
</div>
    
<script>
     const form = document.getElementById('pembayaran_tagihan');
     const submitBtn = document.getElementById('submitBtn');
     
   
     function checkFormValidity() {
        
        const isValid = [...form.querySelectorAll('input[required]')].every(input => {
            return input.value.trim() !== '';
        });
      
         submitBtn.disabled = !isValid;
     }

     form.addEventListener('input', checkFormValidity);

     checkFormValidity();
 
</script>

<script>
    const paymentInput = document.getElementById('nominal');
    const typeInput = document.getElementById('type');
    
    // Ambil nilai amount dari server dan hapus ".00" jika ada
    let amount = "{{ $tagihan['data']['tagihan']['amount'] }}".split('.')[0]; // Mengambil angka sebelum "."
    const typeValue = typeInput.value; // Ambil tipe
  
    // Set nilai awal berdasarkan tipe
    if (typeValue === 'wajib') {
      paymentInput.value = `Rp. ${parseInt(amount, 10).toLocaleString('id-ID')}`;
      paymentInput.readOnly = true; // Input tidak dapat diubah
    } else {
      paymentInput.value = ''; // Kosongkan jika tidak wajib
      paymentInput.readOnly = false;
    }
  
    // Event listener untuk format Rupiah saat user mengetik (jika tidak wajib)
    paymentInput.addEventListener('input', function (e) {
      if (typeValue !== 'wajib') {
        let value = this.value.replace(/[^0-9]/g, ''); // Hanya angka
        if (value) {
          value = parseInt(value, 10).toLocaleString('id-ID'); // Format angka ke Rupiah
          this.value = `Rp. ${value}`;
        } else {
          this.value = '';
        }
      }
    });
  
    // Event listener untuk mengatur nilai default jika input dikosongkan
    paymentInput.addEventListener('blur', function () {
      if (typeValue !== 'wajib' && !this.value.startsWith('Rp.')) {
        this.value = ''; // Kosongkan input jika tidak "wajib"
      }
    });
</script>

{{-- <script>
 
    const paymentInput = document.getElementById('nominal');

    paymentInput.addEventListener('input', function (e) {
      let value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
      if (value) {
        value = parseInt(value, 10).toLocaleString('id-ID'); // Format to Rupiah locale
        this.value = `Rp. ${value}`;
      } else {
        this.value = '';
      }
    });

    paymentInput.addEventListener('blur', function () {
      if (!this.value.startsWith('Rp.')) {
        this.value = `Rp. 0`; // Default value if input is cleared
      }
    });
  </script> --}}

<script>
$(document).ready(function () {
    $('.salin').on('click', function () {
        // Debugging: Log untuk memastikan elemen ditemukan
        const norekElement = $('.norek strong');
        
        // Ambil teks di dalam elemen
        const norekText = norekElement.text().trim();
        console.log('Teks yang diambil:', norekText);

        if (norekText) {
            // Salin teks ke clipboard menggunakan API modern
            if (navigator.clipboard) {
                navigator.clipboard.writeText(norekText)
                    .then(() => {
                        alert('Berhasil menyalin: ' + norekText);
                    })
                    .catch(err => {
                        console.error('Gagal menyalin:', err);
                        alert('Gagal menyalin teks.');
                    });
            } else {
                // Fallback untuk browser lama
                const tempInput = $('<textarea>');
                $('body').append(tempInput);
                tempInput.val(norekText).css({
                    position: 'absolute',
                    left: '-9999px',
                }).select();
                try {
                    document.execCommand('copy');
                    alert('Berhasil menyalin: ' + norekText);
                } catch (err) {
                    console.error('Gagal menyalin:', err);
                    alert('Gagal menyalin teks.');
                }
                tempInput.remove();
            }
        } else {
            alert('Tidak ada teks untuk disalin.');
        }
    });
});

</script>   
<script>
    const imageUpload = document.getElementById('imageUpload');
    const imagePreview = document.getElementById('imagePreview');
    const removeImageButton = document.getElementById('removeImageButton');
 
    imageUpload.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          imagePreview.src = e.target.result;
          removeImageButton.classList.remove('hidden');
          imagePreview.classList.remove('hidden'); // Tampilkan gambar
          imagePreview.classList.remove('bg-gray-200'); // Hapus latar abu-abu
        }
        reader.readAsDataURL(file);
      }
    });
 
    removeImageButton.addEventListener('click', function() {
      imagePreview.src = 'x';
      imageUpload.value = '';
      removeImageButton.classList.add('hidden');
      imagePreview.classList.add('hidden');
    });
</script> 
<script>
   document.getElementById('pembayaran_tagihan').addEventListener('submit', function (event) {
    // Ambil elemen input file
    const imageUpload = document.getElementById('imageUpload');
    // Ambil elemen div untuk alert
    const alertUploadDiv = document.querySelector('.alert-upload');

    // Hapus alert sebelumnya jika ada
    alertUploadDiv.innerHTML = '';

    // Periksa apakah input file kosong
    if (!imageUpload.value) {
        // Cegah pengiriman form
        event.preventDefault();

        // Tambahkan pesan alert ke dalam div
        alertUploadDiv.innerHTML = `
            <label class="mb-2" style="font-size:10px;color:red;">
                Upload Bukti Pembayaran Wajib Disertakan
            </label>
        `;
    }
});

</script>
@endsection 