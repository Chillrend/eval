@extends('layouts.app')

@section('title', 'Pembobotan')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet"
        href="{{ asset('library/prismjs/themes/prism.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">

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
                            <label class="my-0" for="tahun_terdaftar"><h6 class="my-0 mr-3">Tahun</h6></label>
                            <select class="form-control" name="tahun_terdaftar" id="tahun_terdaftar" onchange="sendTahun()" url="{{route('api_pendBobot')}}">
                                <option selected hidden disabled>Pilih tahun</option>
                            </select>
                        </div>
                        
                        <div class="d-flex align-items-center col-12 col-xl-3 col-lg-4 col-md-4 col-sm-12 my-1">
                            <label class="my-0" for="pendidikan"><h6 class="my-0 mr-3">Pendidikan</h6></label>
                            <select class="form-control" name="pendidikan" id="pendidikan" onchange="sendPend()" url="{{route('api_tahapBobot')}}" disabled>
                                <option selected hidden disabled>Pilih Pendidikan</option>
                            </select>
                        </div>    

                        <div class="d-flex align-items-center col-12 col-xl-3 col-lg-4 col-md-4 col-sm-12 my-1">
                            <label class="my-0" for="tahap"><h6 class="my-0 mr-3">Tahap</h6></label>
                            <select class="form-control" name="tahap" id="tahap" onchange="sendTahap()" url="{{route('api_dataBobot')}}" disabled>
                                <option selected hidden disabled>Pilih Tahap</option>
                            </select>
                        </div>

                        </div>
                    </div>

                    <div class="card" id="datatable" hidden>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="align-items-left">
                                    <button type="submit" class="btn btn-primary" id="modal-add" onclick="showForm()"><i class="fas fa-plus"></i> Add</button>
                                </div>
                            </div>
                            <br>

                            @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close"
                                            data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                        {{ session('success') }}
                                    </div>
                                </div>
                            @endif

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close"
                                            data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                        {{ $error }}
                                    </div>
                                </div>
                                @endforeach
                            @endif

                            <br>
                            <div class="">
                                <table class="table-hover table-md table display nowrap" id="tbl-bobot">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</i></th>
                                            <th scope="col">Kolom</th>
                                            <th scope="col">Nilai</th>
                                            <th scope="col"><i class="fas fa-star"></i></th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
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
                                    <input type="checkbox"
                                        name="prioritas" id="prioritas"
                                        name="custom-switch-checkbox"
                                        class="custom-switch-input" onclick="setPrioritas()">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Criteria ini akan dipriotaskan tanpa pembobotan</span>
                                </label>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7">
                                    <button class="btn btn-success" type="submit">Submit</button>
                                    <input class="btn btn-danger ml-2"type="button" value="Close" onclick="tutup()">
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
<script src="{{ asset('library/prismjs/prism.js') }}"></script>
<script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
<script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('js/stisla.js') }}"></script>
<script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="../../js/bobot.js"></script>
<script src="../../js/table.js"></script>
<script src="../../js/style.js"></script>
<!-- <script src="../../js/prodi.js"></script> -->
<script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>

@endpush