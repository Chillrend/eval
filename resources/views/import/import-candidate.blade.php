@extends('layouts.app')

@section('title', 'Form')

@push('style')
    <!-- CSS Libraries -->
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
                                <div class="section-title mt-0">Pilih Periode PMB</div>
                                <div class="form-group">
                                    <label>Choose One</label>
                                    <select class="custom-select">
                                        <option selected>Open this select menu</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>

                                <div class="section-title">File Browser</div>
                                <div class="custom-file">
                                    <input type="file"
                                           class="custom-file-input"
                                           id="customFile">
                                    <label class="custom-file-label"
                                           for="customFile">Choose file</label>
                                </div>
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
@endpush

