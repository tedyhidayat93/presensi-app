@extends('layouts.auth.app', $head)

@section('content')
<div class="login-wrapper bg-transparent h-full wd-400 wd-xs-750 pd-20 pd-xs-10 mg-0 rounded overflow-hidden shadow-none">
    <div class="row d-none d-md-block">
        <div class="col text-center d-flex align-items-center justify-content-center">
            @if ($site->logo != null)
            <div class="text-center mg-b-30">
                <img class="" src="{{asset('uploads/images/site') . '/' . $site->logo}}" width="40">
            </div>
            &nbsp;
            &nbsp;
            @endif
            <div class="text-left">
                <div class="signin-logo text-20 text-bold text-inverse">
                    <span class="text-success"> {{$site->site_name}} </span>
                </div>
                <div class=" mg-b-30 text-12 text-white"> 
                    <i> {{$tagline_app ?? 'Aplikasi Presensi Kehadiran Karyawan'}} </i>
                </div>
            </div>
        </div>
    </div>

    <div class="row mg-b-10">
        <div class="col">
            @if ($message = Session::get('success'))
            <div class="text-center alert alert-success bd bd-success-400" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-flex align-items-center justify-content-start">
                    <i class="icon ion-ios-checkmark alert-icon text-32 mg-t-5 mg-xs-t-0"></i>
                    <span><strong>Well done!</strong> {{ $message }}</span>
                </div><!-- d-flex -->
            </div><!-- alert -->
            @elseif ($message = Session::get('error'))
            <div class="text-center alert alert-danger bd bd-danger-400" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-flex align-items-center justify-content-start">
                    <i class="icon ion-ios-close alert-icon text-32 mg-t-5 mg-xs-t-0"></i>
                    <span><strong>Sorry,</strong> {{ $message }}</span>
                </div><!-- d-flex -->
            </div><!-- alert -->
            @endif
        </div>
    </div>

    <div class="card shadow-base bd-0 mg-t-10">
        <div class="card-header bg-transparent pd-x-25 pd-y-15 bd-b-0 d-flex justify-content-between align-items-start">
            <div class="">
                <h6 class="card-title text-uppercase text-12 mg-b-0"><i class="fa fa-calendar"></i> {{$date_now}}</h6>
                <a href="#" class="text-gray-700 hover-info lh-0 text-12"><i class="fa fa-clock-o"></i> JAM : <span
                        class="font-weight-bold" id="clock"></span></a>
            </div>
            <a href="{{route('logout')}}" class="btn btn-danger text-10 pd-3"><i class="icon ion-power"></i> Sign Out</a>
        </div><!-- card-header -->
        <div class="card-body pd-x-25 pd-b-25 pd-t-0">
            <div class="row no-gutters">
                <div class="col-sm-6 col-lg-6">
                    <div class="card card-body d-flex justify-content-center align-items-center overflow-hidden bg-dark pd-0 rounded-0">
                        <div id="my_camera"></div>
                    </div><!-- card -->
                </div><!-- col-3 -->

                <div class="col-sm-6 col-lg-6 mg-t--1 mg-sm-t-0 mg-lg-l--1">
                    <div class="card card-body rounded-0 bd-lg-l-0">
                        <div class="d-block d-md-flex justify-content-between text-12">
                            <div>
                                <h6 class="text-inverse text-14 mg-b-5">{{auth()->user()->full_name ?? ''}}</h6>
                                <span class="text-12">Jabatan : <b> {{auth()->user()->jabatan->type ?? ''}}</span><br>
                            </div>
                            <div>
                                <span class="text-12">NIK : <b> {{auth()->user()->nik ?? ''}}</span>
                                <br>
                                <span class="text-12">NIP : <b> {{auth()->user()->nip ?? ''}}</span>
                            </div>
                        </div>
                        <div class="text-center mg-y-10">
                            @if (auth()->user()->photo_profile != null && auth()->user()->role == 'user')
                            <img class="wd-60 wd-md-90  rounded-circle"
                                src="{{ asset('uploads/images/employee/'. auth()->user()->photo_profile) }}">
                            @else
                            <img class="wd-60 wd-md-90 rounded-circle"
                                src='https://avataaars.io/?avatarStyle=Circle&topType=ShortHairTheCaesar&accessoriesType=Prescription02&hairColor=BrownDark&facialHairType=Blank&clotheType=BlazerShirt&eyeType=Default&eyebrowType=Default&mouthType=Default&skinColor=Light' />
                            @endif
                        </div>
                        <div class="d-flex  align-items-center justify-content-center w-100 mb-3">
                            <div class="form-group d-flex align-items-center mb-0">
                                <input type="radio" name="jenis_absen" checked value="absen_biasa" class="form-control jenis-absen" id="">
                                <label for="" class="mt-2 ml-2 text-dark">Harian</label>
                            </div>
                            &nbsp;
                            &nbsp;
                            <div class="form-group d-flex align-items-center mb-0">
                                <input type="radio" name="jenis_absen" disabled value="absen_lembur" class="form-control jenis-absen" id="">
                                <label for="" class="mt-2 ml-2 text-dark">Lembur</label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between text-12">
                            <div>
                                <form action="{{route('user.absen.io')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="typ" id="typ_in" value="i">
                                    <input type="hidden" name="usr" id="usr_in" value="{{auth()->user()->id}}">
                                    <input type="hidden" name="latlong" id="latlong1" value="">
                                    <button type="button" {{ $absen->clock_in != null ? 'disabled' : '' }} id="get-location-masuk"
                                        class="tbl-absen-in btn btn-md btn-success btn-with-icon">
                                        <div class="ht-40 justify-content-between">
                                            <span class="pd-x-15">MASUK</span>
                                            <span class="icon wd-40"><i class="fa fa-clock-o"></i></span>
                                        </div>
                                    </button>
                                </form>
                            </div>
                            <div>
                                <form action="{{route('user.absen.io')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="typ" id="typ_out" value="o">
                                    <input type="hidden" name="usr" id="usr_out" value="{{auth()->user()->id}}">
                                    <input type="hidden" name="latlong" id="latlong2" value="">
                                    <button type="submit" {{ $absen->clock_in == null || $absen->clock_out != null ? 'disabled' : '' }}  id="get-location-pulang"
                                        class="tbl-absen-out btn btn-md btn-primary btn-with-icon">
                                        <div class="ht-40 justify-content-between">
                                            <span class="pd-x-15">PULANG</span>
                                            <span class="icon wd-40"><i class="fa fa-share"></i></span>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div><!-- d-flex -->
                    </div><!-- card -->
                </div><!-- col-3 -->
            </div><!-- row -->
        </div><!-- card-body -->
        <div class="card-footer d-block bg- d-md-flex justify-content-between align-items-center">
            <div class="">
                <a href="#" class="text-gray-700 font-weight-bold mg-b-0  mg-t-0 hover-info lh-0 text-12">
                    Jadwal : 
                    @foreach (auth()->user()->shifts as $shift)
                    <span href="#" class="text-info"> {{$shift->shift_name}}</span>,
                    @endforeach
                </a>
            </div>
            <div>
                <span class="card-title text-uppercase text-10 mg-b-0">Masuk : <span class="text-info text-10">{{$absen->clock_in ?? '-'}}</span></span> 
                &nbsp; | &nbsp;
                <span class="card-title text-uppercase text-10 mg-b-0">Pulang : <span class="text-info text-10">{{$absen->clock_out ?? '-'}}</span></span>
            </div>
        </div>
        <div class="card-footer bg-white overflow-y-auto pd-0 pd-b-0" style="max-height: 280px;">
        
            <table class="bd table table-bordered">
                <thead class="thead-light">
                    {{-- <tr>
                        <th class="bg-light" colspan="3">
                            <h6 class="text-dark text-center mb-0 text-13">Log Absensi</h6>
                        </th>
                    </tr> --}}
                    <tr>
                        <th class="py-2 px-3"> <small class="font-weight-bold"> Log Tanggal </small></th>
                        <th class="py-2 px-3"> <small class="font-weight-bold"> Log Jam Masuk </small></th>
                        <th class="py-2 px-3"> <small class="font-weight-bold"> Log Jam Pulang </small></th>
                        <th class="py-2 px-3"> <small class="font-weight-bold"> Jenis Absen</small></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logAbsen as $log)
                    <tr>
                        {{-- <td> <small> {{date('d F Y', strtotime($log->date))}} </small></td> --}}
                        <td class="py-2 px-3"> <small> {{ \App\Helpers\General::dateIndo($log->date)}} </small></td>
                        <td class="py-2 px-3"> <small>{{$log->clock_in}} </small></td>
                        <td class="py-2 px-3"> <small>{{$log->clock_out ?? '-'}}</small></td>
                        <td class="py-2 px-3"> 
                            <small>
                                @if ($log->type == 'absen_lembur')
                                    Lembur
                                @elseif ($log->type == 'absen_biasa')
                                    Harian
                                @else
                                    -
                                @endif
                            </small>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div><!-- card -->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js"></script>


{{-- WEBCAM SNAP FOTO --}}
<script language="JavaScript">
    // menampilkan kamera dengan menentukan ukuran, format dan kualitas 
    Webcam.set({
        width: 330,
        height: 290,
        image_format: 'png',
        jpeg_quality: 90
    });

    //menampilkan webcam di dalam file html dengan id my_camera
    Webcam.attach('#my_camera');

</script>

{{-- AJAX SAVE ABSEN --}}
<script type="text/javascript">
    // saat dokumen selesai dibuat jalankan fungsi update
    // $(document).ready(function () {
    //     update();
    // });

    // absen in
    $(".tbl-absen-in").click(function () {
        // alert(1)
        event.preventDefault();

        // membuat variabel image
        var image = '';

        
        var jenis_absen = $('input[name=jenis_absen]:checked').val();
        var type = $('#typ_in').val();
        var usr = $('#usr_in').val();
        var latlong = $('#latlong1').val();

        //memasukkan data gambar ke dalam variabel image
        Webcam.snap(function (data_uri) {
            image = data_uri;
        });

        //mengirimkan data ke file action.php dengan teknik ajax
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('user.absen.io') }}',
            method: 'POST',
            data: {
                jenis_absen: jenis_absen,
                typ: type,
                usr: usr,
                latlong: latlong,
                image: image
            },
            success: function () {
                alert('Absen Masuk berhasil');
                // menjalankan fungsi update setelah kirim data selesai dilakukan 
                update()
            }
        })
    });

    // absen out
    $(".tbl-absen-out").click(function () {
        // alert(1)
        event.preventDefault();

        // membuat variabel image
        var image = '';

        var type = $('#typ_out').val();
        var usr = $('#usr_out').val();
        var latlong = $('#latlong2').val();

        //memasukkan data gambar ke dalam variabel image
        Webcam.snap(function (data_uri) {
            image = data_uri;
        });

        //mengirimkan data ke file action.php dengan teknik ajax
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('user.absen.io') }}',
            method: 'POST',
            data: {
                typ: type,
                usr: usr,
                latlong: latlong,
                image: image
            },
            success: function () {
                alert('Absen Pulang berhasil');
                // menjalankan fungsi update setelah kirim data selesai dilakukan 
                update()
            }
        })
    });

    //fungsi update untuk menampilkan data / reload
    function update() {
        location.reload();
        // $.ajax({
        //     url: 'data.php',
        //     type: 'get',
        //     success: function (data) {
        //         $('#data').html(data);
        //     }
        // });
    }

</script>

{{-- JAM DIGITAL --}}
<script>
    function updateClock() {
        var currentTime = new Date();
        // Operating System Clock Hours for 12h clock
        var currentHoursAP = currentTime.getHours();
        // Operating System Clock Hours for 24h clock
        var currentHours = currentTime.getHours();
        // Operating System Clock Minutes
        var currentMinutes = currentTime.getMinutes();
        // Operating System Clock Seconds
        var currentSeconds = currentTime.getSeconds();
        // Adding 0 if Minutes & Seconds is More or Less than 10
        currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
        currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;
        // Picking "AM" or "PM" 12h clock if time is more or less than 12
        var timeOfDay = (currentHours < 12) ? "AM" : "PM";
        // transform clock to 12h version if needed
        currentHoursAP = (currentHours > 12) ? currentHours - 12 : currentHours;
        // transform clock to 12h version after mid night
        currentHoursAP = (currentHoursAP == 0) ? 12 : currentHoursAP;
        // display first 24h clock and after line break 12h version
        var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds;
        // var currentTimeString = "24h kello: " + currentHours + ":" + currentMinutes + ":" + currentSeconds + "" + "<br>" + "12h kello: "    + currentHoursAP + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
        // print clock js in div #clock.
        $("#clock").html(currentTimeString);
    }
    $(document).ready(function () {
        setInterval(updateClock, 1000);
    });

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
