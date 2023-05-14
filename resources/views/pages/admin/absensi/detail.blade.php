@extends('layouts.app_panel.app', $head)


@section('content')
<div class="section">
    <div class="section-header">
        <h1> {{$head['head_title_per_page'] ?? 'Title' }}</h1>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="card bd-0 shadow-base ">
                <div class="card-header">
                    <a href="{{route('adm.absen')}}" class="btn btn-light btn-sm"><i class="fa fa-arrow-left"></i> Kembali </a>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-12 col-md-7 table-responsive overflow-auto">
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="card mb-3 border border">
                                        <div class="card-body">

                                            <small class="mb-0">Nama Pegawai </small>
                                            
                                            <div class="mt-3 d-md-flex align-items-center">
                                                <div class="mr-3">
                                                    @if ($data->karyawan->photo_profile)
                                                    <img width="50" class="rounded-circle img-fluid" src="{{ asset('uploads/images/employee/'. $data->karyawan->photo_profile) }}">
                                                    @else
                                                    <img width="50" class="rounded-circle img-fluid" src="{{ asset('images/default-ava.jpg') }}"> 
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 style="font-size: 14px;" class="text-dark mb-0">{{$data->karyawan->full_name}}</h6>
                                                    <span class="mt-0"><b>Jabatan : </b> {{$data->karyawan->jabatan->type ?? '-'}}</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card mb-3 border">
                                        <div class="card-body">
                                            <small class="mb-3">Sumber Perangkat </small>
                                            <h6 style="font-size: 14px;" class=" mb-0">
                                                @if ($data->device == 'web')
                                                    <i class="fa fa-globe"></i> Website/Browser
                                                @elseif ($data->device == 'mobile')
                                                    <i class="fa fa-mobile"></i> Mobile/Handphone
                                                @else
                                                    Undefine.
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="card mb-3 border">
                                        <div class="card-body">
                                            <small class="mb-3">Jenis Presensi </small>
                                            <h6 class=" mb-0">
                                                @if ($data->type == 'absen_lembur')
                                                    <span class="badge badge-info">Lembur</span>
                                                    <span class="badge badge-info">{{$data->jenisLembur->type ?? ''}}</span>
                                                @elseif ($data->type == 'absen_biasa')
                                                    <span class="badge badge-info">Harian</span>
                                                @else
                                                    -
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card mb-3 border">
                                        <div class="card-body">
                                            <small class="mb-2">Tanggal Presensi Masuk</small>
                                            <h6 style="font-size: 14px;" class="mb-2">{{ date('d-M-Y', strtotime($data->date))}}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card mb-3 border">
                                        <div class="card-body">
                                            <small class="mb-2">Jam Masuk</small>
                                            <h6 style="font-size: 14px;" class="mb-0"><i class="fa fa-clock-o"></i> {{ $data->clock_in != null ? date('H:i:s', strtotime($data->clock_in)) : '-'}}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card mb-3 border">
                                        <div class="card-body">
                                            <small class="mb-3">Total Jam Terlambat</small>
                                            <h6 style="font-size: 14px;" class="mb-0 text-danger"><i class="fa fa-clock-o"></i> {{ $data->late != null ?  \App\Helpers\General::convertSecondToStringTime($data->late) : '-' }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card mb-3 border">
                                        <div class="card-body">
                                            <small class="mb-2">Tanggal Presensi Pulang</small>
                                            <h6 style="font-size: 14px;" class="mb-2">{{ $data->date_out == null ? '-' : date('d-M-Y', strtotime($data->date_out))}}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card mb-3 border">
                                        <div class="card-body">
                                            <small class="mb-3">Jam Pulang  </small>
                                            <h6 style="font-size: 14px;" class="mb-0"><i class="fa fa-clock-o"></i> {{ $data->clock_out != null ? date('H:i:s', strtotime($data->clock_out)) : '-'}}</h6>
                                            <small> @if ($data->is_auto_checkout_daily == 1) <span class="text-warning"> (Auto Check-Out) </span> @endif </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card mb-3 border">
                                        <div class="card-body">
                                            <small class="mb-3">Jam Pulang Cepat</small>
                                            <h6 style="font-size: 14px;" class="mb-0"><i class="fa fa-clock-o"></i> {{ $data->early_leave ?? '-' }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="card mb-3 border">
                                        <div class="card-body">
                                            <small class="mb-3">Total Jam Kerja</small>
                                            <h6 style="font-size: 14px;" class="mb-0"><i class="fa fa-clock-o"></i> {{ $data->total_work != null ? \App\Helpers\General::convertSecondToStringTime($data->total_work) : '-' }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="card mb-3 border">
                                        <div class="card-body">
                                            <small class="mb-3">Total Jam Lembur</small>
                                            <h6 style="font-size: 14px;" class="mb-0"><i class="fa fa-clock-o"></i> {{ $data->overtime != null ? \App\Helpers\General::convertSecondToStringTime($data->overtime) : '-' }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="card mb-3 border">
                                        <div class="card-body" style="min-height: 130px;">
                                            <small class="mb-3">Keterangan Masuk</small>
                                            <p class="mb-0">{{ $data->note_in ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12">
                                    <div class="card mb-3 border">
                                        <div class="card-body" style="min-height: 130px;">
                                            <small class="mb-3">Keterangan Pulang</small>
                                            <p class="mb-0">{{ $data->note_out ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-5 d-block align-items-start justify-content-end">
                            @if ($data->foto_masuk != null)
                            <div class="card">
                                <div class="card-header d-flex justify-content-center bg-secondary">
                                    <img style="height: 260px;" class="img-fluid" src="{{ asset('uploads/images/attendance/'.$data->foto_masuk) }}">
                                </div>
                                <div class="card-body text-center p-2 font-weight-bold text-success">
                                    Foto Presensi Masuk
                                </div>
                            </div>
                            @else
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-center" style="height: 260px;">
                                    Belum Melakukan Presensi Masuk
                                </div>
                                <div class="card-body text-center p-2 font-weight-bold text-success">
                                    Foto Presensi Pulang
                                </div>
                            </div>
                            @endif
                            @if ($data->foto_keluar != null)
                            <div class="card mt-2">
                                <div class="card-header d-flex justify-content-center bg-secondary">
                                    <img style="height: 260px;" class="img-fluid" src="{{ asset('uploads/images/attendance/'.$data->foto_keluar) }}">
                                </div>
                                <div class="card-body text-center p-2 font-weight-bold text-primary">
                                    Foto Presensi Pulang
                                </div>
                            </div>
                            @else
                            <div class="card mt-2">
                                <div class="card-header d-flex align-items-center justify-content-center" style="height: 260px;">
                                    Belum Melakukan Presensi Pulang
                                </div>
                                <div class="card-body text-center p-2 font-weight-bold text-primary">
                                    Foto Presensi Pulang
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div><!-- card -->
        </div>
    </div>

    <div class="row row-sm mg-t-20">
        <div class="col-12 col-md-6">
            <div class="card pd-0 bd-0 shadow-base">
                <div class="card-body pd-x-30 pd-t-30 pd-b-10">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 style="font-size: 14px;" class="text-13 text-uppercase text-inverse font-weight-bold text-spacing-1 mb-0">Lokasi Check In
                            </h6>
                            <small>Tanggal : <b> {{ date('d-M-Y', strtotime($data->date))}} </b></small>
                        </div>
                        <div class="text-13">
                            <p class="mb-0"><span class="square-8 rounded-circle bg-purple mg-r-10"></span> Koordinat
                                : <b> {{$data->latlong_in ?? '-'}} </b></p>
                            <p class="mb-0"><span class="square-8 rounded-circle bg-pink mg-r-10"></span> Waktu :
                                <b>{{ $data->clock_in != null ? date('H:i:s', strtotime($data->clock_in)) : '-'}}</b></p>
                        </div>
                    </div><!-- d-flex -->
                </div>
                <div class="card-body pd-x-15 pd-b-15">
                    {{-- <div id="mapid" class="ht-200 ht-sm-200 ht-md-350 bd bg-gray-100"></div> --}}

                    @if ($site->is_using_radius != 0)
                        @if ($data->latlong_in != null)
                        <div id="mapid" style="width:100%; height:345px;"></div>
                        @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="width:100%; height:345px;">
                            <h5>Pegawai Belum Melakukan Presensi Masuk</h5>
                        </div>
                        @endif
                    @else
                    <div style="width:100%; height:345px;" class="bg-gray-100 d-flex flex-column align-items-center justify-content-center">
                        <i class="text-info icon ion-map text-50"></i>
                        <h5 class="">Geolocation Sedang Tidak Aktif.</h5>
                    </div>
                    @endif
                </div>
            </div><!-- card -->
        </div><!-- col-9 -->
        <div class="col-12 col-md-6">
            <div class="card pd-0 bd-0 shadow-base">
                <div class="card-body pd-x-30 pd-t-30 pd-b-10">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 style="font-size: 14px;" class="text-13 text-uppercase text-inverse font-weight-bold text-spacing-1 mb-0">Lokasi Check Out
                            </h6>
                            <small>Tanggal : <b> {{ date('d-M-Y', strtotime($data->date))}} </b></small>
                        </div>
                        <div class="text-13">
                            <p class="mb-0"><span class="square-8 rounded-circle bg-purple mg-r-10"></span> Koordinat
                                : <b> {{$data->latlong_out ?? '-'}} </b></p>
                            <p class="mb-0"><span class="square-8 rounded-circle bg-pink mg-r-10"></span> Waktu :
                                <b>{{ $data->clock_out != null ? date('H:i:s', strtotime($data->clock_out)) : '-'}}</b></p>
                        </div>
                    </div><!-- d-flex -->
                </div>
                <div class="card-body pd-x-15 pd-b-15">
                    {{-- <div id="mapid" class="ht-200 ht-sm-200 ht-md-350 bd bg-gray-100"></div> --}}

                    @if ($site->is_using_radius != 0)
                        @if ($data->latlong_out != null)
                        <div id="mapid2" style="width:100%; height:345px;"></div>
                        @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="width:100%; height:345px;">
                            <h5>Pegawai Belum Melakukan Checkout</h5>
                        </div>
                        @endif
                    @else
                    <div style="width:100%; height:345px;" class="bg-gray-100 d-flex flex-column align-items-center justify-content-center">
                        <i class="text-info icon ion-map text-50"></i>
                        <h5 class="">Geolocation Sedang Tidak Aktif.</h5>
                    </div>
                    @endif
                </div>
            </div><!-- card -->
        </div><!-- col-3 -->
    </div><!-- row -->

</div><!-- br-pagebody -->
@endsection


@push('active-absen')
active
@endpush

@push('menuOpen-absen')
@endpush

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
crossorigin=""/>
@endpush

@push('scripts')

<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

@if ($data->latlong_in != null)
<script>
    $(document).ready(function() {
      
        navigator.geolocation.getCurrentPosition((position) => {

            // -6.331146, 107.002307
            var map = L.map('mapid').setView([{{$data->latlong_in ?? '0,0'}}], 12);        
            var marker = L.marker([{{$data->latlong_in ?? '0,0'}}]).addTo(map);
    
            // Disable dragging when user's cursor enters the element
            // map.getContainer().addEventListener('mouseover', function () {
            //     map.dragging.disable();
            // });        
    
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

        });
        
    })

</script>
@endif

@if ($data->latlong_out != null)
<script>
    $(document).ready(function() {
      
        navigator.geolocation.getCurrentPosition((position) => {

            // -6.331146, 107.002307
            var map2 = L.map('mapid2').setView([{{$data->latlong_out ?? '0,0'}}], 12);        
            var marker2 = L.marker([{{$data->latlong_out ?? '0,0'}}]).addTo(map2);
    
            // Disable dragging when user's cursor enters the element
            // map.getContainer().addEventListener('mouseover', function () {
            //     map.dragging.disable();
            // });        
    
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map2);

        });
        
    })

</script>
@endif


@endpush
