@extends('layouts.app')

@section('title', 'Pembobotan')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap4.min.css" />

@endpush

@section('main')
<div class="main-content" id="main-content" url="{{route('api_tahunBobot')}}">
    <section class="section">
        <div class="section-header">
            <h1>Pembobotan</h1>
        </div>
        <div id="">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">

                            <div class="d-flex align-items-center col-12 col-xl-3 col-lg-4 col-md-4 col-sm-12 my-1">
                                <label class="my-0" for="tahun_terdaftar">
                                    <h6 class="my-0 mr-3">Tahun</h6>
                                </label>
                                <select class="form-control" name="tahun_terdaftar" id="tahun_terdaftar" onchange="sendTahun()" url="{{route('api_pendBobot')}}">
                                    <option selected hidden disabled>Pilih tahun</option>
                                </select>
                            </div>

                            <div class="d-flex align-items-center col-12 col-xl-3 col-lg-4 col-md-4 col-sm-12 my-1">
                                <label class="my-0" for="pendidikan">
                                    <h6 class="my-0 mr-3">Pendidikan</h6>
                                </label>
                                <select class="form-control" name="pendidikan" id="pendidikan" onchange="sendPend()" url="{{route('api_tahapBobot')}}" disabled>
                                    <option selected hidden disabled>Pilih Pendidikan</option>
                                </select>
                            </div>

                            <div class="d-flex align-items-center col-12 col-xl-3 col-lg-4 col-md-4 col-sm-12 my-1">
                                <label class="my-0" for="tahap">
                                    <h6 class="my-0 mr-3">Tahap</h6>
                                </label>
                                <select class="form-control" name="tahap" id="tahap" onchange="sendTahap()" url="{{route('api_dataBobot')}}" disabled>
                                    <option selected hidden disabled>Pilih Tahap</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="card" id="datatable">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="align-items-left">
                                    <button type="submit" class="btn btn-primary" id="modal-add" onclick="showForm()"><i class="fas fa-plus"></i> Add</button>
                                </div>
                            </div>
                            <br>

                            <br>
                            <div class="table-responsive" id="table-responsive">

                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <input type="submit" class="btn btn-primary" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section id="form-bobot" hidden>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="my-2">Tambah Pembobotan</h4>
                    </div>
                    <div class="card-body">
                        <form id="modal-add-prodi">
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kolom</label>
                                <div class="col-sm-12 col-md-7">
                                    <select type="number" class="form-control" name="kolom" id="kolom" onchange="sendKolom()" url="{{route('api_nilaiBobot')}}" required>
                                        <option selected hidden>Pilih Kolom</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nilai</label>
                                <div class="col-sm-12 col-md-7">
                                    <select type="number" class="form-control" name="nilai" id="nilai" onchange="sendNilai()" required disabled>
                                        <option selected hidden>Pilih Nilai</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bobot</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="number" class="form-control" placeholder="Bobot Nilai" name="bobot" id="bobot" required disabled>
                                </div>
                            </div>
                            <div class="form-group row mb-4 d-flex">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <label class="custom-switch col-sm-12 col-md-7 px-3">
                                    <input type="checkbox" name="prioritas" id="prioritas" name="custom-switch-checkbox" class="custom-switch-input" onclick="setPrioritas()">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Criteria ini akan dipriotaskan tanpa pembobotan</span>
                                </label>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7">
                                    <button class="btn btn-success" type="button" onclick="addCriteria()">Submit</button>
                                    <button class="btn btn-danger ml-2" type="button" onclick="tutup()">Close</button>
                                </div>
                            </div>
                        </form>
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
<script src="../../js/bobot.js"></script>
<script src="../../js/style.js"></script>
@endpush