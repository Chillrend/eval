@extends('layouts.app')

@section('title', 'Form')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">

@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Bootstrap Components</a></div>
                    <div class="breadcrumb-item">Form</div>
                </div>
            </div>
 
            <div class="section-body">
                <h2 class="section-title">Upload Data Calon Mahasiswa</h2>
                <p class="section-lead">
                    Upload data calon mahasiswa lewat file spreadsheet
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data</h4>
                            </div>
                            <form action="/import-candidates" method="post" enctype="multipart/form-data">
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
                                    <div class="custom-file">
                                        <!-- <input type="file"
                                                name="excel"
                                            class="custom-file-input"
                                            id="customFile"> -->
                                        <label class="custom-file-label"
                                            for="customFile">Choose file</label>
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
                    Preview data mahasiswa yang akan di upload
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tabel Preview Data Mahasiswa</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-hover table display nowrap" id="table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Tahun Periode</th>
                                                <th scope="col">No Daftar</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Id Pilihan 1</th>
                                                <th scope="col">Id Pilihan 2</th>
                                                <th scope="col">Id Pilihan 3</th>
                                                <th scope="col">Kode Kelompok Bidang</th>
                                                <th scope="col">Alamat</th>
                                                <th scope="col">Sekolah</th>
                                                <th scope="col">No Telp</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($candidates as $candidate)
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>{{$candidate->no_daftar}}</td>
                                                <td>{{$candidate->nama}}</td>
                                                <td>{{$candidate->id_pilihan1}}</td>
                                                <td>{{$candidate->id_pilihan2 == null ? '-' : $candidate->id_pilihan2}}</td>
                                                <td>{{$candidate->id_pilihan3 == null ? '-' : $candidate->id_pilihan3}}</td>
                                                <td>{{$candidate->kode_kelompok_bidang}}</td>
                                                <td>{{$candidate->alamat}}</td>
                                                <td>{{$candidate->sekolah}}</td>
                                                <td>{{$candidate->telp}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="m-4 p-4">
                                    {!! $candidates->links() !!}
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

    <!-- Page Specific JS File -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="../../js/table.js"></script>
@endpush

