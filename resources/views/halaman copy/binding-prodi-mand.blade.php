@extends('layouts.app')

@section('title', 'Form')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap4.min.css" />

<!-- Style -->
<style>
    #tbl-bindprodites td {
        vertical-align: middle;
    }
</style>
@endpush

@section('main')
<div class="main-content" id="main-content" url="{{route('api_renderBindProdiMand')}}">
    <section class="section">
        <div class="section-header">
            <h1>Data Kuota Program Studi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Seleksi Prestasi</a></div>
                <div class="breadcrumb-item">Data Kuota Program Studi</div>
            </div>
        </div>


        <div id="">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link "
                                        href="{{ url('prodi-mandiri') }}">Data</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="">Kuota</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link active"
                                        href="{{route('renderBindProdiMand')}}">Binding</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
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
                                <div class="table-responsive">
                                    <table class="table table-striped" id="tbl-bindprodimandiri">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Id Prodi</th>
                                                <th scope="col">Prodi</th>
                                                <th scope="col">Kelompok Belajar</th>
                                                <th scope="col">Kuota</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>        

                            </div>
                        </div>
                        <div class="card-footer row">

                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="binding" hidden>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="my-2">Binding Data Program Studi</h4>
                    </div>
                    <form id="bindingFrom" url="{{ route('api_detailBindProdiMand') }}" onsubmit="binding()">
                    @csrf
                        <div class="card-body">
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Id Program Studi</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" id="id" name="id_prodi" class="form-control" readonly/>
                                    <input type="text" id="id_obj" name="id_obj" class="form-control" hidden/>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Program Studi</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" id="prodi" name="prodi" class="form-control" readonly />
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Program Studi (Binding)</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" id="input_prodi" name="bind_prodi" class="form-control" placeholder="Binding" required/>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tahun</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="number" id="tahun" name="periode" class="form-control" placeholder="Input Tahun" value="{{now()->year}}" required />
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Template tahun</label>
                                <div class="col-sm-12 col-md-7">
                                    <select class="custom-select" id="tahuntemplate" onclick="">
                                        <option value="tahun">Tahun Terdata</option>
                                        <p id="tahuntemplate_select"></p>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-4 d-flex justify-content-center">
                                <label class="custom-switch col-7 " style="margin-left: 3.6rem">
                                    <input type="checkbox"
                                        id="flexCheckDefault"
                                        name="custom-switch-checkbox"
                                        class="custom-switch-input" onclick="cek()">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Nama Prodi Sesuai</span>
                                </label>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7">
                                    <button class="btn btn-success" type="submit">Submit</button>
                                    <input class="btn btn-danger ml-2"type="button" value="Close" onclick="tutup()">
                                </div>
                            </div>
                        </div>
                    </form>
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
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('js/stisla.js') }}"></script>
<script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- Page Specific JS File -->
<!-- <script src="../../js/table.js"></script> -->
<script src="../../js/style.js"></script>
<!-- <script src="../../js/prodi.js"></script> -->
<script src="../../js/bind-prodi-mandiri.js"></script>
<script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>

@endpush