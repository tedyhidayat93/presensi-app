@extends('layouts.public.app', $head)

@section('dynamic-content')
<div class="br-pagebody mg-t-5 pd-x-20  pd-b-200">
    
    <div class="card shadow-base bd-0">
        <div class="card-body pd-x-10 pd-b-10 pd-t-0">
            
            <div class="row no-gutters mt-4">

                <div class="col-sm-12 col-lg-3">
                    <form action="{{route('user.absen.io')}}" method="POST" enctype="multipart/form-data">
                        <div class="card">
                            <div class="card-body overflow-hidden px-2 pd-t-5  bg-dark rounded">
                                @csrf
                                <div id="my_camera" class="rounded"></div>
                                <div id="resultFoto"></div>
        
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <button type="button" id="btnCapture" class="btn mb-4 btn-teal rounded-circle" onclick="take_snapshot()"><i class="fa fa-camera"></i></button>
                                    <a href="" id="btnReCapture" class="btn mb-4 mt-3 btn-light"><i class="fa fa-history"></i> Foto Ulang</a>
                                </div>

                                <input type="hidden" name="usr" id="usr_in" value="{{auth()->user()->id}}">
                                <input type="hidden" name="latlong" id="latlong1" value="">

                                <div id="results"></div>
                                
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <select name="type" class="form-control" id="type_absen">
                                                <option value="" selected>-- Pilih Presensi --</option>
                                                <option value="absen_biasa_masuk">Presensi Masuk</option>
                                                <option value="absen_biasa_pulang">Presensi Pulang</option>
                                                <option value="absen_lembur_masuk">Presensi Lembur Masuk</option>
                                                <option value="absen_lembur_pulang">Presensi Lembur Pulang</option>
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
                                        
                                        <button type="submit" class="tbl-absen-in btn-block btn btn-md mt-2 btn-success btn-with-icon">
                                            <div class="ht-40 justify-content-center">
                                                <span class="pd-x-15">KIRIM PRESENSI</span>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div><!-- card -->
                        </div>
                    </form>
                </div><!-- col-3 -->

                <div class="col-sm-12 col-lg-9 ">
                    <div class="card card-body rounded-0 bd-lg-l-0 border-0 overflow-auto">


                            <div class="d-block d-md-flex justify-content-between tx-12">

                                <table class="table table-valign-middle mg-b-0 nowrap">
                                    <tbody>
                                        <tr>
                                            <td class=" bg-light" width="100">
                                                <div class="w-100 h-100 overflow-hidden d-flex align-items-center justify-content-center rounded">
                                                    
                                                    @if (auth()->user()->photo_profile)
                                                    <img class="w-100 h-100 rounded img-fluid" src="{{ asset('uploads/images/employee/'. auth()->user()->photo_profile) }}">
                                                    @else
                                                    <img class="w-100 h-100 rounded img-fluid" src="{{ asset('images/default-ava.jpg') }}"> 
                                                    @endif
                                                </div>
                                            </td>
                                            <td colspan="2">
                                                <h4 class="tx-teal tx-20 mg-b-0">{{auth()->user()->full_name}}</h4>
                                                <span class="tx-12"><b>Jabatan : </b> {{auth()->user()->jabatan->type ?? '-'}}</span>
                                            </td>
                                            <td>
                                                <span class="tx-12">Terdaftar Sejak</span>
                                                <h4 class="tx-inverse tx-14 mg-b-0">{{ date('d-M-Y', strtotime(auth()->user()->registered_at))}}</h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="tx-12">Shift</span>
                                                <h4 class="tx-inverse tx-14 mg-b-0">{{auth()->user()->shifft->shift_name}}</h4>
                                            </td>
                                            <td>
                                                <span class="tx-12">Email</span>
                                                <h4 class="tx-inverse tx-14 mg-b-0">{{auth()->user()->email}}</h4>
                                            </td>
                                            <td>
                                                <span class="tx-12">NIP</span>
                                                <h4 class="tx-inverse tx-14 mg-b-0">{{auth()->user()->nip}}</h4>
                                            </td>
                                            <td>
                                                <span class="tx-12">NIK</span>
                                                <h4 class="tx-inverse tx-14 mg-b-0">{{auth()->user()->nik}}</h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <hr>
                            <table id="datatable1" class="table display nowrap table-hover table-bordered">
                                <thead class="thead-teal">
                                    <tr>
                                        <th ><span class="tx-white">#</span></th>
                                        <th class=""> <span class="tx-white font-weight-bold"> Tanggal Masuk </span></th>
                                        <th class=""> <span class="tx-white font-weight-bold"> Jam Masuk </span></th>
                                        <th class=""> <span class="tx-white font-weight-bold"> Tanggal pulang </span></th>
                                        <th class=""> <span class="tx-white font-weight-bold"> Jam Pulang </span></th>
                                        <th class=""> <span class="tx-white font-weight-bold"> Terlambat </span></th>
                                        <th class=""> <span class="tx-white font-weight-bold"> Total </span></th>
                                        <th class=""> <span class="tx-white font-weight-bold"> Foto </span></th>
                                        <th class=""> <span class="tx-white font-weight-bold"> Catatan Masuk </span></th>
                                        <th class=""> <span class="tx-white font-weight-bold"> Catatan Keluar </span></th>
                                        <th class=""> <span class="tx-white font-weight-bold"> Jenis</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i=1;
                                        $total_kerja = '-';
                                    @endphp
                                    @foreach ($logAbsen as $log)
                                    <tr>
                                        <td>{{$i++}}.</td>
                                        {{-- <td> <span> {{date('d F Y', strtotime($log->date))}} </span></td> --}}
                                        <td> {{ date('d-M-Y', strtotime($log->date))}} </td>
                                        <td> {{$log->clock_in}} </td>
                                        <td>{{ $log->date_out == null ? date('d-M-Y', strtotime($log->updated_at)) : date('d-M-Y', strtotime($log->date_out))}}</td>
                                        <td> {{$log->clock_out ?? '-'}}</td>
                                        <td> {{$log->late != null ? \App\Helpers\General::convertSecondToStringTime($log->late) : '-' }} </td>

                                        @if ($log->type == 'absen_lembur')
                                            @php
                                                $total_kerja = $log->overtime != null ? \App\Helpers\General::convertSecondToStringTime($log->overtime) : '-';
                                            @endphp
                                        @elseif ($log->type == 'absen_biasa')
                                            @php
                                                $total_kerja = $log->total_work != null ? \App\Helpers\General::convertSecondToStringTime($log->total_work) : '-';
                                            @endphp
                                        @else
                                            -
                                        @endif


                                        <td> {{$total_kerja}}</td>
                                        <td>
                                            @if ($log->foto_masuk != null)
                                                <a href="{{asset('uploads/images/attendance/'.$log->foto_masuk) }}" target="_blank">
                                                    <img width="30" src="{{ asset('uploads/images/attendance/'.$log->foto_masuk) }}">
                                                </a>
                                            @else
                                            -
                                            @endif

                                            @if ($log->foto_keluar != null)
                                                <a href="{{asset('uploads/images/attendance/'.$log->foto_keluar) }}" target="_blank">
                                                    <img width="30" src="{{ asset('uploads/images/attendance/'.$log->foto_keluar) }}">
                                                </a>
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td>
                                            {{$log->note_in ?? '-'}}
                                        </td>
                                        <td>
                                            {{$log->note_out ?? '-'}}
                                        </td>
                                        <td> 
                                            <span>
                                                @if ($log->type == 'absen_lembur')
                                                <span class="badge badge-dark">Presensi Lembur</span><br>
                                                <span class="badge badge-light">{{$log->jenisLembur->type ?? ''}}</span>
                                                
                                            @elseif ($log->type == 'absen_biasa')
                                                <span class="badge badge-info">Presensi Harian</span>
                                               
                                            @else
                                                -
                                            @endif
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div><!-- card -->
                </div><!-- col-3 -->

                
            </div><!-- log -->
        
        </div><!-- card-body -->
      
    </div><!-- card -->
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
        // width: 380,
        height: 280,
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
