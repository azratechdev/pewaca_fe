<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/plugins/images/favicon.png') }}">
  <title>Residence</title>
  <link href="{{ asset('assets/bootstrap/dist/css/bootstrap-5.min.css') }}" rel="stylesheet">
  <script src="{{ asset('assets/plugins/components/jquery/dist/jquery.min.js') }}"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    .navbar-custom {
      background-color:  #198754; /* Tosca color */
      padding-top: 0px;
      padding-bottom: 0px;
    }
      
    .card , .login-alert, .logo{
        margin: 10px; /* Batas atas, kiri, kanan, dan bawah */
    }
    .card-header{
       background-color:  #198754;
    }

    a {
      text-decoration: none;
    }

    .waca-logo {
        width: 200px; /* Sesuaikan ukuran yang diinginkan */
        height: 97px; /* Sesuaikan ukuran yang diinginkan */
    }
  </style>
  <style>
    /* Styling untuk container input */
    .form-group {
        position: relative;
        margin: 20px 0;
        width: 100%;
        max-width: 1100px;
    }

    /* Styling untuk input */
    .form-control {
        width: 100%;
        padding: 10px;
        font-size: 1em;
        border: 1px solid #ccc;
        border-radius: 4px;
        outline: none;
    }

    /* Styling untuk label */
    .form-label {
        position: absolute;
        left: 12px;
        top: 10px;
        font-size: 1em;
        color: #999;
        background-color: white;
        padding: 0 5px;
        transition: 0.2s ease;
        pointer-events: none;
    }

    /* Styling ketika input diisi atau di-fokus */
    .form-control:focus + .form-label,
    .form-control:not(:placeholder-shown) + .form-label {
        top: -10px; /* Pindahkan label ke luar input */
        left: 8px;
        font-size: 0.85em;
        color: #333;
    }
  </style>
  <style>
    /* Custom styles for the floating label effect */
    .form-floating {
        margin-bottom: 20px;
    }
</style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <select class="form-control" id="noUnit" required>
                                    <option value="" disabled selected hidden>-pilih unit-</option>
                                    <option value="unit1">Unit 1</option>
                                    <option value="unit2">Unit 2</option>
                                </select>
                                <label for="noUnit" class="form-label">No Unit</label>
                            </div>
                    
                            <div class="form-group">
                                <input type="number" class="form-control" id="nik" placeholder=" " required>
                                <label for="nik" class="form-label">NIK</label>
                            </div>
                    
                            <div class="form-group">
                                <input type="text" class="form-control" id="name" placeholder=" " required>
                                <label for="name" class="form-label">Nama Lengkap</label>
                            </div>
                    
                            <div class="form-group">
                                <input type="number" class="form-control" id="phone" placeholder=" " required>
                                <label for="phone" class="form-label">Nomor Ponsel</label>
                            </div>
                    
                            <div class="form-group">
                                <select class="form-control" id="gender" required>
                                    <option value="" disabled selected hidden>-Pilih Jenis Kelamin-</option>
                                    <option value="male">Laki-laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                            </div>
                    
                            <div class="form-group">
                                <input type="date" class="form-control" id="dob" placeholder=" " required>
                                <label for="dob" class="form-label">Tanggal Lahir</label>
                            </div>
                    
                            <div class="form-group">
                                <select class="form-control" id="religion" required>
                                    <option value="" disabled selected hidden>-Pilih Agama-</option>
                                    <option value="islam">Islam</option>
                                    <option value="kristen">Kristen</option>
                                    <option value="katolik">Katolik</option>
                                    <option value="hindu">Hindu</option>
                                    <option value="budha">Buddha</option>
                                </select>
                                <label for="religion" class="form-label">Agama</label>
                            </div>
                    
                            <div class="form-group">
                                <select class="form-control" id="birthPlace" required>
                                    <option value="" disabled selected hidden>-Pilih Tempat Lahir-</option>
                                    <option value="jakarta">Jakarta</option>
                                    <option value="bandung">Bandung</option>
                                    <option value="surabaya">Surabaya</option>
                                </select>
                                <label for="birthPlace" class="form-label">Tempat Lahir</label>
                            </div>
                    
                            <div class="form-group">
                                <select class="form-control" id="status" required>
                                    <option value="" disabled selected hidden>-Pilih Status-</option>
                                    <option value="single">Single</option>
                                    <option value="married">Menikah</option>
                                </select>
                                <label for="status" class="form-label">Status</label>
                            </div>
                    
                            <div class="form-group">
                                <input type="file" class="form-control" id="marriagePhoto" required>
                                <label for="marriagePhoto" class="form-label">Upload Foto Buku Nikah</label>
                            </div>
                    
                            <div class="form-group">
                                <select class="form-control" id="job" required>
                                    <option value="" disabled selected hidden>-Pilih Pekerjaan-</option>
                                    <option value="pns">PNS</option>
                                    <option value="swasta">Swasta</option>
                                    <option value="wiraswasta">Wiraswasta</option>
                                </select>
                                <label for="job" class="form-label">Pekerjaan</label>
                            </div>
                    
                            <div class="form-group">
                                <select class="form-control" id="education" required>
                                    <option value="" disabled selected hidden>-Pilih Pendidikan-</option>
                                    <option value="sd">SD</option>
                                    <option value="smp">SMP</option>
                                    <option value="sma">SMA</option>
                                    <option value="s1">S1</option>
                                    <option value="s2">S2</option>
                                </select>
                                <label for="education" class="form-label">Pendidikan</label>
                            </div>
                    
                            <div class="form-group">
                                <input type="email" class="form-control" id="email" placeholder=" " required>
                                <label for="email" class="form-label">Alamat Email</label>
                            </div>
                    
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" placeholder=" " required>
                                <label for="password" class="form-label">Buat Kata Sandi</label>
                            </div>
                    
                            <div class="form-group">
                                <input type="file" class="form-control" id="profilePhoto" required>
                                <label for="profilePhoto" class="form-label">Upload Foto Profil</label>
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" id="submitBtn" class="btn btn-success form-control" type="button" disabled>Daftar Sebagai Warga</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

