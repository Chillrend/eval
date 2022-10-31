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
                                {{ $prestasi = DB::table('candidate_pres')->count(); }}
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
                                {{ $tes = DB::table('candidate_tes')->count(); }}
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
                                {{ $mandiri = DB::table('candidate_mand')->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Progress Input Data</h4> 
                        </div>
                        <div class="card-body">
                            <div id="accordion">
                                <div class="accordion">
                                    <div class="accordion-header"
                                        role="button"
                                        data-toggle="collapse"
                                        data-target="#panel-body-1"
                                        aria-expanded="true">
                                        <h4>Seleksi Prestasi</h4>
                                    </div>
                                    <div class="accordion-body collapse show"
                                        id="panel-body-1"
                                        data-parent="#accordion">
                                        <p class="mb-0">Import Data Mahasiswa</p>
                                        <div class="progress mb-3">
                                            <div class="progress-bar"
                                                role="progressbar"
                                                data-width="50%"
                                                aria-valuenow="50"
                                                aria-valuemin="0"
                                                aria-valuemax="100">50%</div>
                                        </div>
                                        <p class="mb-0">Import Program Studi</p>
                                        <div class="progress mb-3">
                                            <div class="progress-bar"
                                                role="progressbar"
                                                aria-valuenow="0"
                                                aria-valuemin="0"
                                                aria-valuemax="100">0</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion">
                                    <div class="accordion-header"
                                        role="button"
                                        data-toggle="collapse"
                                        data-target="#panel-body-2">
                                        <h4>Seleksi Tes</h4>
                                    </div>
                                    <div class="accordion-body collapse"
                                        id="panel-body-2"
                                        data-parent="#accordion">
                                        <p class="mb-0">Import Data Mahasiswa</p>
                                        <div class="progress mb-3">
                                            <div class="progress-bar"
                                                role="progressbar"
                                                aria-valuenow="0"
                                                aria-valuemin="0"
                                                aria-valuemax="100">0</div>
                                        </div>
                                        <p class="mb-0">Import Program Studi</p>
                                        <div class="progress mb-3">
                                            <div class="progress-bar"
                                                role="progressbar"
                                                aria-valuenow="0"
                                                aria-valuemin="0"
                                                aria-valuemax="100">0</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion">
                                    <div class="accordion-header"
                                        role="button"
                                        data-toggle="collapse"
                                        data-target="#panel-body-3">
                                        <h4>Seleksi Mandiri</h4>
                                    </div>
                                    <div class="accordion-body collapse"
                                        id="panel-body-3"
                                        data-parent="#accordion">
                                        <p class="mb-0">Import Data Mahasiswa</p>
                                        <div class="progress mb-3">
                                            <div class="progress-bar"
                                                role="progressbar"
                                                aria-valuenow="0"
                                                aria-valuemin="0"
                                                aria-valuemax="100">0</div>
                                        </div>
                                        <p class="mb-0">Import Program Studi</p>
                                        <div class="progress mb-3">
                                            <div class="progress-bar"
                                                role="progressbar"
                                                aria-valuenow="0"
                                                aria-valuemin="0"
                                                aria-valuemax="100">0</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Activities</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                <li class="media">
                                    <img class="rounded-circle mr-3"
                                        width="50"
                                        src="{{ asset('img/avatar/avatar-1.png') }}"
                                        alt="avatar">
                                    <div class="media-body">
                                        <div class="text-primary float-right">Now</div>
                                        <div class="media-title">Farhan A Mujib</div>
                                        <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla.
                                            Nulla vel metus scelerisque ante sollicitudin.</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <img class="rounded-circle mr-3"
                                        width="50"
                                        src="{{ asset('img/avatar/avatar-2.png') }}"
                                        alt="avatar">
                                    <div class="media-body">
                                        <div class="float-right">12m</div>
                                        <div class="media-title">Ujang Maman</div>
                                        <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla.
                                            Nulla vel metus scelerisque ante sollicitudin.</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <img class="rounded-circle mr-3"
                                        width="50"
                                        src="{{ asset('img/avatar/avatar-3.png') }}"
                                        alt="avatar">
                                    <div class="media-body">
                                        <div class="float-right">17m</div>
                                        <div class="media-title">Rizal Fakhri</div>
                                        <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla.
                                            Nulla vel metus scelerisque ante sollicitudin.</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <img class="rounded-circle mr-3"
                                        width="50"
                                        src="{{ asset('img/avatar/avatar-4.png') }}"
                                        alt="avatar">
                                    <div class="media-body">
                                        <div class="float-right">21m</div>
                                        <div class="media-title">Alfa Zulkarnain</div>
                                        <span class="text-small text-muted">Cras sit amet nibh libero, in gravida nulla.
                                            Nulla vel metus scelerisque ante sollicitudin.</span>
                                    </div>
                                </li>
                            </ul>
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
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush
