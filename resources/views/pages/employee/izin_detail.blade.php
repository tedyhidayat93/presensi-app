@extends('layouts.app_panel.app', $head)


@section('content')
<div class="section">
    <div class="section-header">
        <h1> {{$head['head_title_per_page'] ?? 'Title' }}</h1>
    </div>
    <div class="row">
        <div class="col">
            <div class="card bd-0 shadow-base">
                <div class="card-header">
                    <a href="{{route('user.izin')}}" class="btn btn-light btn-sm"><i class="fa fa-arrow-left"></i> Kembali </a>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-12 col-md-7 table-responsive overflow-auto">
    
                            <div class="row">
                                <div class="col-12 col-md-12">
                                    <div class="card mb-3 border">
                                        <div class="card-body">

                                            <small class="mb-0">Pemohon Izin </small>
                                            
                                            <div class="mt-3 d-md-flex align-items-center">
                                                <div class="mr-3">
                                                    @if ($data->user->photo_profile)
                                                    <img width="50" class="rounded-circle img-fluid" src="{{ asset('uploads/images/employee/'. $data->user->photo_profile) }}">
                                                    @else
                                                    <img width="50" class="rounded-circle img-fluid" src="{{ asset('images/default-ava.jpg') }}"> 
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="text-dark mb-0">{{$data->user->full_name}}</h6>
                                                    <span class="mt-0"><b>Jabatan : </b> {{$data->user->jabatan->type ?? '-'}}</span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="card mb-3 border">
                                        <div class="card-body">
                                            <small class="mb-3">Jenis Izin </small>
                                            <h6 class="">{{$data->jenis->type ?? '-'}}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="card mb-3 border">
                                        <div class="card-body">
                                            <small class="mb-2">Tanggal Izin</small>
                                            <h6 class="mb-2">{{ date('d-M-Y H:i', strtotime($data->created_at))}}</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="card mb-3 border">
                                        <div class="card-body" style="min-height: 130px;">
                                            <small class="mb-3">Alasan Izin</small>
                                            <h6 class="mb-0">{{ $data->alasan ?? '-' }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col d-flex align-items-center justify-content-between">
                                    <span> 
                                        <b> Status : </b> 
                                        @if($data->is_approve == 2)
                                        <span class="badge badge-success">Disetujui</span>
                                        @elseif($data->is_approve == 3)
                                        <span class="badge badge-danger">Ditolak</span>
                                        @elseif($data->is_approve == 1)
                                        <span class="badge badge-warning text-white">Menuggu</span>
                                        @endif
                                    </span>
                                    <span> <b> Divalidasi Oleh : </b> {{$data->validator->full_name ?? '-'}}</span>
                                    <span> <b> Tanggal Validasi: </b> {{ $data->validation_at != null ? date('d-M-Y H:i', strtotime($data->validation_at)) : '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-5 d-block align-items-start justify-content-end">
                            @if ($data->dokumen != null)
                                <div class="card">
                                    <div class="card-header d-flex align-items-center justify-content-between p-2">
                                        <h6 class="card-title mb-0 font-weight-bold text-primary">
                                            <i class="fas fa-file"></i> Dokumen Terlampir
                                        </h6>
                                        <a href="{{ asset('uploads/izin/'. $data->dokumen) }}" class="btn btn-sm btn-primary" target="_blank"><i class="fas fa-eye"></i> Buka</a>
                                    </div>
                                    <div class="card-body d-flex p-1 justify-content-center bg-secondary">
                                        <iframe style="height: 420px;" src="{{ asset('uploads/izin/'. $data->dokumen) }}" frameborder="0"></iframe>
                                    </div>
                                </div>
                            @else
                            <div class="card">
                                <div class="card-header text-center p-2 font-weight-bold text-success">
                                    Dokumen Terlampir
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

    <div class="row">
        <div class="col-12">
            <div class="card pd-0 bd-0 shadow-base">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-13 text-uppercase text-inverse font-weight-bold text-spacing-1 mb-0">Lokasi Saat Mengajukan Permohonan Izin
                            </h6>
                            <small>Tanggal : <b> {{ date('d-M-Y', strtotime($data->created_at))}} </b></small>
                        </div>
                        <div class="text-13">
                            <p class="mb-0">
                                <i class="fas fa-map"></i> Koordinat
                                : <b> {{$data->latlong ?? '-'}} </b>
                            </p>
                            <p class="mt-0">
                                <i class="fas fa-clock"></i> Waktu 
                                :<b>{{ $data->created_at != null ? date('H:i:s', strtotime($data->created_at)) : '-'}}</b>
                            </p>
                        </div>
                    </div><!-- d-flex -->
                </div>
                <div class="card-body">
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
                        <i class="text-info icon ion-map text-50"></i>
                        <h5 class="">Geolocation Sedang Tidak Aktif.</h5>
                    </div>
                    @endif
                </div>
            </div><!-- card -->
        </div><!-- col-9 -->
        
    </div><!-- row -->

</div><!-- br-pagebody -->

<div id="modaldemo" class="modal fade">
   <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fa fa-question-circle my-4 {{$data->is_active == 1 ? 'text-danger' : 'text-success'}} d-inline-block" style="font-size: 40px;"></i>
                <h4 class="{{$data->is_active == 1 ? 'text-danger' : 'text-success'}} font-weight-bold mg-b-20">Yakin Menyetujui Permohonan Izin ?
                </h4>
                <p class="mg-b-20 mg-x-20"><b>Alasan Izin : </b>  " {{$data->alasan ?? '-'}} "</p>
                <a href="{{route('adm.izin.acc', ['id' => $data->id, 'act' => 3])}}" class="btn btn-danger text-11 text-uppercase pd-y-12 pd-x-25 text-mont text-medium mg-b-20">Tolak</a>
                <a href="{{route('adm.izin.acc', ['id' => $data->id, 'act' => 2])}}" class="btn btn-success text-11 text-uppercase pd-y-12 pd-x-25 text-mont text-medium mg-b-20">Setujui</a>
            </div><!-- modal-body -->
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

@endsection


@push('active-izin')
active
@endpush

@push('menuOpen-izin')
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




@endpush
