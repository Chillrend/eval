@extends('layouts.app')

@section('title', 'Default Layout')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
    href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">

@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Mahasiswa Seleksi Prestasi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Preview Prestasi</a></div>
                    <div class="breadcrumb-item"><a href="#">Seleksi Prestasi</a></div>
                    <div class="breadcrumb-item">Data Mahasiswa Seleksi Prestasi</div>
                </div>
            </div>
                    <h2 class="section-title">Preview</h2>
                    <p class="section-lead">
                        Preview data prestasi mahasiswa seleksi prestasi
                    </p>
    
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="my-2">Tabel Preview Data Prestasi Mahasiswa</h4>
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
                                    <?php $no=1; ?>
                                    @foreach($prestasi as $prestasis => $data)
                                    <tr>
                                        <th scope="row">{{ $prestasis + $prestasi->firstItem()}}</th>                                              
                                        <td>{{$data->tahun_periode}}</td>
                                        <td>{{$data->no_daftar}}</td>
                                        <td>{{$data->nama}}</td>
                                        <td>{{$data->id_pilihan1}}</td>
                                        <td>{{$data->id_pilihan2 == null ? '-' : $data->id_pilihan2}}</td>
                                        <td>{{$data->id_pilihan3 == null ? '-' : $data->id_pilihan3}}</td>
                                        <td>{{$data->kode_kelompok_bidang}}</td>
                                        <td>{{$data->alamat}}</td>
                                        <td>{{$data->sekolah}}</td>
                                        <td>{{$data->telp}}</td>
                                    </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="card-footer row">
                        <div class="col-sm-12 col-md-5">
                            <p> {{ $prestasi->firstItem() }} of {{ $prestasi->lastItem() }} from {{ $prestasi->total() }} contents</p>
                        </div>
                        <div class="col-sm-12 col-md-5 pagination">
                        {!! $prestasi->links("pagination::bootstrap-4") !!}
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