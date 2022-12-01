@extends('layouts.app')

@section('title', 'Default Layout')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap4.min.css" />

@endpush

@section('main')
<div class="main-content" id="main-content" url="{{route('api_renderPreviewMand')}}">
    <section class="section">
        <div class="section-header">
            <h1>Data Mahasiswa Seleksi Mandiri</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Seleksi Mandiri</a></div>
                <div class="breadcrumb-item"><a href="#">Preview</a></div>
                <div class="breadcrumb-item">Preview Data Mahasiswa Seleksi Mandiri</div>
            </div>
        </div>
        <div id="">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="my-2 ">Tabel Preview Data Mahasiswa</h4>
                            <div class="col-12 col-xl-4 col-lg-5 col-md-6 col-sm-12 p-0 m-0 row justify-content-between align-items-center">
                                <div class="progress col-3 col-xl-3 col-lg-3 col-md-3 col-sm-8 p-0" data-height="20">
                                    <div class="progress-bar" id="progress-bar" role="progressbar" data-width="0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <h5 class="badge badge-primary col-3 m-0" id="status"></h5>
                                <div class="d-flex col-12 col-xl-5 col-lg-5 col-md-5 col-sm-12 my-2 p-0">
                                    <select class="form-control" name="tahun_terdaftar" id="tahun_terdaftar" onchange="gantiTahun()">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="card-body">
                                <div class="table-responsive" id="table-responsive">
                                    <table class="table-hover table display nowrap" id="tbl-preview" style="width: 100%">

                                    </table>
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
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.3/js/select.bootstrap4.js"></script>
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="../../js/preview-tes.js"></script>
<script src="../../js/table.js"></script>
<script src="../../js/style.js"></script>
@endpush