@extends('layouts.app')

@section('title', 'Preview')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.bootstrap4.min.css" />
@endpush

@section('main')
<div class="main-content" id="main-content" url="{{route('api_renderPreviewMand')}}">
    <section class="section">
        <div class="section-header  d-flex justify-content-between align-items-center">
            <h1>Data Mahasiswa Seleksi Mandiri</h1>
            <div class="col-12 col-xl-2 col-lg-3 col-md-4 col-sm-4 p-0 ml-1 align-items-end">
                <div class="d-flex col-12 p-0">
                    <select class="form-control" name="tahun_terdaftar" id="tahun_terdaftar" onchange="gantiTahun()">
                    </select>
                </div>
            </div>
        </div>
        <div id="data-kosong">
            <div class="alert alert-danger alert-has-icon">
                <div class="alert-icon"><i class="fas fa-exclamation"></i></div>
                <div class="alert-body">
                    <div class="alert-title">Data Kosong</div>
                    <p id="alert-text"></p>
                </div>
            </div>
        </div>
        <div class="row" id="card-done">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="my-2 ">Preview Finish</h4>
                    </div>
                    <div>
                        <div class="card-body">
                            <div class="table-responsive" id="table-responsive-done">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="card-filter">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="my-2 ">Preview Filter</h4>
                    </div>
                    <div>
                        <div class="card-body">
                            <div class="table-responsive" id="table-responsive-filter">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="card-import">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="my-2" id="header-card-import">Preview Import</h4>
                    </div>
                    <div>
                        <div class="card-body">
                            <div class="table-responsive" id="table-responsive-import">
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


<!-- Page Specific JS File -->
<script src="../../js/preview-mandiri.js"></script>
<script src="../../js/style.js"></script>
@endpush