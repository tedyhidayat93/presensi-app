@extends('layouts.admin.app', $head)


@section('dynamic-content')
<div class="br-pagebody mg-t-5 pd-x-30">

    <div class="row mb-3">
        <div class="col">
            <div class="card bd-0 shadow-base">
                <div class="card-header">
                    <a href="{{route('adm.izin')}}" class="btn btn-light btn-sm"><i class="fa fa-arrow-left"></i> Kembali </a>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-12 col-md-7 table-responsive overflow-auto">
                            <table class="table table-valign-middle mg-b-0 nowrap">
                                <tbody>
                                    <tr>
                                        <td class=" bg-light" width="100">
                                            @if ($data->karyawan->photo_profile)
                                            <img class="w-100 h-100 rounded img-fluid" src="{{ asset('uploads/images/employee/'. $data->karyawan->photo_profile) }}">
                                            @else
                                            <img class="w-100 h-100 rounded img-fluid" src="{{ asset('images/default-ava.jpg') }}"> 
                                            @endif
                                        </td>
                                        <td colspan="2">
                                            <h4 class="tx-teal tx-25 mg-b-0">{{$data->karyawan->full_name}}</h4>
                                            <span class="tx-12"><b>Jabatan : </b> {{$data->karyawan->jabatan->type ?? '-'}}</span>
                                        </td>
                                        <td>
                                            <span class="tx-12">Terdaftar Sejak</span>
                                            <h4 class="tx-inverse tx-14 mg-b-0">{{ date('d-M-Y', strtotime($data->karyawan->registered_at))}}</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="tx-12">Shift</span>
                                            <h4 class="tx-inverse tx-14 mg-b-0">{{$data->karyawan->shifft->shift_name}}</h4>
                                        </td>
                                        <td>
                                            <span class="tx-12">Email</span>
                                            <h4 class="tx-inverse tx-14 mg-b-0">{{$data->karyawan->email}}</h4>
                                        </td>
                                        <td>
                                            <span class="tx-12">NIP</span>
                                            <h4 class="tx-inverse tx-14 mg-b-0">{{$data->karyawan->nip}}</h4>
                                        </td>
                                        <td>
                                            <span class="tx-12">NIK</span>
                                            <h4 class="tx-inverse tx-14 mg-b-0">{{$data->karyawan->nik}}</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
    
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <small class="mb-3">Jenis Absen </small>
                                            <h5 class=" mg-b-0">
                                                @if ($data->type == 'absen_lembur')
                                                    <span class="badge badge-info">Lembur</span>
                                                @elseif ($data->type == 'absen_biasa')
                                                    <span class="badge badge-info">Harian</span>
                                                @else
                                                    -
                                                @endif
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <small class="mb-2">Tanggal Absen</small>
                                            <h6 class="mb-2">{{ date('d-M-Y', strtotime($data->date))}}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <small class="mb-2">Jam Masuk</small>
                                            <h6 class="mb-0"><i class="fa fa-clock-o"></i> {{ $data->clock_in != null ? date('H:i:s', strtotime($data->clock_in)) : '-'}}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <small class="mb-3">Jam Pulang</small>
                                            <h6 class="mb-0"><i class="fa fa-clock-o"></i> {{ $data->clock_out != null ? date('H:i:s', strtotime($data->clock_out)) : '-'}}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <small class="mb-3">Total Jam Kerja</small>
                                            <h6 class="mb-0"><i class="fa fa-clock-o"></i> {{ $data->total_work ?? '-' }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <small class="mb-3">Jam Pulang Cepat</small>
                                            <h6 class="mb-0"><i class="fa fa-clock-o"></i> {{ $data->early_leave ?? '-' }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <small class="mb-3">Total Jam Terlambat</small>
                                            <h6 class="mb-0"><i class="fa fa-clock-o"></i> {{ $data->late ?? '-' }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <small class="mb-3">Total Jam Lembur</small>
                                            <h6 class="mb-0"><i class="fa fa-clock-o"></i> {{ $data->overtime ?? '-' }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card mb-3">
                                        <div class="card-body" style="min-height: 130px;">
                                            <small class="mb-3">Alasan Pulang Cepat</small>
                                            <p class="mb-0">{{ $data->note ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-5 d-block align-items-start justify-content-end">
                            @if ($data->dokumen != null)
                                <div class="card">
                                    <div class="card-header text-center p-2 font-weight-bold text-success">
                                        Dokumen
                                    </div>
                                    <div class="card-body d-flex justify-content-center bg-secondary">
                                        <img style="height: 260px;" class="img-fluid" src="{{ asset('uploads/images/attendance/'.$data->foto_masuk) }}">
                                    </div>
                                </div>
                            @else
                            <div class="card">
                                <div class="card-header text-center p-2 font-weight-bold text-success">
                                    Dokumen
                                </div>
                                <div class="card-header d-flex align-items-center justify-content-center" style="height: 260px;">
                                    Tidak Ada Dokumen
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
        <div class="col-12">
            <div class="card pd-0 bd-0 shadow-base">
                <div class="pd-x-30 pd-t-30 pd-b-10">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mb-0">Lokasi Realtime Saat Mengajukan Izin
                            </h6>
                            <small>Tanggal : <b> {{ date('d-M-Y', strtotime($data->created_at))}} </b></small>
                        </div>
                        <div class="tx-13">
                            <p class="mg-b-0"><span class="square-8 rounded-circle bg-purple mg-r-10"></span> Koordinat
                                : <b> {{$data->latlong ?? '-'}} </b></p>
                            <p class="mg-b-0"><span class="square-8 rounded-circle bg-pink mg-r-10"></span> Waktu :
                                <b>{{ $data->created_at != null ? date('H:i:s', strtotime($data->created_at)) : '-'}}</b></p>
                        </div>
                    </div><!-- d-flex -->
                </div>
                <div class="pd-x-15 pd-b-15">
                    {{-- <div id="mapid" class="ht-200 ht-sm-200 ht-md-350 bd bg-gray-100"></div> --}}

                    @if ($site->is_using_radius != 0)
                        @if ($data->latlong != null)
                        <div id="mapid" style="width:100%; height:345px;"></div>
                        @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="width:100%; height:345px;">
                            <h5>Karyawan Belum Melakukan Absen Masuk</h5>
                        </div>
                        @endif
                    @else
                    <div style="width:100%; height:345px;" class="bg-gray-100 d-flex flex-column align-items-center justify-content-center">
                        <i class="tx-info icon ion-map tx-50"></i>
                        <h5 class="">Geolocation Sedang Tidak Aktif.</h5>
                    </div>
                    @endif
                </div>
            </div><!-- card -->
        </div><!-- col-9 -->
        
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

@if ($data->latlong != null)
<script>
    $(document).ready(function() {
      
        navigator.geolocation.getCurrentPosition((position) => {

            // -6.331146, 107.002307
            var map = L.map('mapid').setView([{{$data->latlong ?? '0,0'}}], 12);        
            var marker = L.marker([{{$data->latlong ?? '0,0'}}]).addTo(map);
    
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

@endif


@endpush
