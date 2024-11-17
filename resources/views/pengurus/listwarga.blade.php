<div class="col-md-12 col-sm-12">
    <div class="pull-left"><b>Daftar Warga</b></div>
</div><br><br>
{{-- <div class="col-md-12">
    <div class="table-responsive">
        <table id="tableWarga" class="table table-bordered display responsive nowrap" style="width: 100%;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>NIK</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data_warga['data'] as $key => $v)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $v['nik'] }}</td>
                        <td>{{ $v['full_name'] }}</td>
                        <td>{{ $v['phone_no'] }}</td>
                        <td>
                            <button style="color: white;" class="btn btn-sm btn-info" id="detail" data-id="{{ $v['id'] }}" title="Detail Warga">
                                <i class="fa fa-list" aria-hidden="true"> Detail</i>
                            </button> 
                            <button style="color: white;" class="btn btn-sm btn-warning" id="detail" data-id="{{ $v['id'] }}" title="Edit Warga">
                                <i class="fa fa-pencil" aria-hidden="true"> Edit</i>
                            </button> 
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <strong>{{ $data_warga['message'] ?: 'No data available' }}</strong>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div> --}}

<div class="col-md-12">
    <div class="row">
        @foreach ($data_warga['data'] as $key => $v)
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="row no-gutters">
                        <!-- Kolom Gambar -->
                        <div class="col-md-3">
                            <img src="{{ asset('assets/plugins/images/users/2.png') }}" class="card-img" alt="img">
                        </div>

                        <!-- Kolom Detail -->
                        <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title">{{ $v['full_name'] }}</h5>
                                <p class="card-text">NIK: {{ $v['nik'] }}</p>
                                <p class="card-text">Phone: {{ $v['phone_no'] }}</p>
                                
                                <!-- Garis Pemisah -->
                                <hr>

                                <!-- Tombol Detail dan Edit di bawah detail -->
                                <div class="d-flex justify-content-between">
                                    <a href="" class="btn btn-info">Detail</a>
                                    <a href="" class="btn btn-warning">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
