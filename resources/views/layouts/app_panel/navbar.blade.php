<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
      <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"> <i class="fas fa-bars"></i></a></li>
      </ul>
    </form>
    <ul class="navbar-nav navbar-right">
      <li class="dropdown dropdown-list-toggle">
        <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg d-flex  message-toggle beep">
          <i class="far fa-clock" style="font-size: 13px;"></i>
          &nbsp;
          <div id="clock_digital"></div>
        </a>
      </li>
      <li class="dropdown"><a href="{{asset('admin_template/dist')}}/#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        @if (auth()->user()->photo_profile != null && auth()->user()->role == 'superadmin')
            <img class="rounded-circle mr-1" src="{{ asset('uploads/images/admin/'. auth()->user()->photo_profile) }}"> 
        @elseif (auth()->user()->photo_profile != null && auth()->user()->role == 'admin')
            <img class="rounded-circle mr-1" src="{{ asset('uploads/images/admin/'. auth()->user()->photo_profile) }}"> 
        @elseif (auth()->user()->photo_profile != null && auth()->user()->role == 'user')
            <img class="rounded-circle mr-1" src="{{ asset('uploads/images/employee/'. auth()->user()->photo_profile) }}"> 
        @else
          <img alt="image" src="{{asset('admin_template/dist')}}/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
        @endif
        <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->full_name }}</div></a>
        <div class="dropdown-menu dropdown-menu-right">
          <div class="dropdown-title">{{date('d F Y')}}</div>
          @role(['user'])
          <a href="{{asset('admin_template/dist')}}/features-profile.html" class="dropdown-item has-icon">
            <i class="far fa-user"></i> Profil
          </a>
          @endrole
          <div class="dropdown-divider"></div>
          <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item has-icon text-danger">
            <i class="fas fa-sign-out-alt"></i> Keluar
          </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
      </li>
    </ul>
  </nav>