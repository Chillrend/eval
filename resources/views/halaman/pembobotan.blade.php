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
                                <select class="form-control" name="pendidikan" id="pendidikan" onchange="sendPend()" url="{{route('api_dataBobot')}}" disabled>
                                    <option selected hidden disabled>Pilih Pendidikan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card" id="datatable">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="align-items-left">
                                    <button type="submit" class="btn btn-primary" id="modal-add" url="{{route('api_dataBobot')}}" onclick="showForm()"><i class="fas fa-plus"></i> Add</button>
                                </div>
                            </div>
                            <div class="table-responsive" id="table-responsive">
                                '<table class="table-hover table-md table display nowrap" id="tbl-bobot">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</i></th>
                                            <th scope="col">Kolom</th>
                                            <th scope="col">Nilai</th>
                                            <th scope="col"><i class="fas fa-star"></i></th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
                                    </tbody>
                                </table>
                            </div>
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
                    <div class="card-body">
                        <form class="form-group">
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kolom</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control" name="id-bobot" id="id-bobot" readonly hidden>

                                    <select type="number" class="form-control" name="kolom" id="kolom" onchange="sendKolom()" url="{{route('api_nilaiBobot')}}" required>
                                        <option selected hidden>Pilih Kolom</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tipe Pembobotan</label>
                                <div class="col-sm-12 col-md-7">
                                    <div class="custom-switches-stacked mt-2" onclick="sendTipe()">
                                        <label class="custom-switch pl-0">
                                            <input type="radio" name="tipe" id="prioritasbtn" value="prioritas" class="custom-switch-input" disabled>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Prioritas (Data akan DIPRIORITASKAN tanpa perhitungan akhir)</span>
                                        </label>
                                        <label class="custom-switch pl-0">
                                            <input type="radio" name="tipe" id="bobotbtn" value="pembobotan" class="custom-switch-input" disabled>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Bobot (Data BOBOT PADA NILAI akan masuk perhitungan akhir)</span>
                                        </label>
                                        <label class="custom-switch pl-0">
                                            <input type="radio" name="tipe" id="tambahanbtn" value="tambahan" class="custom-switch-input" checked disabled>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Tambahan (SELURUH NILAI akan masuk perhitungan akhir)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nilai</label>
                                <div class="col-sm-12 col-md-7">
                                    <select type="number" class="form-control" name="nilai" id="nilai" required disabled>
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
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7">
                                    <button class="btn btn-success" type="button" onclick="addCriteria()" id="submitBtn" url="{{route('api_insertBobot')}}">Submit</button>
                                    <button class="btn btn-success" type="button" onclick="editCriteria()" id="submit-editBtn" url="{{route('api_editBobot')}}">Edit</button>
                                    <button class="btn btn-danger ml-2" type="button" onclick="tutup()">Close</button>
                                </div>
                            </div>
                        </form>
                        <div id="link-delete" url="{{route('api_deleteBobot')}}"></div>
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
<script src="../../js/bobot.js"></script>
<script src="../../js/style.js"></script>
@endpush