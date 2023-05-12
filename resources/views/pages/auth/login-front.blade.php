@extends('layouts.public.app', [
'title' => 'Login - ' . $site->site_name . ' | ' . $site->tagline ,
'head_title_per_page' => "Master Document Category",
'sub_title_per_page' => "",
'breadcrumbs' => [
[
'title' => 'Dashboard',
'link' => route('adm.dashboard'),
'is_active' => false,
],
[
'title' => 'Master Data',
'link' => '#',
'is_active' => false,
],
[
'title' => 'Document Category',
'link' => '#',
'is_active' => true,
],
]
])
@section('content')
<!-- Start Page Title Area -->
{{-- <div class="page-title-area"
    style="background-image: url('https://images.unsplash.com/photo-1485575301924-6891ef935dcd?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80')">
    <div class="container">
        <div class="page-title-content">
            <h2>Log In</h2>
            <ul>
                <li>
                    <a href="index.html">
                        Home
                    </a>
                </li>
                <li class="active">Log In</li>
            </ul>
        </div>
    </div>
</div> --}}
<!-- End Page Title Area -->
<!-- Start User Area -->
<section class="user-area-style ptb-100 mt-100"
    style="background-size:cover; background-repeat:no-repeat; background-image: url('https://images.unsplash.com/photo-1619252584172-a83a949b6efd?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1074&q=80'); ">
    <div class="container">
        <div class="contact-form-action">
            <div class="account-title">
                <h2>Log in</h2>
            </div>

            <form method="post" action="{{route('authenticate')}}">
                @csrf
                <div class="row">
                    <div class="col">
                        @if ($message = Session::get('success'))
                            <div class="text-center alert alert-success bd bd-success-400" role="alert">
                                </button>
                                <div class="d-flex align-items-center justify-content-start">
                                <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>
                                <span><strong>Well done!</strong> {{ $message }}</span>
                                </div><!-- d-flex -->
                            </div><!-- alert -->
                        @elseif ($message = Session::get('error'))
                            <div class="text-center alert alert-danger bd bd-danger-400" role="alert">
                                </button>
                                <div class="d-flex align-items-center justify-content-start">
                                <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>
                                <span><strong>Sorry,</strong> {{ $message }}</span>
                                </div><!-- d-flex -->
                            </div><!-- alert -->
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" type="text" name="email">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label>Password</label>
                            <input class="form-control" type="password" name="password">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="login-action">
                            <span class="log-rem">
                                <input id="remember" type="checkbox">
                                <label for="remember">Remember me!</label>
                            </span>

                            <span class="forgot-login">
                                <a href="recover-password.html">Forgot your password?</a>
                            </span>
                        </div>
                    </div>

                    <div class="col-12">
                        <button class="default-btn" style="width: 100%;" type="submit">
                            <span>Log in now</span>
                        </button>
                    </div>

                    <div class="col-12">
                        {{-- <p>Have an account? <a href="registration.html">Registration Now!</a></p> --}}
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- End User Area -->

@endsection


@push('active-masterAdminDocumentCategory')
active
@endpush

@push('menuOpen-masterAdminDocumentCategory')
style="display: block;"
@endpush

@push('showSub-masterAdminDocumentCategory')
show-sub
@endpush

@push('styles')
@endpush

@push('scripts')
@endpush
