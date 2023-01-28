@extends('layouts.app')

@section('title', 'Form')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap4.min.css" />
@endpush

@section('main')
<div class="main-content" id="main-content" url="{{route('api_tahunFinish')}}">
    <section class="section">
        <div class="section-header">
            <h1>Selesai Penerimaan</h1>
        </div>
        <div class="row" id="hero-awal">
            <div class="col-12 mb-0">
                <div class="alert alert-primary alert-dismissible show fade">
                    <div class="alert-body">
                        <div class="hero bg-primary text-white">
                            <button class="close" id="bt-close" data-dismiss="hero">
                                <i class="fa fa-times fa-sm"></i>
                            </button>
                            <div class="hero-inner" id="hero-inner">
                                <h2>Selamat Datang di Halaman Selesai Penerimaan</h2>
                                <p class="lead">Pastikan data yang akan anda export telah melalui tahap filter</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">

                        <div class="d-flex align-items-center col-12 col-xl-3 col-lg-4 col-md-4 col-sm-12 my-1">
                            <label class="my-0" for="tahun_terdaftar">
                                <h6 class="my-0 mr-3">Tahun</h6>
                            </label>
                            <select class="form-control" name="tahun_terdaftar" id="tahun_terdaftar" onchange="sendTahun()" url="{{route('api_pendFinish')}}">
                                <option selected hidden disabled>Pilih tahun</option>
                            </select>
                        </div>

                        <div class="d-flex align-items-center col-12 col-xl-3 col-lg-4 col-md-4 col-sm-12 my-1">
                            <label class="my-0" for="pendidikan">
                                <h6 class="my-0 mr-3">Pendidikan</h6>
                            </label>
                            <select class="form-control" name="pendidikan" id="pendidikan" onchange="sendPend()" url="{{route('api_kolomFinish')}}" disabled>
                                <option selected hidden disabled>Pilih Pendidikan</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Seleksi Prestasi -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header my-2 d-flex justify-content-between align-items-center">
                        <h4>Seleksi Prestasi</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between row">
                            <div class="d-flex align-items-center col-12 col-xl-3 col-lg-6 col-md-6 col-sm-12 my-1">
                                <label class="my-0" for="id_pres">
                                    <h6 class="my-0 mr-3">ID</h6>
                                </label>
                                <select class="form-control" name="id_pres" id="id_pres">
                                    <option selected hidden disabled>Kolom Id</option>
                                </select>
                            </div>

                            <div class="d-flex align-items-center col-12 col-xl-3 col-lg-6 col-md-6 col-sm-12 my-1">
                                <label class="my-0" for="nama_pres">
                                    <h6 class="my-0 mr-3">Nama</h6>
                                </label>
                                <select class="form-control" name="nama_pres" id="nama_pres">
                                    <option selected hidden disabled>Kolom Nama</option>
                                </select>
                            </div>

                            <div class="d-flex align-items-center col-12 col-xl-3 col-lg-6 col-md-6 col-sm-12 my-1">
                                <label class="my-0" for="jurusan_pres">
                                    <h6 class="my-0 mr-3">Jurusan</h6>
                                </label>
                                <select class="form-control" name="jurusan_pres" id="jurusan_pres">
                                    <option selected hidden disabled>Kolom Jurusan</option>
                                </select>
                            </div>

                            <div class="d-flex align-items-center col-12 col-xl-3 col-lg-6 col-md-6 col-sm-12 my-1">
                                <label class="my-0" for="alamat_pres">
                                    <h6 class="my-0 mr-3">Alamat</h6>
                                </label>
                                <select class="form-control" name="alamat_pres" id="alamat_pres">
                                    <option selected hidden disabled>Kolom Alamat</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-lg btn-success m-1" id="savebtn" onclick="sendKolom('pres')">
                                <h6 class="my-0">Search</h6>
                            </button>
                        </div>
                        <br>
                        <div class="table-responsive" id="table-responsive-pres">
                            <table class="table table-striped" id="table-pres">
                                <thead>
                                    <tr id="tbl-header-pres"></tr>
                                </thead>
                                <tbody id="tbl-body-pres">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Seleksi Tes -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header my-2 d-flex justify-content-between align-items-center">
                        <h4>Seleksi Tes</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between row">
                            <div class="d-flex align-items-center col-12 col-xl-3 col-lg-6 col-md-6 col-sm-12 my-1">
                                <label class="my-0" for="id_tes">
                                    <h6 class="my-0 mr-3">ID</h6>
                                </label>
                                <select class="form-control" name="id_tes" id="id_tes">
                                    <option selected hidden disabled>Kolom Id</option>
                                </select>
                            </div>

                            <div class="d-flex align-items-center col-12 col-xl-3 col-lg-6 col-md-6 col-sm-12 my-1">
                                <label class="my-0" for="nama_tes">
                                    <h6 class="my-0 mr-3">Nama</h6>
                                </label>
                                <select class="form-control" name="nama_tes" id="nama_tes">
                                    <option selected hidden disabled>Kolom Nama</option>
                                </select>
                            </div>

                            <div class="d-flex align-items-center col-12 col-xl-3 col-lg-6 col-md-6 col-sm-12 my-1">
                                <label class="my-0" for="jurusan_tes">
                                    <h6 class="my-0 mr-3">Jurusan</h6>
                                </label>
                                <select class="form-control" name="jurusan_tes" id="jurusan_tes">
                                    <option selected hidden disabled>Kolom Jurusan</option>
                                </select>
                            </div>

                            <div class="d-flex align-items-center col-12 col-xl-3 col-lg-6 col-md-6 col-sm-12 my-1">
                                <label class="my-0" for="alamat_tes">
                                    <h6 class="my-0 mr-3">Alamat</h6>
                                </label>
                                <select class="form-control" name="alamat_tes" id="alamat_tes">
                                    <option selected hidden disabled>Kolom Alamat</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-lg btn-success m-1" id="savebtn" onclick="sendKolom('tes')">
                                <h6 class="my-0">Search</h6>
                            </button>
                        </div>
                        <br>
                        <div class="table-responsive" id="table-responsive-tes">
                            <table class="table table-striped" id="table-tes">
                                <thead>
                                    <tr id="tbl-header-tes"></tr>
                                </thead>
                                <tbody id="tbl-body-tes">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Seleksi Mandiri -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header my-2 d-flex justify-content-between align-items-center">
                        <h4>Seleksi Mandiri</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between row">
                            <div class="d-flex align-items-center col-12 col-xl-3 col-lg-6 col-md-6 col-sm-12 my-1">
                                <label class="my-0" for="id_mand">
                                    <h6 class="my-0 mr-3">ID</h6>
                                </label>
                                <select class="form-control" name="id_mand" id="id_mand">
                                    <option selected hidden disabled>Kolom Id</option>
                                </select>
                            </div>

                            <div class="d-flex align-items-center col-12 col-xl-3 col-lg-6 col-md-6 col-sm-12 my-1">
                                <label class="my-0" for="nama_mand">
                                    <h6 class="my-0 mr-3">Nama</h6>
                                </label>
                                <select class="form-control" name="nama_mand" id="nama_mand">
                                    <option selected hidden disabled>Kolom Nama</option>
                                </select>
                            </div>

                            <div class="d-flex align-items-center col-12 col-xl-3 col-lg-6 col-md-6 col-sm-12 my-1">
                                <label class="my-0" for="jurusan_mand">
                                    <h6 class="my-0 mr-3">Jurusan</h6>
                                </label>
                                <select class="form-control" name="jurusan_mand" id="jurusan_mand">
                                    <option selected hidden disabled>Kolom Jurusan</option>
                                </select>
                            </div>
                            <br>
                            <div class="d-flex align-items-center col-12 col-xl-3 col-lg-6 col-md-6 col-sm-12 my-1">
                                <label class="my-0" for="alamat_mand">
                                    <h6 class="my-0 mr-3">Alamat</h6>
                                </label>
                                <select class="form-control" name="alamat_mand" id="alamat_mand">
                                    <option selected hidden disabled>Kolom Alamat</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-lg btn-success m-1" id="savebtn" onclick="sendKolom('mand')">
                                <h6 class="my-0">Search</h6>
                            </button>
                        </div>
                        <br>
                        <div class="table-responsive" id="table-responsive-mand">
                            <table class="table table-striped" id="table-mand">
                                <thead>
                                    <tr id="tbl-header-mand"></tr>
                                </thead>
                                <tbody id="tbl-body-mand">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="link-sendkolom" url="{{route('api_dataFinish')}}"></div>
</div>
</section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/select.bootstrap4.js"></script>
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
<script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="../../js/finish.js"></script>
@endpush