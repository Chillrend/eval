<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Evaluasi PMB</a>
        
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">PMB</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('dashboard') }}"><i class="fas fa-house"></i><span>Dashboard</span></a>
            </li>
            
            <li class="menu-header">Seleksi</li>

            <li class="nav-item dropdown {{ $type_menu === 'prestasi' ? 'active' : '' }}">

                <a href="#"
                    class="nav-link has-dropdown"
                    data-toggle="dropdown"><i class="fas fa-graduation-cap"></i><span>Seleksi Prestasi</span></a>
                
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('candidates-prestasi') ? 'active' : '' }}">
                        <a class="nav-link "
                            href="{{ url('candidates-prestasi') }}"><i class="fas fa-users"></i><span>Data Mahasiswa</span></a>
                    </li>
                    <li class="{{ Request::is('prodi-prestasi') ? 'active' : '' }}">
                        <a class="nav-link "
                            href="{{ url('prodi-prestasi') }}"><i class="fas fa-university"></i><span>Program Studi</span></a>
                    </li>  
                    <li class="{{ Request::is('preview-prestasi') ? 'active' : '' }}">
                        <a class="nav-link "
                            href="{{ url('preview-prestasi') }}"><i class="fas fa-eye" ></i><span>Preview</span></a>
                    </li>             
                </ul>

            </li>
            <li class="nav-item dropdown {{ $type_menu === 'tes' ? 'active' : '' }}">
    
                    <a href="#"
                        class="nav-link has-dropdown"
                        data-toggle="dropdown"><i class="fas fa-solid fa-paste"></i><span>Seleksi Tes</span></a>
                    
                    <ul class="dropdown-menu">
                        <li class="{{ Request::is('candidates-tes') ? 'active' : '' }}">
                            <a class="nav-link "
                                href="{{ url('candidates-tes') }}"><i class="fas fa-users"></i><span>Data Mahasiswa</span></a>
                        </li>
                        <li class="{{ Request::is('prodi-tes') ? 'active' : '' }}">
                            <a class="nav-link "
                                href="{{ url('prodi-tes') }}"><i class="fas fa-university"></i><span>Program Studi</span></a>
                        </li>  
                        <li class="{{ Request::is('preview-tes') ? 'active' : '' }}">
                            <a class="nav-link "
                                href="{{ url('preview-tes') }}"><i class="fas fa-eye" ></i><span>Preview</span></a>
                        </li>             
                    </ul>    
            </li>

            <li class="nav-item dropdown {{ $type_menu === 'mandiri' ? 'active' : '' }}">
    
                <a href="#"
                    class="nav-link has-dropdown"
                    data-toggle="dropdown"><i class="fas fa-sharp fa-solid fa-file-lines"></i><span>Seleksi Mandiri</span></a>
                
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('candidates-mandiri') ? 'active' : '' }}">
                        <a class="nav-link "
                            href="{{ url('candidates-mandiri') }}"><i class="fas fa-users"></i><span>Data Mahasiswa</span></a>
                    </li>
                    <li class="{{ Request::is('prodi-mandiri') ? 'active' : '' }}">
                        <a class="nav-link "
                            href="{{ url('prodi-mandiri') }}"><i class="fas fa-university"></i><span>Program Studi</span></a>
                    </li>  
                    <li class="{{ Request::is('preview-mandiri') ? 'active' : '' }}">
                        <a class="nav-link "
                            href="{{ url('preview-mandiri') }}"><i class="fas fa-eye" ></i><span>Preview</span></a>
                    </li>             
                </ul>    
        </li>

        <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="https://getstisla.com/docs"
                class="btn btn-danger btn-lg btn-block btn-icon-split">
                <i class="fas fa-check-circle"></i> SELESAI
            </a>
        </div>
    </aside>
</div>