@extends('layouts.app')

@section('title', 'Form')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap4.min.css" />
@endpush

@section('main')
<div class="main-content" id="main-content" url="{{route('api_renderCanMan')}}">
    <section class="section">
        <div class="section-header">
            <h1>Form Data Calon Mahasiswa</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Seleksi Mandiri</a></div>
                <div class="breadcrumb-item"><a href="#">Data Mahasiswa</a></div>
                <div class="breadcrumb-item">Form Data Calon Mahasiswa</div>
            </div>
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
                                <h2>Selamat Datang di Halaman Data Mahasiswa</h2>
                                <p class="lead">Silahkan upload data mahasiswa seleksi mandiri dengan file excel.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div id="accordion">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="my-2">Upload Data Calon Mahasiswa</h4>
                        </div>
                        <div class="">
                            <form url="{{route('api_importCanMan')}}" id="form-candidate">
                                <div class="card-body">
                                    @csrf
                                    <div class="section-title mt-0">Pilih Periode PMB</div>
                                    <label>Masukkan Tahun Periode</label>
                                    <input type="number" class="form-control" id="tahunperiode" name="tahunperiode" placeholder="Input Tahun" value="{{now()->year}}">

                                    <div class="section-title">File Browser</div>
                                    <div class="input-group mb-3">
                                        <input type="file" class="choose form-control" id="customFile" name="excel">
                                        <div class="input-group-append">
                                            <label class=" input-group-text btn btn-outline-primary" for="customFile">Upload</label>
                                        </div>
                                    </div>

                                    <div class="section-title">Nama Kolom Excel</div>
                                    <label>Template Tabel</label>
                                    <select class="form-control " name="periode" id="periode" onchange="myFunction()">

                                    </select>
                                    <label class="mt-3">Cocokkan nama kolom excel dengan nama pada table</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="nameCollumn" name="nameCollumn" placeholder="Nama Kolom pada Excel">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="button" url="{{route('criteriaCanMan')}}" url-del="" id="tambahCriteria" onclick="addCollumn()"><i class="fa-solid fa-plus fa-lg"></i> Tambah</button>
                                        </div>
                                    </div>

                                    <div id="namedkey">
                                    </div>
                                    <input type="text" class="form-control" id="banyakCollumn" name="banyakCollumn" value="0" hidden>
                                </div>
                                <div class="card-footer text-right">
                                    <input type="button" class="btn btn-primary" value="Submit" onclick="insert()" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="preview">
            <h2 class="section-title">Preview</h2>
            <p class="section-lead">
                Preview data mahasiswa yang akan diupload
            </p>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header my-2 d-flex justify-content-between align-items-center">
                            <h4>Tabel Preview</h4>
                            <div class="col-12 col-xl-3 col-lg-3 col-md-3 col-sm-12 p-0 m-0 row justify-content-between align-items-center">
                                <select class="form-control" name="tahun_terdaftar" id="tahun_terdaftar" onchange="gantiTahun()">
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" id="table-responsive">
                                <table class="table table-striped" id="table-candidate" style="width: 100%">
                                    <thead>
                                        <tr id="head-col">

                                        </tr>
                                    </thead>
                                    <tbody id="table-content">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-right row">
                                <button class="btn btn-lg btn-warning mx-1" id="cancelbtn" url="{{route('api_cancelCanMan')}}" onclick="cancel()">
                                    <h6 class="my-0">Cancel</h6>
                                </button>
                                <button class="btn btn-lg btn-success mx-1" id="savebtn" url="{{route('api_saveCanMan')}}" onclick="save()">
                                    <h6 class="my-0">Save</h6>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
<script src="../../js/table.js"></script>
<script src="../../js/style.js"></script>
<script src="../../js/candidate-mandiri.js"></script>
<script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>
@endpush