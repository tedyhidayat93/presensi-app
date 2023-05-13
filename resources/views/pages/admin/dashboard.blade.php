@extends('layouts.app_panel.app', $head)


@section('content')
<section class="section">
  <div class="section-header d-md-flex justify-content-between align-items-center">
    <h1> {{$head['head_title_per_page'] ?? 'Title' }}</h1>
    <span class="float-right">{{$head['sub_title_per_page'] ?? 'Sub Title'}}</span>
  </div>


<div class="row">
  <div class="col-lg-4 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-primary">
        <i class="fas fa-user-tie"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Total Pegawai</h4>
        </div>
        <div class="card-body">
          {{$total_employee}}
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-info">
        <i class="fas fa-users"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Total Admin</h4>
        </div>
        <div class="card-body">
          {{$total_admin}}
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-warning">
        <i class="fas fa-globe"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Zona Waktu</h4>
        </div>
        <div class="card-body">
          <h6 class="m-0 mt-1">
            {{$site->timezone}}
          </h6>
          <small class="text-secondary mt-0" style="font-size:10px;">{{$date_now}}</small>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="row">

    <div class="col-12 col-md-6">

        <div class="card">
          <div class="card-header d-md-flex justify-content-between align-items-center pb-0">
            <div>
                <h6 class="card-title mb-0">Pegawai yang Izin Per Hari
                    Ini <b class="text-info">({{count($izin_waiting)}})</b></h6>
            </div>
            <a href="{{route('adm.izin')}}" class="text-info"> Selengkapnya</a>
          </div>
          <div class="card-body">
            <div style="min-height: 280px; max-height: 280px; overflow-y: auto;">
                <table class="table table-valign-middle mg-b-0">
                    <tbody>
                        @forelse ($izin_waiting as $row)
                        <tr>
                            <td class="">
                                @if ($row->user->photo_profile)
                                <div class="d-flex align-items-center justify-content-center"
                                    style="width:40px; height:40px; overflow:hidden; border-radius: 50%; border: 2px solid #0000ff;">
                                    <img width="50" height="50" class="img-fluid"
                                        src="{{ asset('uploads/images/employee/'. $row->user->photo_profile) }}">
                                </div>
                                @else
                                <div class="d-flex align-items-center justify-content-center"
                                    style="width:40px; height:40px; overflow:hidden; border-radius: 50%; border: 2px solid #0000ff;">
                                    <img width="50" height="50" class="img-fuild"
                                        src="{{ asset('images/default-ava.jpg') }}">
                                </div>
                                @endif
                            </td>
                            <td>
                                <h6 class="tx-inverse tx-14 mg-b-0">{{$row->user->full_name}}</h6>
                                <span class="tx-12">{{$row->type == 'staff' ? 'STAFF' : 'NON STAFF'}}</span>
                            </td>
                            <td>
                                <span class="tx-12">Tanggal</span>
                                <h6 class="tx-inverse tx-14 mg-b-0">
                                    {{$row->created_at != null ? date('d-M-Y H:i', strtotime($row->created_at)) : '-'}}
                                </h6>
                            </td>
                            <td>
                                <span class="tx-12">Jenis</span>
                                <h6 class="tx-inverse tx-14 mg-b-0">{{$row->jenis->type ?? '-'}}</h6>
                            </td>
                            <td class="pd-r-0-force tx-center"><a href="{{route('adm.izin.detail', $row->id)}}"
                                    class="tx-gray-600"><i class="fa fa-eye text-info tx-18 lh-0"></i></a></td>
                        </tr>
                        @empty
                        <tr class="bg-light">
                            <td><h6 class="text-center">Belum ada data</h6></td>
                        </tr>
                        @endforelse
                        

                    </tbody>
                </table>
            </div>
          </div>
        </div><!-- card -->
    </div><!-- col-3 -->

    <div class="col-12 col-md-6">

        <div class="card">
          <div class="card-header d-md-flex justify-content-between align-items-center pb-0">
            <h6 class="card-title mb-0">Pegawai Telat Per
                Hari Ini <b class="text-info">({{count($absen_telat_today)}})</b> </h6>
                <a href="{{route('adm.absen')}}" class="text-info"> Selengkapnya</a>
          </div>
          <div class="card-body">
            <div style="min-height: 280px; max-height: 280px; overflow-y: auto;">
                <table class="table table-valign-middle mg-b-0">
                    <tbody>
                        @forelse ($absen_telat_today as $row)
                        <tr>
                            <td class="">
                                @if ($row->karyawan->photo_profile)
                                <div class="d-flex align-items-center justify-content-center"
                                    style="width:40px; height:40px; overflow:hidden; border-radius: 50%; border: 2px solid red;">
                                    <img width="50" height="50" class="img-fluid"
                                        src="{{ asset('uploads/images/employee/'. $row->karyawan->photo_profile) }}">
                                </div>
                                @else
                                <div class="d-flex align-items-center justify-content-center"
                                    style="width:40px; height:40px; overflow:hidden; border-radius: 50%; border: 2px solid red;">
                                    <img width="50" height="50" class="img-fuild"
                                        src="{{ asset('images/default-ava.jpg') }}">
                                </div>
                                @endif
                            </td>
                            <td>
                                <h6 class="tx-inverse tx-14 mg-b-0">{{$row->karyawan->full_name}}</h6>
                                <span class="tx-12">{{$row->type === 'staff' ? 'STAFF' : 'NON STAFF'}}</span>
                            </td>
                            <td>
                                <span class="tx-12">Jam Masuk</span>
                                <h6 class="tx-inverse tx-14 mg-b-0">
                                    {{$row->clock_in != null ? date('H:i:s', strtotime($row->clock_in)) : '-'}}</h6>
                            </td>
                            <td>
                                <span class="tx-12">Terlambat</span>
                                <h6 class="tx-inverse tx-14 mg-b-0">{{\Carbon\Carbon::createFromTimestampUTC($row->late)->format('H:i:s')}}</h6>
                            </td>
                            <td class="pd-r-0-force tx-center"><a href="{{route('adm.absen.detail', $row->id)}}"
                                    class="tx-gray-600"><i class="fa fa-eye text-info tx-18 lh-0"></i></a></td>
                        </tr>
                        @empty
                        <tr class="bg-light">
                            <td><h6 class="text-center">Belum ada data</h6></td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
          </div>
        </div><!-- card -->

    </div><!-- col-3 -->
</div><!-- row -->

<div class="row">
    <div class="col-12 col-md-6 col-xl-6">
        <div class="card">
          <div class="card-header d-md-flex justify-content-between align-items-center pb-0">
            <h6 class="card-title mb-0">Grafik Permohonan Izin</h6>
            <b class="text-info"> Per Tahun : {{date('Y')}} </b>
          </div>
          <div class="card-body">
            <div class="bd pd-t-30 pd-b-20 pd-x-20"><canvas id="chartBar2" height="150"></canvas></div>
          </div>
        </div><!-- card -->
    </div><!-- col-6 -->

    <div class="col-12 col-md-6 col-xl-6">
        <div class="card">
          <div class="card-header d-md-flex justify-content-between align-items-center pb-0">
            <h6 class="card-title mb-0">Grafik Kedisiplinan Pegawai
                (Datang Terlambat)</h6>
              <b class="text-info">Per Tahun : {{date('Y')}} </b>
          </div>
          <div class="card-body">
            <div class="bd pd-t-30 pd-b-20 pd-x-20"><canvas id="chartBar1" height="150"></canvas></div>
          </div>
        </div><!-- card -->

    </div><!-- col-6 -->
</div>
  
</section>
@endsection


@push('active-dashboardAdmin')
active
@endpush

@push('menuOpen-dashboardAdmin')
@endpush

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
    integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
@endpush

@push('scripts')
<script src="{{asset('template/backend')}}/lib/chart.js/Chart.js"></script>
<script>
    $(function () {
        'use strict';

        var ctx1 = document.getElementById('chartBar1').getContext('2d');
        var myChart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: [{!!$grafik_disiplin['bulan'] !!}],
                datasets: [{
                    label: 'Total',
                    data: [{!! $grafik_disiplin['progres'] !!}],
                    backgroundColor: '#27AAC8'
                }]
            },
            options: {
                legend: {
                    display: false,
                    labels: {
                        display: false
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontSize: 10
                            // max: 80
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontSize: 11
                        }
                    }]
                }
            }
        });

        var ctx2 = document.getElementById('chartBar2').getContext('2d');
        var myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: [{!!$grafik_izin['bulan'] !!}],
                datasets: [{
                    label: 'Total',
                    data: [{!! $grafik_izin['progres'] !!}],
                    backgroundColor: '#fcba03'
                }]
            },
            options: {
                legend: {
                    display: false,
                    labels: {
                        display: false
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontSize: 10
                            // max: 80
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontSize: 11
                        }
                    }]
                }
            }
        });
    });
    

</script>

<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
<script>
    $(document).ready(function () {

        navigator.geolocation.getCurrentPosition((position) => {
            // let lat = parseFloat(position.coords.latitude.toFixed(4)) ;
            // let long = parseFloat(position.coords.longitude.toFixed(4));
            // let lat = position.coords.latitude.toFixed(4);
            // let long =position.coords.longitude.toFixed(2);

            $('#latText').html({
                {
                    $zona - > lat_loc ? ? -6.331146,
                }
            });
            $('#longText').html({
                {
                    $zona - > long_loc ? ? 107.002307
                }
            });

            // -6.331146, 107.002307
            var map = L.map('mapid').setView([{
                {
                    $zona - > lat_loc ? ? -6.331146,
                }
            }, {
                {
                    $zona - > long_loc ? ? 107.002307
                }
            }], 19);
            var marker = L.marker([{
                {
                    $zona - > lat_loc ? ? -6.331146,
                }
            }, {
                {
                    $zona - > long_loc ? ? 107.002307
                }
            }]).addTo(map);

            // Disable dragging when user's cursor enters the element
            // map.getContainer().addEventListener('mouseover', function () {
            //     map.dragging.disable();
            // });        

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            L.circle([{
                {
                    $zona - > lat_loc ? ? -6.331146,
                }
            }, {
                {
                    $zona - > long_loc ? ? 107.002307
                }
            }], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: {
                    {
                        $zona - > radius ? ? 10
                    }
                }
            }).addTo(map);
        });

    })

</script>
@endpush
