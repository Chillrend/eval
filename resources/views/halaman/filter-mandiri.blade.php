@extends('layouts.app')

@section('title', 'Form')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap4.min.css" />
@endpush

@section('main')
<div class="main-content" id="main-content" url="{{route('api_tahunFilterMan')}}">
    <section class="section">
        <div class="section-header">
            <h1>Form Filter Calon Mahasiswa - Tahap Mandiri</h1>
        </div>
        <div id="data-kosong" hidden>
            <div class="alert alert-danger alert-has-icon">
                <div class="alert-icon"><i class="fas fa-exclamation"></i></div>
                <div class="alert-body">
                    <div class="alert-title">Data Kosong</div>
                    <p id="alert-text"></p>
                </div>
            </div>
        </div>

        <!-- Card Pembobotan + Pendidikan -->
        <div class="card" id="headfilter" hidden>
            <div class="card-header d-flex justify-content-between">

                <div class="d-flex align-items-center col-12 col-xl-3 col-lg-4 col-md-4 col-sm-12 my-1">
                    <label class="my-0" for="tahun_terdaftar">
                        <h6 class="my-0 mr-3">Tahun</h6>
                    </label>
                    <select class="form-control" name="tahun_terdaftar" id="tahun_terdaftar" onchange="getPend()" url="{{route('api_pendFilterMan')}}">
                        <option selected hidden disabled>Pilih tahun</option>
                    </select>
                </div>

                <div class="d-flex align-items-center col-12 col-xl-3 col-lg-4 col-md-4 col-sm-12 my-1">
                    <label class="my-0" for="pendidikan">
                        <h6 class="my-0 mr-3">Pendidikan</h6>
                    </label>
                    <select class="form-control" name="pendidikan" id="pendidikan" onchange="getKolom()" url="{{route('api_kolomFilterMan')}}" disabled>
                        <option selected hidden disabled>Pilih Pendidikan</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Card Filter Form -->
        <div class="card" id="formfilter" hidden>
            <form id="">
                <div class="card-header">
                    <h4 class="my-2">Filter Kolom</h4>
                </div>
                <div class="card-body">
                    <div class="section-title mt-0">Kolom Jurusan</div>
                    <label>Pilih kolom jurusan sebelum filter</label>
                    <select class="custom-select " name="jurusan" id="jurusan">

                    </select>

                    <div class="section-title">Filter Kolom</div>
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
                    <button type="button" id="btnFilter" class="btn btn-primary" onclick="kirimFilter()" url="{{route('api_renderFilterMan')}}">Filter</button>
                </div>
            </form>
        </div>

        <div id="card-table" hidden>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" id="table-responsive">

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