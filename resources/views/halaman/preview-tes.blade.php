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
                <h1>Data Mahasiswa Seleksi Tes</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Seleksi Tes</a></div>
                    <div class="breadcrumb-item"><a href="#">Preview</a></div>
                    <div class="breadcrumb-item">Data Mahasiswa Seleksi Tes</div>
                </div>
            </div>
            <h2 class="section-title">Preview</h2>
            <p class="section-lead">
                Preview data mahasiswa seleksi tes dan kuota program studi
            </p>
            @if($candidates->first())
            <div id="">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header" >
                                <h4 class="my-2">Tabel Preview Data Mahasiswa</h4>
                            </div>
                            <div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table-hover table display nowrap" id="table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">periode</th>
                                                    @foreach($criteria_can['criteria'] as $criteriaa)
                                                    <th scope="col">{{$criteriaa}}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($candidates as $candidate => $data)
                                                <tr>
                                                    <td>{{ $candidate + $candidates->firstItem()}}</td>                                              
                                                    <td>{{$data['periode']}}</td>
                                                    @foreach($criteria_can['criteria'] as $criteriaa)
                                                    <td>{{$data[$criteriaa] == null ? '-' : $data[$criteriaa]}}</td>
                                                    @endforeach
                                                </tr>
                                                @endforeach
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer row">
                                    <div class="col-sm-12 col-md-5">
                                        <p> {{ $candidates->firstItem() }} of {{ $candidates->lastItem() }} from {{ $candidates->total() }} contents</p>
                                    </div>
                                    <div class="col-sm-12 col-md-5 pagination">
                                    {!! $candidates->links("pagination::bootstrap-4") !!}
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($prodi->first())
            <div id="">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header" >
                                <h4 class="my-2">Tabel Preview Data Prodi</h4>
                            </div>
                            <div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table-hover table display nowrap" id="table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">periode</th>
                                                    @foreach($criteria_pro['criteria'] as $criteriaa)
                                                    <th scope="col">{{$criteriaa}}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($prodi as $candidate => $data)
                                                <tr>
                                                    <td>{{ $candidate + $prodi->firstItem()}}</td>                                              
                                                    <td>{{$data['periode']}}</td>
                                                    @foreach($criteria_pro['criteria'] as $criteriaa)
                                                    <td>{{$data[$criteriaa] == null ? '-' : $data[$criteriaa]}}</td>
                                                    @endforeach
                                                </tr>
                                                @endforeach
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer row">
                                    <div class="col-sm-12 col-md-5">
                                        <p> {{ $prodi->firstItem() }} of {{ $prodi->lastItem() }} from {{ $prodi->total() }} contents</p>
                                    </div>
                                    <div class="col-sm-12 col-md-5 pagination">
                                    {!! $prodi->links("pagination::bootstrap-4") !!}
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
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
    <script src="../../js/style.js"></script>
@endpush
