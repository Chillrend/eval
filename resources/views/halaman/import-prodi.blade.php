@extends('layouts.app')

@section('title', 'Form')

@push('style')
    <!-- CSS Libraries -->
    {{-- <link rel="stylesheet"
        href="assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet"
        href="assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css"> --}}

    <link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Quota Prodi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Program Studi</a></div>
                    <div class="breadcrumb-item">Form Quota Prodi</div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-0">
                    <div class="alert alert-primary alert-dismissible show fade">
                        <div class="alert-body">
                            <div class="hero bg-primary text-white">
                                <div class="hero-inner">
                                    <button class="close"
                                        data-dismiss="hero">
                                    <span>&times;</span>
                                    </button>
                                    <h2>Selamat Datang di Halaman Program Studi</h2>
                                    <p class="lead">This page is a place to manage posts, categories and more.</p>
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
                            <div class="card-header accordion-header"
                                role="button"
                                data-toggle="collapse"
                                data-target="#panel-body-3">
                                <h4>Upload Data Quota Prodi</h4>
                            </div>
                            <div class="accordion-body collapse"
                                id="panel-body-3"
                                data-parent="#accordion">
                                <form action="/import-prodi" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        @csrf
                                        <div class="section-title mt-0">Pilih Periode PMB</div>
                                            <label>Choose One</label>
                                            <select class="custom-select" name="periode" id="periode" onchange="myFunction()">
                                                <option selected hidden>Tahun Periode Masuk</option>
                                                @if(count($criteria) == 0 || $criteria[count($criteria) -1]["tahun"] != now()->year)
                                                <option >{{now()->year}}</option>
                                                @foreach($criteria->reverse() as $kriteria)
                                                <option>{{$kriteria->tahun}}</option>
                                                @endforeach
                                                @else
                                                @foreach($criteria->reverse() as $kriteria)
                                                <option>{{$kriteria->tahun}}</option>
                                                @endforeach
                                                @endif
                                            </select>
    
                                        <div class="section-title">File Browser</div>
                                        <div class="input-group mb-3">
                                            <input type="file"  name="excel" class="choose form-control" id="customFile">
                                            <label class="input-group-text" for="customFile">Upload</label>
                                          </div>
    
                                                                            
                                        <div class="section-title">Nama Kolom Excel</div>
                                        <label>Cocokkan nama kolom excel dengan nama pada table</label>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Id Prodi</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control"
                                                        id="col_id_prodi"
                                                        name="col_id_prodi"
                                                        placeholder="Nama Kolom pada Excel">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Jurusan</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control"
                                                        id="col_jurusan"
                                                        name="col_jurusan"
                                                        placeholder="Nama Kolom pada Excel">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Id Politeknik</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control"
                                                        id="col_id_politeknik"
                                                        name="col_id_politeknik"
                                                        placeholder="Nama Kolom pada Excel">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Politeknik</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control"
                                                        id="col_politeknik"
                                                        name="col_politeknik"
                                                        placeholder="Nama Kolom pada Excel">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Id Kelompok Bidang</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control"
                                                        id="col_id_kelompok_bidang"
                                                        name="col_id_kelompok_bidang"
                                                        placeholder="Nama Kolom pada Excel">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Kelompok Bidang</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control"
                                                        id="col_kelompok_bidang"
                                                        name="col_kelompok_bidang"
                                                        placeholder="Nama Kolom pada Excel">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Quota</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control"
                                                        id="col_Quota"
                                                        name="col_Quota"
                                                        placeholder="Nama Kolom pada Excel">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Tertampung</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control"
                                                        id="col_tertampung"
                                                        name="col_tertampung"
                                                        placeholder="Nama Kolom pada Excel">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <input type="submit" class="btn btn-primary"/>
                                    </div>
                                </form>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>


 
            
                <h2 class="section-title">Preview</h2>
                <p class="section-lead">
                    Preview data quota program studi yang akan di upload
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tabel Preview Data Quota Prodi</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-hover table display nowrap" id="table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Id Prodi</th>
                                                <th scope="col">Jurusan</th>
                                                <th scope="col">Id Politeknik</th>
                                                <th scope="col">Politeknik</th>
                                                <th scope="col">Id Kelompok Bidang</th>
                                                <th scope="col">Kelompok Bidang</th>
                                                <th scope="col">Quota</th>
                                                <th scope="col">Tertampung</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($prodi as $quotaa => $data)
                                            <tr>
                                                <th scope="row">{{ $quotaa + $prodi->firstItem()}}</th>                                           
                                                <td>{{$data->id_prodi}}</td>
                                                <td>{{$data->jurusan}}</td>
                                                <td>{{$data->id_politeknik}}</td>
                                                <td>{{$data->politeknik}}</td>
                                                <td>{{$data->id_kelompok_bidang}}</td>
                                                <td>{{$data->kelompok_bidang}}</td>
                                                <td>{{$data->quota == null ? '-' : $data->quota}}</td>
                                                <td>{{$data->tertampung == null ? '-' : $data->tertampung}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer pagination justify-content-between">
                                <div>
                                    <p>1 of 3 from 100 contents</p>
                                </div>
                                {!! $prodi->links("pagination::bootstrap-4") !!}
                                <div class="">
                                    <button class="btn btn-warning" id="swal-6"><strong>Cancel</strong></button>
                                    <button class="btn btn-success" id="swal-6"><strong>Save</strong></button>
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
    <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script> --}}
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="../../js/table.js"></script>
    <script src="../../js/import-prodi.js"></script>
    <script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>
@endpush

