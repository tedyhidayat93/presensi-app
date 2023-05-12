<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{asset('admin_template/dist')}}/index.html">PRESENSI APP</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{asset('admin_template/dist')}}/index.html">PA</a>
      </div>
      <ul class="sidebar-menu">


        {{-- SIDEBAR UNTUK ROLE SUPERADMIN & ADMIN --}}
        @role(['superadmin','admin'])
        <li class="menu-header">Dashboard</li>
        @can('admin-dashboard')
        <li class="@stack('active-dashboardAdmin')"><a class="nav-link" href=""><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
        @endcan
        
        <li class="menu-header">Main Menu</li>
        
        @can('admin-log-presensi-sidebar-menu')
        <li class="@stack('active-absen')"><a class="nav-link" href=""><i class="fas fa-history"></i> <span>Log Presensi</span></a></li>
        @endcan

        @can('admin-izin-sidebar-menu')
        <li class="@stack('active-izin')">
          <a class="nav-link" href="">
            <i class="fas fa-stamp"></i> <span>Validasi Izin</span>
            @if($total_izin_waiting != 0)
            <span class="badge badge-warning w-25 float-right">{{$total_izin_waiting ?? 0}}</span>
            @endif
          </a>
        </li>
        @endcan

        @can('admin-waktu-kerja-sidebar-menu')
        <li class="@stack('active-shift')"><a class="nav-link" href=""><i class="fas fa-clock"></i> <span>Waktu Kerja</span></a>
        @endcan

        @can('admin-karyawan-sidebar-menu')
        <li class="@stack('active-employee')"><a class="nav-link" href=""><i class="fas fa-user"></i> <span>Data Pegawai</span></a>
        @endcan

        @can('admin-users-sidebar-menu')
        <li class="@stack('active-users')"><a class="nav-link" href=""><i class="fas fa-users"></i> <span>Data Admin</span></a>
        @endcan

        @can('admin-laporan-sidebar-menu')
        <li class="@stack('active-report')"><a class="nav-link" href=""><i class="fas fa-print"></i> <span>Laporan</span></a>
        @endcan
        
        <li class="menu-header">Master Data</li>

        @can('admin-pendidikan-sidebar-menu')
        <li class="@stack('active-masterPendidikan')"><a class="nav-link" href=""><i class="fas fa-folder"></i> <span>Pendidikan</span></a></li>
        @endcan

        @can('admin-jabatan-sidebar-menu')
        <li class="@stack('active-masterAdminEmployeeType')"><a class="nav-link" href=""><i class="fas fa-folder"></i> <span>Jabatan</span></a></li>
        @endcan

        @can('admin-jenis-izin-sidebar-menu')
        <li class="@stack('active-jenisIzin')"><a class="nav-link" href=""><i class="fas fa-folder"></i> <span>Jenis Izin</span></a></li>
        @endcan

        @can('admin-jenis-lembur-sidebar-menu')
        <li class="@stack('active-jenisLembur')"><a class="nav-link" href=""><i class="fas fa-folder"></i> <span>Jenis Lembur</span></a></li>
        @endcan
        
        @can('admin-pengaturan-sidebar-menu')
        <li class="menu-header">Extras</li>            
        <li class="@stack('active-setings')"><a class="nav-link" href=""><i class="fas fa-cog"></i> <span>Pengaturan</span></a></li>
        @endcan
        
        @endrole
        {{-- .END SIDEBAR UNTUK ROLE SUPERADMIN & ADMIN --}}

        {{-- SIDEBAR UNTUK ROLE USER --}}
        @role(['user'])
        <li class="menu-header">Dashboard</li>

        @can('user-dashboard')
        <li class="@stack('active-dashboardUser')"><a class="nav-link" href=""><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
        @endcan

        <li class="menu-header">Main Menu</li>
        
        @can('user-presensi-sidebar-menu')
        <li class="@stack('active-absen')"><a class="nav-link" href=""><i class="fas fa-history"></i> <span>Riwayat Presensi</span></a></li>
        @endcan

        @can('user-izin-sidebar-menu')
        <li class="@stack('active-izin')"><a class="nav-link" href=""><i class="fas fa-history"></i> <span>Riwayat Izin</span></a></li>
        @endcan

        @can('user-profile-sidebar-menu')
        <li class="@stack('active-izin')"><a class="nav-link" href=""><i class="fas fa-user"></i> <span>Profil</span></a></li>
        @endcan
        @endrole
        {{-- .END SIDEBAR UNTUK ROLE USER --}}

      
      </ul>

      <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
        <a href="{{ route('logout') }}"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger btn-lg btn-block ">
          <i class="fas fa-power-off"></i> {{ __('Keluar') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        
      </div>        
    </aside>
  </div>