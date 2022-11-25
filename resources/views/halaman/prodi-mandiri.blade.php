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
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">

@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Kuota Program Studi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="#">Seleksi Mandiri</a></div>
                <div class="breadcrumb-item"><a href="#">Program Studi</a></div>
                <div class="breadcrumb-item">Data Kuota Program Studi</div>
            </div>
        </div>


        <div id="">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active"
                                        href="{{  url('prodi-mandiri') }}">Data</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="#">Kuota</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{route('renderBindProdiMand')}}">Binding</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="align-items-left">
                                    <button type="submit" class="btn btn-primary" id="modal-add"><i class="fas fa-plus"></i> Add</button>
                                </div>

                                <div class="align-items-right">
                                    <form action="/prodi-mandiri" method="get">
                                        <div class="input-group">
                                            <select class="btn selectric" name="kolom" id="periode" onchange="myFunction()">
                                                <option selected disabled class="hidden">{{$searchbar[0]  == null ? 'Pilih Kolom' : $searchbar[0]}}</option>
                                                <option value="id_prodi">Id Prodi</option>
                                                <option value="prodi">Prodi</option>
                                                <option value="kelompok_belajar">Kelompok Belajar</option>
                                                <option value="kuota">Kuota</option>
                                            </select>
                                            &nbsp; &nbsp;
                                            <input type="text" class="form-control" name="search" placeholder="Search" value="{{$searchbar[1]}}">
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-primary form-control"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br>

                            @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close"
                                            data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                        {{ session('success') }}
                                    </div>
                                </div>
                            @endif

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close"
                                            data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                        {{ $error }}
                                    </div>
                                </div>
                                @endforeach
                            @endif

                            <br>
                            <div class="">
                                <table class="table-hover table-md table display nowrap" id="table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Id Prodi</th>
                                            <th scope="col">Prodi</th>
                                            <th scope="col">Kelompok Belajar</th>
                                            <th scope="col">Kuota</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($prodi->first())
                                            @foreach($prodi as $prodii => $data)
                                            <tr id="row-{{ $prodii + $prodi->firstItem()}}">
                                                <td>{{ $prodii + $prodi->firstItem()}}</td>                                              
                                                <td>{{$data['id_prodi']}}</td>
                                                <td>{{$data['prodi']}}</td>
                                                <td>{{$data['kelompok_bidang']}}</td>
                                                <td>{{$data['kuota']}}</td>
                                                <td>
                                                    <div class="row m-0">
                                                        <button class="btn btn-icon btn-warning m-1" id="editBtn" onclick="editBtn({{ $prodii + $prodi->firstItem()}})" ><i class="fas fa-edit"></i></button>
                                                        <form action="{{route('delProdiMand',['id' => $data['_id']])}}" method="post">
                                                            @csrf
                                                            <button class="btn btn-icon btn-danger m-1" id="deleteBtn" ><i class="fas fa-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr id="row-edit-{{ $prodii + $prodi->firstItem()}}" style="display: none;">
                                                <form action="{{route('editProdiMand',['id' => $data['_id']])}}" method="post">
                                                    @csrf
                                                    <td>{{ $prodii + $prodi->firstItem()}}</td>                                              
                                                    <td>
                                                        <input type="number" class="form-control" placeholder="Id Prodi" name="id_prodi" value="{{$data['id_prodi']}}" required>
                                                    </td>                                              
                                                    <td>
                                                        <input type="text" class="form-control" placeholder="Program Studi" name="prodi" value="{{$data['prodi']}}" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" placeholder="Kelompok Bidang" name="kelompok_bidang" value="{{$data['kelompok_bidang']}}" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" placeholder="Kuota" name="kuota" value="{{$data['kuota']}}" required>
                                                    </td>
                                                    <td>
                                                        <div class="row m-0">
                                                            <button type="submit" class="btn btn-icon btn-success m-1" ><i class="fas fa-check"></i></button>
                                                            <button type="button" class="btn btn-icon btn-danger m-1 btnclose" id="closeBtn" onclick="closeButton({{ $prodii + $prodi->firstItem()}})" ><i class="fas fa-times"></i></button>
                                                        </div>
                                                    </td>
                                                </form>
                                            </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <td colspan=6 >
                                                <div class="alert alert-danger">
                                                    <div class="d-flex justify-content-center">
                                                        Data Kosong
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <input type="submit" class="btn btn-primary" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <form class="modal-part" id="modal-add-prodi" action="{{route('addProdiMand')}}" method="post">
        @csrf
        <p>Tambahkan Data <code>Program Studi</code> Terbaru</p>
        <div class="form-group">
            <label>Nomor Program Studi</label>
            <input type="number" class="form-control" placeholder="Id Prodi" name="id_prodi" required>
        </div>
        <div class="form-group">
            <label>Program Studi</label>
            <input type="text" class="form-control" placeholder="Program Studi" name="prodi" required>
        </div>
        <div class="form-group">
            <label>Kelompok Bidang</label>
            <input type="text" class="form-control" placeholder="Kelompok Bidang" name="kelompok_bidang" required>
        </div>
        <div class="form-group">
            <label>Kuota</label>
            <input type="number" class="form-control" placeholder="Kuota" name="kuota" required>
        </div>
        <div class="d-flex justify-content-end">
            <input type="submit" class="btn btn-primary btn-shadow" value="Tambah">
        </div>
    </form>

    @foreach($prodi as $prodii => $data)
    <form class="modal-part" id="modal-edit-prodi-{{ $prodii + $prodi->firstItem()}}" action="{{route('editProdiPres',['id' => $data['_id']])}}" method="post">
        @csrf
        <p>Tambahkan Data <code>Program Studi</code> Terbaru</p>
        <div class="form-group">
            <label>Nomor Program Studi</label>
            <input type="number" class="form-control" placeholder="Id Prodi" name="id_prodi" value="{{$data['id_prodi']}}" required>
        </div>
        <div class="form-group">
            <label>Program Studi</label>
            <input type="text" class="form-control" placeholder="Program Studi" name="prodi" value="{{$data['prodi']}}" required>
        </div>
        <div class="form-group">
            <label>Kelompok Bidang</label>
            <input type="text" class="form-control" placeholder="Kelompok Bidang" name="kelompok_bidang" value="{{$data['kelompok_bidang']}}" required>
        </div>
        <div class="form-group">
            <label>Kuota</label>
            <input type="number" class="form-control" placeholder="Kuota" name="kuota" value="{{$data['kuota']}}" required>
        </div>
        <div class="d-flex justify-content-end">
            <input type="submit" class="btn btn-primary btn-shadow" value="Edit">
        </div>
    </form>
    @endforeach

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
<script src="../../js/prodi.js"></script>
<script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>

@endpush