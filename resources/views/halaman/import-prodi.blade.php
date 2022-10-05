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
                <h1>Quota Prodi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Bootstrap Components</a></div>
                    <div class="breadcrumb-item">Form</div>
                </div>
            </div>
 
            <div class="section-body">
                <h2 class="section-title">Upload Data Calon Mahasiswa</h2>
                <p class="section-lead">
                    Upload data quota program studi lewat file spreadsheet
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data</h4>
                            </div>
                            <form action="/import-prodi" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                    @csrf
                                    <div class="section-title mt-0">Pilih Periode PMB</div>
                                        <label>Choose One</label>
                                        <select class="custom-select" name="periode">
                                            <option selected hidden>Tahun Periode Masuk</option>
                                            <option>2022</option>
                                            <option>2021</option>
                                            <option>2020</option>
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
                                <div class="m-4 p-4">
                                    {!! $prodi->links() !!}
                                </div>
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

    <!-- Page Specific JS File -->
    <script src="../../js/table.js"></script>
@endpush

