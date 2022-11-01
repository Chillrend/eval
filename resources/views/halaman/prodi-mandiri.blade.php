@extends('layouts.app')

@section('title', 'Form Prodi Mandiri')

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
                <h1>Form Kuota Prodi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Seleksi Mandiri</a></div>
                    <div class="breadcrumb-item"><a href="#">Program Studi</a></div>
                    <div class="breadcrumb-item">Form Kuota Prodi</div>
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
                                    <h2>Selamat Datang di Halaman Program Studi</h2>
                                    <p class="lead">Silahkan upload data program studi dengan file excel.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div id="">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="my-2">Upload Data Kuota Prodi</h4>
                            </div>
                            <div>
                                @if(session()->has('success'))
                            <div class="alert alert-success alert-has-icon alert-dismissible show fade">
                                <div class="alert-icon"><i class="fas fa-check"></i></div>
                                <div class="alert-body">
                                    <div class="alert-title">Impor Berhasil</div>
                                    {{session('success')}}
                                </div>
                                <button class="close" data-dismiss="alert">
                                    <i class="fas fa-times fa-lg"></i>
                                </button>
                            </div>
                            @endif
                            @if(session()->has('error'))
                            <div class="mx-4 alert alert-danger alert-has-icon alert-dismissible show fade">
                                <div class="alert-icon"><i class="fas fa-exclamation"></i></div>
                                <div class="alert-body">
                                    <div class="alert-title">Impor Gagal</div>
                                    {{session('error')}}
                                </div>
                                <button class="close" data-dismiss="alert">
                                    <i class="fas fa-times fa-lg"></i>
                                </button>
                            </div>
                            @endif
                                <form action="/prodi-mandiri" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        @csrf
                                        <div class="section-title mt-0">Pilih Periode PMB</div>
                                            <label>Choose One</label>
                                            <select class="custom-select" name="periode" id="periode" onchange="myFunction()">
                                                <option selected hidden>Tahun Periode Masuk</option>
                                                @if(count($criteria) == 0 || $criteria[count($criteria) -1]["tahun"] != now()->year)
                                                <option >{{now()->year}}</option>
                                                @foreach($criteria->reverse() as $kriteria)
                                                <option>{{$kriteria->tahun}}</option>
                                                @endforeach
                                                @else
                                                @foreach($criteria->reverse() as $kriteria)
                                                <option>{{$kriteria->tahun}}</option>
                                                @endforeach
                                                @endif
                                            </select>
    
                                        <div class="section-title">File Browser</div>
                                        <div class="input-group mb-3">
                                            <input type="file"  name="excel" class="choose form-control" id="customFile">
                                            <label class="input-group-text" for="customFile">Upload</label>
                                          </div>
    
                                                                            
                                        <div class="section-title">Nama Kolom Excel</div>
                                        <label>Cocokkan nama kolom excel dengan nama pada table</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="nameCollumn" name="nameCollumn" placeholder="Nama Kolom pada Excel">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-primary" type="button" url="{{route('criteriaProMan')}}" url-del="{{route('delcriteriaCanPres')}}" id="tambahCriteria"onclick="addCollumn()"><i class="fa-solid fa-plus fa-lg"></i> Tambah</button>
                                            </div>
                                        </div>
                                        
                                        <div id="namedkey">
                                        </div>
                                        <input type="text" class="form-control" id="banyakCollumn" name="banyakCollumn" hidden>
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
            @if($prodi->first() || $searchbar[0])
                <h2 class="section-title">Preview</h2>
                <p class="section-lead">
                    Preview data kuota program studi yang akan di upload
                </p>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header my-2">
                                <h4 class="my-2">Tabel Preview Data Kuota Prodi</h4>
                                @php
                                $abs = $criteria->first();
                                @endphp
                                 <div class="card-header-form">
                                    <form action="/prodi-mandiri" method="get">
                                        <div class="input-group">
                                            <select class="btn selectric" name="kolom" id="periode" onchange="myFunction()">
                                                <option selected hidden>{{$searchbar[0]  == null ? 'Pilih Kolom' : $searchbar[0]}}</option>
                                                @foreach($abs['criteria'] as $criteriaa)
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
                                                @foreach($abs['criteria'] as $prodia)
                                                <th scope="col">{{$prodia}}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($prodi as $prodiaa => $data)
                                            <tr>
                                                <td>{{ $prodiaa + $prodi->firstItem()}}</td>                                              
                                                <td>{{$data['periode']}}</td>
                                                @foreach($abs['criteria'] as $prodia)
                                                <td>{{$data[$prodia] == null ? '-' : $data[$prodia]}}</td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>
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

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right row">
                                    <form action="{{route('cancelProMan')}}" method="post">
                                        @csrf
                                        <button class="btn btn-lg btn-warning mx-1" id="swal-6">
                                            <h6 class="my-0">Cancel</h6>
                                        </button>
                                    </form>
                                    <form action="{{route('saveProMan')}}" method="post">
                                        @csrf
                                        <button class="btn btn-lg btn-success mx-1" id="swal-6">
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
    <script src="../../js/prodi-mandiri.js"></script>
    <script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>
@endpush

