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
                <h1>Preview Data Mahasiswa Seleksi Prestasi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Seleksi Prestasi</a></div>
                    <div class="breadcrumb-item"><a href="#">Preview</a></div>
                    <div class="breadcrumb-item">Preview Data Mahasiswa Seleksi Prestasi</div>
                </div>
            </div>
            @if($candidates->first())
            <div id="">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="my-2 ">Tabel Preview Data Mahasiswa</h4>
                                <div class="col-12 col-xl-4 col-lg-5 col-md-6 col-sm-12 p-0 m-0 row justify-content-between">
                                    <div class="progress col-8 p-0 mt-1"
                                        data-height="20">
                                        <div class="progress-bar"
                                            role="progressbar"
                                            data-width="{{$status[0]}}%"
                                            aria-valuenow="{{$status[0]}}"
                                            aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <h5 class="badge badge-primary">{{$status[1]}}</h5>
                                </div>    
                            </div>
                            <div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table-hover table display nowrap" id="table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">periode</th>
                                                    @foreach($criteria as $criteriaa)
                                                    <th scope="col">{{$criteriaa}}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($candidates as $candidate => $data)
                                                <tr>
                                                    <td>{{ $candidate + $candidates->firstItem()}}</td>                                              
                                                    <td>{{$data['periode']}}</td>
                                                    @foreach($criteria as $criteriaa)
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
