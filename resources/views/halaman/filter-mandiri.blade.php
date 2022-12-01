@extends('layouts.app')

@section('title', 'Form')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap4.min.css" />
@endpush

@section('main')
<div class="main-content" id="main-content" url="{{route('api_renderFilterMan')}}">
    <section class="section">
        <div class="section-header">
            <h1>Form Filter Calon Mahasiswa - Tahap Tes</h1>
        </div>
        <div id="data-kosong">
            <div class="alert alert-danger alert-has-icon">
                <div class="alert-icon"><i class="fas fa-exclamation"></i></div>
                <div class="alert-body">
                    <div class="alert-title">Data Kosong</div>
                    <p id="alert-text"></p>
                </div>
            </div>
        </div>
        <div id="formfilter">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="my-2">Upload Data Calon Mahasiswa</h4>
                        </div>
                        <div class="">
                            <form id="">
                                <div class="card-body">
                                    <!-- @csrf -->
                                    <div class="section-title mt-0">Pilih Periode PMB</div>
                                    <label>Masukkan Tahun Periode</label>
                                    <input type="number" class="form-control" id="tahunperiode" name="tahunperiode" readonly>
                                    <div class="section-title">Nama Kolom Excel</div>
                                    <label>Template Table</label>
                                    <select class="custom-select " name="periode" id="periode" onchange="myFunction()" url="{{route('getFilterMan')}}">

                                    </select>
                                    <label class="mt-3">Cocokkan nama kolom excel dengan nama pada table</label>
                                    <div class="input-group mb-3">
                                        <select class="form-control" name="kolom" id="kolom">
                                        </select>
                                        <select class="form-control" name="operator" id="operator">
                                            <option selected hidden value="">Operasi</option>
                                            <option value="="> = </option>
                                            <option value=">"> > </option>
                                            <option value="<">
                                                < </option>
                                            <option value=">="> >= </option>
                                            <option value="<=">
                                                <= </option>
                                            <option value="<>">
                                                <>
                                            </option>
                                        </select>
                                        <input type="text" class="form-control" id="nilai" name="nilai" placeholder="Nilai">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="button" url-del="" id="tambahCriteria" onclick="addCollumn()"><i class="fa-solid fa-plus fa-lg"></i> Tambah</button>
                                        </div>
                                    </div>
                                    <div id="namedkey">
                                    </div>
                                    <input type="text" class="form-control" id="banyakCollumn" name="banyakCollumn" value="0" hidden>
                                </div>
                                <div class="card-footer text-right">
                                    <input type="button" class="btn btn-primary" value="Filter" onclick="kirimFilter()" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="card-table">
            <h2 class="section-title">Preview</h2>
            <p class="section-lead">
                Preview data mahasiswa yang akan di upload
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="float-right row">
                                <button class="btn btn-lg btn-warning mx-1" id="cancelBtn" onclick="cancelFilter()">
                                    <h6 class="my-0">Cancel</h6>
                                </button>
                                <button class="btn btn-lg btn-success mx-1" id="saveBtn" onclick="saveFilter()" url="{{route('saveFilterMan')}}">
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
<script src="{{ asset('js/stisla.js') }}"></script>
<script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>


<!-- Page Specific JS File -->
<script src="../../js/style.js"></script>
<script src="../../js/filter-mandiri.js"></script>
@endpush