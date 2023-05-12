@extends('layouts.auth.app', $head)

@section('dynamic-content')
<div class="login-wrapper mt-1 mt-md-5 wd-300 wd-xs-400 pd-25 pd-xs-30  bg-white rounded shadow-base">
    @if ($site->logo != null)
    <div class="text-center mg-b-20">
        <img class="" src="{{asset('uploads/images/site') . '/' . $site->logo}}" width="50">
    </div>    
    @endif
    <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"><span class="tx-normal">[</span> <span class="tx-success">  {{$site->site_name}} </span>
        <span class="tx-normal">]</span></div>
    <div class="tx-center mg-b-30"> <i> {{$tagline_app ?? 'Aplikasi Presensi Kehadiran Karyawan'}} </i></div>

    <form method="post" action="{{route('authenticate')}}">
        @csrf
        <div class="row mg-b-10">
            <div class="col">
                @if ($message = Session::get('success'))
                <div class="text-center alert alert-success bd bd-success-400" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="d-flex align-items-center justify-content-start">
                        <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>
                        <span><strong>Well done!</strong> {{ $message }}</span>
                    </div><!-- d-flex -->
                </div><!-- alert -->
                @elseif ($message = Session::get('error'))
                <div class="text-center alert alert-danger bd bd-danger-400" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="d-flex align-items-center justify-content-start">
                        <i class="icon ion-ios-close alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>
                        <span><strong>Sorry,</strong> {{ $message }}</span>
                    </div><!-- d-flex -->
                </div><!-- alert -->
                @endif
            </div>
        </div>

        <div class="form-group">
            <label for="">Usename</label>
            <input type="text" name="email" class="form-control" placeholder="Masukkan Email" autofocus="true" autocomplete="0">
            @if($errors->has('email'))
            <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center"
                onclick="$(this).remove()">
                <small>{{ $errors->first('email') }}</small>
                <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
            </div>
            @endif
        </div>
        
        <div class="form-group">
            <label for="">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan Kata sandi"autocomplete="0">
            @if($errors->has('password'))
            <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center"
                onclick="$(this).remove()">
                <small>{{ $errors->first('password') }}</small>
                <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
            </div>
            @endif
        </div>

        <button type="submit" class="btn btn-success btn-block">MASUK</button>

    </form>

    <div class="tx-center mg-t-40">Version {{$version}}</div>
</div><!-- login-wrapper -->
@endsection


@push('active-login')
active
@endpush

@push('menuOpen-login')
style="display: block;"
@endpush

@push('showSub-login')
show-sub
@endpush

@push('styles')
@endpush

@push('scripts')
@endpush
