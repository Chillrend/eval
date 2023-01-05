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
                                <h4>Statistik Pendaftar</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Progres Kegiatan</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="chartProgress"></canvas>
                            </div>
                            <div class="card-body">
                                <p>Keterangan :</p>
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
                                                    id="filter-tab"
                                                    data-toggle="tab"
                                                    href="#filter"
                                                    role="tab"
                                                    aria-controls="filter"
                                                    aria-selected="false">Filter</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    id="bobot-tab"
                                                    data-toggle="tab"
                                                    href="#bobot"
                                                    role="tab"
                                                    aria-controls="bobot"
                                                    aria-selected="false">Pembobotan</a>
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
                                               <div class="card-body">
                                                <h6 style="color: #6777ef">Cara Penggunaan Untuk Halaman Data Mahasiswa:</h6>
                                               </div>
                                               <ol>
                                                <li>Masukkan tahun periode pendaftaran.</li>
                                                <li>Masukkan data calon mahasiswa dengan file excel ke dalam form yang sudah disediakan.</li>
                                                <li>Masukkan tahun tabel.</li>
                                                <li>Tambahkan nama kolom excel yang akan diinput.</li>
                                                <li>Menekan tombol submit. Data akan ditampilkan pada tabel, silahkan cek kembali.</li>
                                                <li>Jika data salah, silahkan tekan tombol "Cancel" dan lakukan kegiatan penginputan data dari awal.</li>
                                                <li>Jika data benar, silahkan tekan tombol "Save" dan data akan tersimpan.</li>
                                             </ol>
                                            </div>
                                            <div class="tab-pane fade"
                                                id="prodi"
                                                role="tabpanel"
                                                aria-labelledby="prodi-tab">
                                                <div class="card-body">
                                                    <h6 style="color: #6777ef">Cara Penggunaan Untuk Halaman Program Studi:</h6>
                                                    <br>
                                                    <div id="accordion">
                                                        <div class="accordion">
                                                            <div class="accordion-header"
                                                                role="button"
                                                                data-toggle="collapse"
                                                                data-target="#panel-body-1"
                                                                aria-expanded="true">
                                                                <h4>Cara Penggunaan Halaman Data</h4>
                                                            </div>
                                                            <div class="accordion-body collapse show"
                                                                id="panel-body-1"
                                                                data-parent="#accordion">
                                                                <p class="mb-0">Pada halaman ini, Anda dapat menambah, mengubah dan menghapus data sesuai dengan data yang telah ditentukan. Berikut langka-langkah pada halaman data:</p>
                                                                <p><b>Langkah-Langkah Menambah Data:</b></p>
                                                                <ol>
                                                                    <li>Menekan tombol "Add".</li>
                                                                    <li>Mengisi data sesuai dengan data yang telah ditentukan sebelumnya.</li>
                                                                    <li>Menekan tombol "Tambah" untuk menyimpan data.</li>
                                                                </ol>
                                                                <p><b>Langkah-Langkah Mengubah Data:</b></p>
                                                                <ol>
                                                                    <li>Menekan tombol edit yang ditandai dengan simbol pena dengan warna tombol yaitu oranye.</li>
                                                                    <li>Mengubah data sesuai dengan yang sudah ditentukan.</li>
                                                                    <li>Menekan tombol "Submit", jika data sudah benar.</li>
                                                                    <li>Menekan tombol "Close", jika data tidak ingin diubah.</li>
                                                                </ol>
                                                                <p><b>Langkah-Langkah Menghapus Data:</b></p>
                                                                <ol>
                                                                    <p>Menekan tombol hapus yang ditandai dengan simbol tempat sampah dengan warna tombol yaitu merah. Maka data secara otomatis akan terhapus.</p>
                                                                </ol>
                                                            </div>
                                                        </div>
                                                        <div class="accordion">
                                                            <div class="accordion-header"
                                                                role="button"
                                                                data-toggle="collapse"
                                                                data-target="#panel-body-2">
                                                                <h4>Cara Penggunaan Halaman Binding</h4>
                                                            </div>
                                                            <div class="accordion-body collapse"
                                                                id="panel-body-2"
                                                                data-parent="#accordion">
                                                                <p class="mb-0">Pada halaman ini, Anda dapat memvalidasi kembali data program studi yang telah melalui proses tambah, ubah dan hapus pada halaman sebelumnya.</p>
                                                                <p><b>Langkah-Langkah Binding Data:</b></p>
                                                                <ol>
                                                                    <li>Menekan tombol "Binding".</li>
                                                                    <li>Masukkan program studi uang sesuai pada form Program Studi (Binding).</li>
                                                                    <li>Masukkan tahun.</li>
                                                                    <li>Memastikan bahwa data sudah sesuai dengan menekan tombol "Nama Prodi Sesuai".</li>
                                                                    <li>Jika data benar, silahkan klik tombol "Submit".</li>
                                                                </ol>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade"
                                                id="preview"
                                                role="tabpanel"
                                                aria-labelledby="preview-tab">
                                                <div class="card-body">
                                                    <h6 style="color: #6777ef">Cara Penggunaan Untuk Halaman Preview:</h6>
                                                    <br>
                                                    <p>Pada halaman ini Anda dapat melihat data mahasiswa sesuai dengan seleksi yang dipilih calon mahasiswa. 
                                                    Pada halaman ini ada keterangan yaitu <b>"post-import"</b> untuk memberitahukan bahwa data masih belum diubah dan <b>"filtered"</b> untuk memberitahukan bahwa data sudah melalui proses filter.
                                                    Data juga dapat dilihat sesuai dengan tahun, Anda dapat menekan tahun pada pojok kanan atas.</p>
                                            
                                                </div>
                                            </div>
                                            <div class="tab-pane fade"
                                                id="filter"
                                                role="tabpanel"
                                                aria-labelledby="filter-tab">
                                                <div class="card-body">
                                                    <h6 style="color: #6777ef">Cara Penggunaan Untuk Halaman Preview:</h6>
                                                    <br>
                                                    <p>Pada halaman ini Anda dapat memfilter data calon mahasiswa sebelum data akan disimpan ke database Politeknik Negeri Jakarta. 
                                                        Berikut langkah-langkah dalam filter data calon mahasiswa:
                                                    </p>
                                                    <ol>
                                                        <li>Memasukkan tahun terdaftar.</li>
                                                        <li>Masukkan nama kolom excel yang ingin difilter.</li>
                                                        <li>Masukkan operasi perbandingan yang telah ditentukan sebelumnya.</li>
                                                        <li>Menekan tombol "Tambah" untuk menambahkan filter.</li>
                                                        <li>Lakukan kegiatan untuk memasukkan kolom excel kembali jika ingin menambah data yang ingin difilter.</li>
                                                        <li>Menekan tombol "Filter" untuk melakukan filter data.</li>
                                                        <li>Menekan tombol "Save" untuk menyimpan hasil data yang telah difilter.</li>
                                                    </ol>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade"
                                                id="bobot"
                                                role="tabpanel"
                                                aria-labelledby="bobot-tab">
                                            <div class="card-body">
                                                <h6 style="color: #6777ef">Cara Penggunaan Pembobotan Data Mahasiswa:</h6>
                                                <br>
                                                <p>Pada menu pembobotan ini hanya ditunjukan untuk data calon mahasiswa yang menggunakan jalur <b>Seleksi Mandiri</b>. 
                                                    Berikut langkah-langkah dalam pembobotan data calon mahasiswa:
                                                </p>
                                                <ol>
                                                    <li>Memastikan data calon mahasiswa jalur seleksi mandiri sudah diinput.</li>
                                                    <li>Memastikan data calon mahasiswa jalur seleksi mandiri belum melalui proses filtering.</li>
                                                    <li>Menentukan bobot sesuai dengan kriteria yang telah ditentukan.</li>
                                                    <li>Setelah melalui proses pembobotan, data dapat melalui proses filter.</li>
                                                </ol>
                                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
@endpush
