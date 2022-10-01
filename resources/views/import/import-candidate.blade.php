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
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data</h4>
                            </div>
                            <div class="card-body">
                                <form action="/import-test" method="post" enctype="multipart/form-data">
                                    @csrf
                                <div class="section-title mt-0">Pilih Periode PMB</div>
                                <div class="form-group">
                                    <label>Choose One</label>
                                    <select class="custom-select">
                                        <option selected>Tahun Periode Masuk</option>
                                        <option value="1">2022</option>
                                        <option value="2">2021</option>
                                        <option value="3">2020</option>
                                    </select>
                                </div>

                                <div class="section-title">File Browser</div>
                                <div class="custom-file">
                                    <input type="file"
                                            name="excel"
                                           class="custom-file-input"
                                           id="customFile">
                                    <label class="custom-file-label"
                                           for="customFile">Choose file</label>
                                </div>
                                <input type="submit" class="btn btn-primary"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="section-title">Preview</h2>
                <p class="section-lead">
                    Preview data mahasiswa yang akan di upload
                </p>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tabel Preview Data Mahasiswa</h4>
                            </div>
                            <div class="card-body">
                                <table class="table-hover table nowrap" id="data-mhsw" style="width: 100%">
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
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td>@mdo</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td>Jacob</td>
                                            <td>Thornton</td>
                                            <td>@fat</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td>Larry</td>
                                            <td>the Bird</td>
                                            <td>@twitter</td>
                                        </tr>
                                    </tbody>
                                </table>
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
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $('#data-mhsw').DataTable({
                scrollX: true,
            });
        });
    </script>
@endpush

