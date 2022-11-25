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
        href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Data Calon Mahasiswa</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Seleksi Mandiri</a></div>
                    <div class="breadcrumb-item"><a href="#">Data Mahasiswa</a></div>
                    <div class="breadcrumb-item">Form Data Calon Mahasiswa</div>
                </div>
            </div>
            <div class="row" id="hero-awal">
                <div class="col-12 mb-0">
                    <div class="alert alert-primary alert-dismissible show fade">
                        <div class="alert-body">
                            <div class="hero bg-primary text-white">
                                <button class="close" id="bt-close"
                                    data-dismiss="hero">
                                    <i class="fa fa-times fa-sm"></i>
                                </button>
                                <div class="hero-inner" id="hero-inner">
                                    <h2>Selamat Datang di Halaman Data Mahasiswa</h2>
                                    <p class="lead">Silahkan upload data mahasiswa seleksi mandiri dengan file excel.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div id="accordion">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="my-2">Upload Data Calon Mahasiswa</h4>
                            </div>
                                @if(session()->has('success'))
                                <div class="alert alert-success alert-has-icon alert-dismissible show fade" id="alert-notif">
                                    <div class="alert-icon"><i class="fas fa-check"></i></div>
                                    <div class="alert-body">
                                        <div class="alert-title">Impor Berhasil</div>
                                        {{session('success')}}
                                    </div>
                                    <button id="bt-close-alert" class="close" data-dismiss="alert">
                                        <i class="fas fa-times fa-lg"></i>
                                    </button>
                                </div>
                                @endif
                                @if(session()->has('error'))
                                <div class="mx-4 alert alert-danger alert-has-icon alert-dismissible show fade" id="alert-notif">
                                    <div class="alert-icon"><i class="fas fa-exclamation"></i></div>
                                    <div class="alert-body">
                                        <div class="alert-title">Impor Gagal</div>
                                        {{session('error')}}
                                    </div>
                                    <button id="bt-close-alert" class="close" data-dismiss="alert">
                                        <i class="fas fa-times fa-lg"></i>
                                    </button>
                                </div>
                                @endif

                            <div class="">
                            <form action="/candidates-mandiri" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                    @csrf
                                    <div class="section-title mt-0">Pilih Periode PMB</div>
                                        <label>Masukkan Tahun Periode</label>
                                        <input type="number" class="form-control" id="tahunperiode" name="tahunperiode" placeholder="Input Tahun" value="{{now()->year}}">
                                        
                                        <div class="section-title">File Browser</div>
                                        <div class="input-group mb-3">
                                            <input type="file"  name="excel" class="choose form-control" id="customFile">
                                            <label class="input-group-text" for="customFile">Upload</label>
                                        </div>
                                        
                                        <div class="section-title">Nama Kolom Excel</div>
                                        <label>Template Tabel</label>
                                        <select class="form-control " name="periode" id="periode" onchange="myFunction()">
                                            <option selected hidden>Tahun Tabel</option>
                                            @foreach($criteria->reverse() as $periode)
                                            <option>{{$periode->tahun}}</option>
                                            @endforeach
                                        </select>
                                        <label class="mt-3">Cocokkan nama kolom excel dengan nama pada table</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="nameCollumn" name="nameCollumn" placeholder="Nama Kolom pada Excel">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-primary" type="button" url="{{route('criteriaCanMan')}}" url-del="" id="tambahCriteria" onclick="addCollumn()"><i class="fa-solid fa-plus fa-lg"></i> Tambah</button>
                                            </div>
                                        </div>
                                        
                                        <div id="namedkey">
                                        </div>
                                        <input type="text" class="form-control" id="banyakCollumn" name="banyakCollumn" value="0" hidden>
                                    </div>
                                    <div class="card-footer text-right">
                                        <input type="submit" class="btn btn-primary"/>
                                    </div>
                                </form>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
            {{-- @if($candidates != '') --}}
            {{-- @if($candidates->first() && $searchbar || $candidates != '') --}}
            {{-- @if($candidates->first() || $searchbar ) --}}
            @if($candidates->first() || $searchbar[0])
                <h2 class="section-title">Preview</h2>
                <p class="section-lead">
                    Preview data mahasiswa yang akan diupload
                </p>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header my-2">
                                <h4>Tabel Preview</h4>      
                                @php
                                $abs = $criteria->first();
                                @endphp                       
                                <div class="card-header-form">
                                    <form  action="/candidates-mandiri" method="get">
                                        <div class="input-group">
                                            <select class="btn selectric" name="kolom" id="periode" onchange="myFunction()">
                                                <option selected hidden>{{$searchbar[0]  == null ? 'Pilih Kolom' : $searchbar[0]}}</option>
                                                @foreach($abs['kolom'] as $criteriaa)
                                                <option>{{$criteriaa}}</option>
                                                @endforeach
                                            </select>
                                            &nbsp; &nbsp;
                                            <input type="text" class="form-control" name="search" placeholder="Search" value="{{$searchbar[1]}}">
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>       
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(session()->has('error1'))
                                    <div class="alert alert-danger alert-has-icon alert-dismissible show fade">
                                        <div class="alert-icon"><i class="fas fa-exclamation"></i></div>
                                        <div class="alert-body">
                                            <div class="alert-title">Data Tidak Ditemukan</div>
                                            {{session('error1')}}
                                        </div>
                                        <button class="close" data-dismiss="alert">
                                            <i class="fas fa-times fa-lg"></i>
                                        </button>
                                    </div>
                                @endif
                                
                                <div class="table-responsive">
                                    <table class="table-hover table display nowrap" id="table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">periode</th>
                                                @foreach($abs['kolom'] as $criteriaa)
                                                <th scope="col">{{$criteriaa}}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($candidates as $candidate => $data)
                                            <tr>
                                                <td>{{ $candidate + $candidates->firstItem()}}</td>                                              
                                                <td>{{$data['periode']}}</td>
                                                @foreach($abs['kolom'] as $criteriaa)
                                                <td>{{$data[$criteriaa] == null ? '-' : $data[$criteriaa]}}</td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer row">
                                <div class="col-sm-12 col-md-5">
                                    <p> {{ $candidates->firstItem() }} of {{ $candidates->lastItem() }} from {{ $candidates->total() }} contents</p>
                                </div>
                                <div class="pagination" style="justify-content: center">
                                {!! $candidates->links("pagination::bootstrap-4") !!}
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right row">
                                    <span>
                                        <form method="POST" action="cancelmandiri">
                                            @csrf
                                                <button class="btn btn-lg btn-warning mx-1" href="route('cancelmandiri')">
                                                    <h6 class="my-0">Cancel</h6>
                                                </button>
                                        </form>
                                    </span>
                                    <form method="POST" action="savemandiri">
                                        @csrf
                                        <button class="btn btn-lg btn-success mx-1"  href="route('savemandiri')" >
                                            <h6 class="my-0">Save</h6>
                                        </button>
                                    </form>
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
    <script src="assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('library/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>


    <!-- Page Specific JS File -->
    <script src="../../js/table.js"></script>
    <script src="../../js/style.js"></script>
    <script src="../../js/candidate-mandiri.js"></script>
    <script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>
@endpush

