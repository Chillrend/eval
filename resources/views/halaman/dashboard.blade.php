@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="far fa-solid fa-user"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Kandidat</h4>
                                </div>
                                <div class="card-body">
                                    3122
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger">
                                <i class="far fa-solid fa-graduation-cap"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Seleksi Prestasi</h4>
                                </div>
                                <div class="card-body">
                                    522
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="far fa-solid fa-paste"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Seleksi Tes</h4>
                                </div>
                                <div class="card-body">
                                    1,201
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-sharp fa-solid fa-file-lines"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Seleksi Mandiri</h4>
                                </div>
                                <div class="card-body">
                                    1399
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Statistik Program Studi</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Statistik Pendaftar</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart2"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Cara Penggunaan Web</h4>
                            </div>
                            <div class="card-body">
                                <div class="row"> 
                                    <div class="col-12 col-sm-12 col-md-4">
                                        <ul class="nav nav-pills flex-column"
                                            id="myTab4"
                                            role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active"
                                                    id="data-tab"
                                                    data-toggle="tab"
                                                    href="#data"
                                                    role="tab"
                                                    aria-controls="data"
                                                    aria-selected="true">Data Mahasiswa</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    id="prodi-tab"
                                                    data-toggle="tab"
                                                    href="#prodi"
                                                    role="tab"
                                                    aria-controls="prodi"
                                                    aria-selected="false">Program Studi</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    id="preview-tab"
                                                    data-toggle="tab"
                                                    href="#preview"
                                                    role="tab"
                                                    aria-controls="preview"
                                                    aria-selected="false">Preview</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    id="filter-tab4"
                                                    data-toggle="tab"
                                                    href="#filter"
                                                    role="tab"
                                                    aria-controls="filter"
                                                    aria-selected="false">Filter</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-8">
                                        <div class="tab-content no-padding"
                                            id="myTab2Content">
                                            <div class="tab-pane fade show active"
                                                id="data"
                                                role="tabpanel"
                                                aria-labelledby="data-tab">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                                non
                                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                            </div>
                                            <div class="tab-pane fade"
                                                id="prodi"
                                                role="tabpanel"
                                                aria-labelledby="prodi-tab">
                                                Sed sed metus vel lacus hendrerit tempus. Sed efficitur velit tortor, ac
                                                efficitur est lobortis quis. Nullam lacinia metus erat, sed fermentum justo
                                                rutrum ultrices. Proin quis iaculis tellus. Etiam ac vehicula eros, pharetra
                                                consectetur dui. Aliquam convallis neque eget tellus efficitur, eget maximus
                                                massa imperdiet. Morbi a mattis velit. Donec hendrerit venenatis justo, eget
                                                scelerisque tellus pharetra a.
                                            </div>
                                            <div class="tab-pane fade"
                                                id="preview"
                                                role="tabpanel"
                                                aria-labelledby="preview-tab">
                                                Vestibulum imperdiet odio sed neque ultricies, ut dapibus mi maximus. Proin
                                                ligula massa, gravida in lacinia efficitur, hendrerit eget mauris.
                                                Pellentesque fermentum, sem interdum molestie finibus, nulla diam varius
                                                leo, nec varius lectus elit id dolor. Nam malesuada orci non ornare
                                                vulputate. Ut ut sollicitudin magna. Vestibulum eget ligula ut ipsum
                                                venenatis ultrices. Proin bibendum bibendum augue ut luctus.
                                            </div>
                                            <div class="tab-pane fade"
                                                id="filter"
                                                role="tabpanel"
                                                aria-labelledby="filter-tab">
                                                Vestibulum imperdiet odio sed neque ultricies, ut dapibus mi maximus. Proin
                                                ligula massa, gravida in lacinia efficitur, hendrerit eget mauris.
                                                Pellentesque fermentum, sem interdum molestie finibus, nulla diam varius
                                                leo, nec varius lectus elit id dolor. Nam malesuada orci non ornare
                                                vulputate. Ut ut sollicitudin magna. Vestibulum eget ligula ut ipsum
                                                venenatis ultrices. Proin bibendum bibendum augue ut luctus.
                                            </div>
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
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/statistik.js') }}"></script>
@endpush
