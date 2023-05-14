@extends('layouts.app_panel.app', $head)

@section('content')
<div class="section">

    <div class="section-header d-md-flex justify-content-between align-items-center">
        <h1> {{$head['head_title_per_page'] ?? 'Title' }}</h1>
        <span class="float-right">{{$head['sub_title_per_page'] ?? 'Sub Title'}}</span>
    </div>
    
    <div class="row">

        <div class="col-sm-12 col-lg-5">
            <form action="{{route('user.absen.io')}}" method="POST" enctype="multipart/form-data">
                <div class="card p-0 bg-transparent shadow-none">
                    <div class="card-body bg-transparent p-0 overflow-hidden rounded">
                        <div class="row">
                            <div class="col-12 m-auto col-md-12">
                                @csrf

                                @if ($absensi_terakhir != null)
                                <div class="card card-statistic-1 border border-warning">
                                    <div class="card-icon bg-warning w-sm-25 w-md-50 p-0" style="width: 40%; overflow:hidden;">
                                      {{-- <i class="fas fa-clock"></i> --}}
                                      {{-- <img alt="image" class="rounded img-fluid w-full h-full m-0" src="{{ asset('uploads/images/attendance/'.$absensi_terakhir->foto_masuk) }}"> --}}


                                      <div class="gallery gallery-fw" data-item-height="100">
                                        <div class="gallery-item" data-image="{{ asset('uploads/images/attendance/'.$absensi_terakhir->foto_masuk) }}" data-title="Foto Check In"></div>
                                      </div>

                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4 class="mt-0 text-primary" style="font-size: 10px;">Data Check In Terkahir</small>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-0 text-warning" style="font-size: 15px;">
                                                <span class="">{{ date('d-m-Y', strtotime($absensi_terakhir->date))}}</span>
                                                |
                                                <span class="">{{$absensi_terakhir->clock_in}}</span>
                                            </div>
                                        </div>
                                        @if ($absensi_terakhir->type == 'absen_lembur')
                                            <span style="font-size:9px;" class="py-1 px-3 badge badge-dark">{{$absensi_terakhir->jenisLembur->type ?? ''}}</span>
                                        @elseif ($absensi_terakhir->type == 'absen_biasa')
                                            <span style="font-size:9px;" class="py-1 px-3 badge badge-info">Presensi Harian</span>
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                                
                                @endif  

                                <div class="card border">
                                    <div class="card-body p-1" style="overflow:hidden;">
                                        <div id="my_camera" class="rounded"></div>
                                        <div id="resultFoto"></div>
                                    </div>
                                    <div class="card-footer border-bottom px-3 pt-0 pb-2">
                                        <div class="d-flex align-items-center justify-content-center mt-1">
                                            <button type="button" id="btnCapture" class="btn btn-block btn-light shadow-none" onclick="take_snapshot()">
                                                <i class="fa fa-camera"></i>
                                                Ambil Gambar
                                            </button>
                                            
                                            <a href="" id="btnReCapture" class="btn mt-3 btn-light shadow-none btn-block">
                                                <i class="fa fa-history"></i> 
                                                Foto Ulang
                                            </a>
                                        </div>
                                    </div>

                                    <div class="card-footer px-3">
                                        <input type="hidden" name="usr" id="usr_in" value="{{auth()->user()->id}}">
                                        <input type="hidden" name="latlong" id="latlong1" value="">
                
                                        <div id="results"></div>
                                        
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <select name="type" class="form-control" id="type_absen">
                                                        <option value="" selected>-- Pilih Presensi --</option>
                                                        @if($absensi_terakhir == null)
                                                        <option value="absen_biasa_masuk">Check In Harian</option>
                                                        <option value="absen_lembur_masuk">Check In Lembur</option>
                                                        @else
                                                        <option value="absen_biasa_pulang">Checkout Harian</option>
                                                        <option value="absen_lembur_pulang">Checkout Lembur</option>
                                                        @endif
                                                    </select>
                                                </div>
                
                                                <div class="form-group" id="jenis_lembur">
                                                    <select class="form-control" name="jenis_lembur">
                                                        <option value="" selected disabled>-- Pilih Jenis Lembur --</option>
                
                                                            @if ($jenis_lembur)
                                                            @foreach ($jenis_lembur as $j)
                                                            <option value="{{$j->id}}">
                                                                {{$j->type}}</option>
                                                            @endforeach
                                                            @endif
                                                    </select>
                                                    @if($errors->has('jenis_lembur'))
                                                    <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center"
                                                        onclick="$(this).remove()">
                                                        <small>{{ $errors->first('jenis_lembur') }}</small>
                                                        <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
                                                    </div>
                                                    @endif
                                                </div>
                
                                                <div class="form-group">
                                                    
                                                    <textarea class="form-control" placeholder="Catatan"
                                                    name="note"
                                                    id="note_absen"
                                                    cols="5"
                                                    rows="4"></textarea>
                                                </div>
                                                
                                                <button type="submit" class="tbl-absen-in btn-block btn btn-md mt-2 btn-primary btn-with-icon">
                                                    <div class="ht-40 justify-content-center">
                                                        <span class="pd-x-15"><i class="fas fa-paper-plane"></i> KIRIM</span>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>        

                            </div>
                        </div>
                    </div><!-- card -->
                </div>
            </form>
        </div><!-- col-3 -->

        <div class="col-sm-12 col-lg-7">
            <div class="card border ">
                <div class="card-header">
                    <h4 class="card-title text-primary"><i class="fas fa-history"></i> Riwayat Presensi</h4>
                </div>
                <div class="card-body overflow-auto table-responsive">
                    <table id="datatable1" class="table table-striped nowrap w-full">
                        <thead class="">
                            <tr>
                                <th class="wd-5p">#</th>
                                <th class="">Pegawai</th>
                                <th class="">Jenis</th>
                                <th class="">Tanggal Check In</th>
                                <th class="">Jam Check In</th>
                                <th class="">Tanggal Check Out</th>
                                <th class="">Jam Check Out</th>
                                <th class="">Terlambat</th>
                                <th class="">Total Jam Kerja</th>
                                <th class="wd-5p">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            @endphp
                            @foreach ($logAbsen as $row)

                            @if($row->type == 'absen_biasa' || $row->type == 'absen_lembur')
                                <tr>
                                    <td>{{$i++}}.</td>
                                    <td>
                                        @if ($row->karyawan->photo_profile)
                                        <img width="30" class="rounded-circle" src="{{ asset('uploads/images/employee/'. $row->karyawan->photo_profile) }}">
                                        @else
                                        <img width="30" class="rounded-circle" src="{{ asset('images/default-ava.jpg') }}"> 
                                        @endif
                                        {{$row->karyawan->full_name}}
                                    </td>
                                    <td>
                                        @if ($row->type == 'absen_lembur')
                                            {{-- <span style="font-size:9px;" class="badge badge-dark">Presensi Lembur</span><br> --}}
                                            <span style="font-size:9px;" class="badge badge-dark">{{$row->jenisLembur->type ?? ''}}</span>
                                            @php
                                                // $total_kerja = $row->overtime != null ? \Carbon\Carbon::createFromTimestampUTC($row->overtime)->format('H:i:s') : '-';
                                                $total_kerja = $row->overtime != null ? \App\Helpers\General::convertSecondToStringTime($row->overtime) : '-';
                                            @endphp
                                        @elseif ($row->type == 'absen_biasa')
                                            <span style="font-size:9px;" class="badge badge-info">Presensi Harian</span>
                                            @php
                                                // $total_kerja = $row->total_work != null ? \Carbon\Carbon::createFromTimestampUTC($row->total_work)->format('H:i:s') : '-';
                                                $total_kerja = $row->total_work != null ? \App\Helpers\General::convertSecondToStringTime($row->total_work) : '-';
                                            @endphp
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ date('d-M-Y', strtotime($row->date))}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <i title="Perangkat" class="mr-1 text-success fa {{$row->device == 'web' ? 'fa-globe' : 'fa-mobile'}}"></i>
                                            <i title="Status Foto Chcek In" class="mr-1  {{ $row->foto_masuk != null ? 'text-success' : '' }} fa fa-image"></i>
                                            <i title="Status Lokasi" class="mr-1 {{$row->latlong_in != null ? 'text-success' : ''}} fa fa-map-marker"></i>
                                        </div>
                                        <span class="text-18 mt-1 font-weight-bold {{$row->late != null ? 'text-danger':'text-dark'}}">  {{ $row->clock_in != null ? date('H:i:s', strtotime($row->clock_in)) : '-'}} </span>

                                    </td>
                                    <td>{{ $row->date_out == null ? date('d-M-Y', strtotime($row->updated_at)) : date('d-M-Y', strtotime($row->date_out))}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <i title="Perangkat" class="mr-1 text-success fa {{ $row->device == 'web' ? 'fa-globe' : 'fa-mobile'}}"></i>
                                            <i title="Status Foto Chcek In" class="mr-1  {{ $row->foto_keluar != null ? 'text-success' : '' }} fa fa-image"></i>
                                            <i title="Status Lokasi" class="mr-1 {{$row->latlong_out != null ? 'text-success' : ''}} fa fa-map-marker"></i>
                                            @if ($row->is_auto_checkout_daily == 1) 
                                                <i title="Otomatis Cehck-out oleh Sistem" class="text-warning fa fa-sign-out"></i> 
                                            @endif 
                                        </div>
                                        <span class="text-18 mt-1 font-weight-bold text-dark">  {{ $row->clock_out != null ? date('H:i:s', strtotime($row->clock_out)) : '-'}} </span>
                                    </td>
                                    <td> <span class="{{$row->late != null ? 'text-danger':''}}"> {{ $row->late != null ?  \App\Helpers\General::convertSecondToStringTime($row->late) : '-'}} </span></td>
                                    <td>{{ $total_kerja ?? '-'}}</td>
                                    <td>

                                        @canany(['user-presensi-show'])
                                        <a href="{{route('user.absen.detail', $row->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Detail</a>
                                        @endcanany

                                    </td>
                                </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!-- card -->
        </div><!-- col-3 -->

        
    </div><!-- log -->
</div><!-- login-wrapper -->
@endsection


@push('active-absen')
active
@endpush

@push('menuOpen-absen')
style="display: block;"
@endpush

@push('showSub-absen')
show-sub
@endpush

@push('styles')
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js"></script>


<script>
      // menampilkan kamera dengan menentukan ukuran, format dan kualitas 
      Webcam.set({
        // width: 320,
        height: 328,
        // dest_width: 640,
        dest_height: 320,
        image_format: 'png',
        jpeg_quality: 90
    });

    $('#btnReCapture').hide();

    //menampilkan webcam di dalam file html dengan id my_camera
    Webcam.attach('#my_camera');

    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            document.getElementById('results').innerHTML = '<input id="results" type="hidden" name="foto" value="' + data_uri + '">';
             document.getElementById('resultFoto').innerHTML ='<img id="resultFoto" src="' + data_uri + '"/>';
        } );
        $('#my_camera').css('display', 'none');
        $('#btnCapture').css('display', 'none');
        $('#btnReCapture').css('display', 'block');
    }
</script>

<script>
    $(document).ready(function() {

        var timeFromPhp = "{{ $jam_pulang }}";
        var timeArray = timeFromPhp.split(":");
        var out = new Date();
        out.setHours(timeArray[0]);
        out.setMinutes(timeArray[1]);
        out.setSeconds(timeArray[2]);

        var outtHour = out.getHours();
        var outtMinute = out.getMinutes();
        var outtSecond = out.getSeconds();

        var today = new Date();
        var currentHour = today.getHours();
        var currentMinute = today.getMinutes();
        var currentSecond = today.getSeconds();

        $('#note_absen').hide();
        $('#jenis_lembur').hide();
        $('#type_absen').change(function() {
            // alert($('#type_absen option:selected').val());  
            
            if($('#type_absen option:selected').val() == 'absen_biasa_pulang') {
                $('#jenis_lembur').hide();
                if(currentHour < outtHour || (currentHour === outtHour && currentMinute < outtMinute) || (currentHour === outtHour && currentMinute === outtMinute && currentSecond < outtSecond)) {
                    $('#note_absen').show();
                } else {
                    $('#note_absen').hide();
                }
            } else if( $('#type_absen option:selected').val() == 'absen_biasa_masuk') {
                $('#note_absen').show();
                $('#jenis_lembur').hide();
            } else if( $('#type_absen option:selected').val() == 'absen_lembur_masuk') {
                $('#note_absen').show();
                $('#jenis_lembur').show();
            } else if( $('#type_absen option:selected').val() == 'absen_lembur_pulang') {
                $('#note_absen').show();
                $('#jenis_lembur').hide();
            } else {
                $('#note_absen').val('');
                $('#note_absen').hide();
            }
        });
    })
</script>

{{-- GET LOCATION ABSEN --}}
<script>
    let buttonMasuk = document.getElementById("get-location-masuk");
    let buttonPulang = document.getElementById("get-location-pulang");
    let field1 = document.getElementById("latlong1");
    let field2 = document.getElementById("latlong2");

    $(document).ready(function () {
        navigator.geolocation.getCurrentPosition((position) => {
            let lat = position.coords.latitude.toFixed(4);
            let long = position.coords.longitude.toFixed(4);
            var latlong = lat + ',' + long;
            field1.value = latlong;
            field2.value = latlong;
        });
    });

    buttonMasuk.addEventListener("click", () => {
        navigator.geolocation.getCurrentPosition((position) => {
            let lat = position.coords.latitude.toFixed(4);
            let long = position.coords.longitude.toFixed(4);
            var latlong = lat + ',' + long;
            field1.value = latlong;
            setTimeout(10000);
        });
    });

    buttonPulang.addEventListener("click", () => {
        navigator.geolocation.getCurrentPosition((position) => {
            let lat = position.coords.latitude.toFixed(4);
            let long = position.coords.longitude.toFixed(4);
            var latlong = lat + ',' + long;
            field2.value = latlong;
            setTimeout(10000);
        });
    });

</script>
@endpush
