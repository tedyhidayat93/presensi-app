@extends('layouts.app_panel.app', $head)


@section('content')
<div class="section">
    <div class="section-header">
        <h1> {{$head['head_title_per_page'] ?? 'Title' }}</h1>
    </div>
    <div class="section-body">
        <div class="row mt-sm-4">
            <div class="col-12 col-md-12 col-lg-6">
                <div class="card profile-widget">
                    <div class="profile-widget-header">

                        @if (auth()->user()->photo_profile != null && auth()->user()->role == 'superadmin')
                        <img class="border border-primary rounded-circle profile-widget-picture"
                            src="{{ asset('uploads/images/admin/'. auth()->user()->photo_profile) }}">
                        @elseif (auth()->user()->photo_profile != null && auth()->user()->role == 'admin')
                        <img class="border border-primary rounded-circle profile-widget-picture"
                            src="{{ asset('uploads/images/admin/'. auth()->user()->photo_profile) }}">
                        @elseif (auth()->user()->photo_profile != null && auth()->user()->role == 'user')
                        <img class="border border-primary rounded-circle profile-widget-picture"
                            src="{{ asset('uploads/images/employee/'. auth()->user()->photo_profile) }}">
                        @else
                        <img alt="image" src="{{asset('admin_template/dist')}}/assets/img/avatar/avatar-1.png"
                            class="border border-primary rounded-circle profile-widget-picture">
                        @endif


                        <div class="profile-widget-items">
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label text-dark">Bergabung Sejak</div>
                                <div class="profile-widget-item-value">{{date('d F Y', strtotime(Auth::user()->tanggal_masuk))}}</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label text-dark">Masa Kerja</div>
                                <div class="profile-widget-item-value">
                                    @php
                                        $startDate = \Carbon\Carbon::parse(Auth::user()->tanggal_masuk);
                                        if(Auth::user()->is_active == 1) {
                                            $endDate = \Carbon\Carbon::now();
                                        } else {
                                            $endDate = \Carbon\Carbon::parse(Auth::user()->tanggal_keluar);
                                        }
                                        $duration = $endDate->diff($startDate);
                                        echo $duration->format('%y tahun %m bulan')
                                    @endphp
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="profile-widget-description">
                        <div class="profile-widget-name">
                            <h5 class="font-weight-bold text-primary">
                                {{Auth::user()->full_name ?? '-'}} 
                            </h5>
                        </div>
                        <hr>
                        
                        <table class="table table-sm">
                            <tr class="p-0">
                                <th class="px-0 text-capitalize">Jabatan</th>
                                <th class="">:</th>
                                <td class="px-0 text-capitalize"> {{Auth::user()->type ?? '-'}} / {{Auth::user()->jabatan->type ?? '-'}}</td>
                            </tr>
                            <tr class="p-0">
                                <th class="px-0 text-capitalize">Status</th>
                                <th class="">:</th>
                                <td class="px-0 text-capitalize">{{Auth::user()->status ?? '-'}}</td>
                            </tr>
                            <tr class="p-0">
                                <th class="px-0 text-capitalize">NIP</th>
                                <th class="">:</th>
                                <td class="px-0 text-capitalize">{{Auth::user()->nip ?? '-'}}</td>
                            </tr>
                            <tr class="p-0">
                                <th class="px-0 text-capitalize">NIK</th>
                                <th class="">:</th>
                                <td class="px-0 text-capitalize">{{Auth::user()->nik ?? '-'}}</td>
                            </tr>
                            <tr class="p-0">
                                <th class="px-0 text-capitalize">Jenis Kelamin</th>
                                <th class="">:</th>
                                <td class="px-0 text-capitalize">
                                    @php 
                                        $gender = '-';
                                        if(Auth::user()->gender == 'L') {
                                            $gender = 'Laki - Laki';
                                        }else {
                                            $gender = 'Perempuan';
                                        }
                                    @endphp
                                    {{$gender}}    
                                </td>
                            </tr>
                            <tr class="p-0">
                                <th class="px-0 text-capitalize">Email</th>
                                <th class="">:</th>
                                <td class="px-0 text-lowercase text-info">{{Auth::user()->email ?? '-'}}</td>
                            </tr>
                            <tr class="p-0">
                                <th class="px-0 text-capitalize">Telepon</th>
                                <th class="">:</th>
                                <td class="px-0 text-capitalize">{{Auth::user()->phone ?? '-'}}</td>
                            </tr>
                            <tr class="p-0">
                                <th class="px-0 text-capitalize">Alamat</th>
                                <th class="">:</th>
                                <td class="px-0 text-capitalize">{{Auth::user()->address ?? '-'}}</td>
                            </tr>
                            <tr class="p-0">
                                <th class="px-0 text-capitalize">Pendidikan Terakhir</th>
                                <th class="">:</th>
                                <td class="px-0 text-capitalize">{{Auth::user()->education->education ?? '-'}}</td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-6">
                <div class="card mt-4">
                    <form method="post" action="{{route('user.profile.update_password')}}" class="needs-validation" novalidate="">
                        @csrf
                        <div class="card-header py-0">
                            <h4 class="mb-0"><i class="fas fa-lock"></i> Ganti Password</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12 col-12">
                                    <label>Password Baru</label>
                                    <input type="text" class="form-control" name="password" value="" placeholder="Masukkan password baru" required="">
                                    <div class="invalid-feedback">
                                        Tidak Boleh Kosong
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-danger">Ubah Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- br-pagebody -->
@endsection


@push('active-profile')
active
@endpush

@push('menuOpen-profile')
@endpush

@push('styles')
@endpush

@push('scripts')
@endpush
