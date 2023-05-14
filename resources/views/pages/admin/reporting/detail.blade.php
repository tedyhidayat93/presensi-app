@extends('layouts.app_panel.app', $head)

@section('content')
<div class="section">
    <div class="section-header">
        <h1> Detail Laporan</h1>
    </div>

    <div class="row">
        <div class="col-12 mb-3">

            <div class="card">
                <div class="card-body d-md-flex justify-content-between align-items-center">
                    <div class="mt-3 d-md-flex align-items-center">
                        <div class="mr-3">
                            @if ($user->photo_profile)
                            <img width="50" class="rounded-circle img-fluid" src="{{ asset('uploads/images/employee/'. $user->photo_profile) }}">
                            @else
                            <img width="50" class="rounded-circle img-fluid" src="{{ asset('images/default-ava.jpg') }}"> 
                            @endif
                        </div>
                        <div>
                            <h6 class="text-dark mb-0">{{$user->full_name}}</h6>
                            <span class="mt-0"><b>Jabatan : </b> {{$user->jabatan->type ?? '-'}}</span>
                        </div>
                    </div>
                    <div>
                        @canany(['admin-laporan-download'])
                        <a target="_blank" href="{{route('adm.report.export.detail', ['data' => 'excel', 'karyawan' => request()->query('karyawan'), 'from' => request()->query('from_date'), 'to' => request()->query('to_date')])}}" class="btn btn-sm text-dark btn-success">
                            <i class="fa fa-download"></i>
                            Download Laporan Excel
                        </a>
                        <a target="_blank" href="{{route('adm.report.export.detail', ['data' => 'pdf', 'karyawan' => request()->query('karyawan'), 'from' => request()->query('from_date'), 'to' => request()->query('to_date')])}}" class="btn btn-sm btn-danger ml-2">
                            <i class="fa fa-download"></i>
                            Download Laporan PDF
                        </a>
                        @endcanany
                    </div>

                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header d-block d-md-flex align-item-center justify-content-between mb-3">
                    <div class="d-flex align-items-center ">
                        <h6 class="card-title text-primary text-uppercase  ">Riwayat Presensi</h6>
                    </div>
                    @if (request()->query('from_date') != '' || request()->query('to_date') != '')
                    <div class="d-flex align-items-center">
                        <h6 style="font-size: 14px;" class="text-dark "> 
                            <b> Periode :  </b>
                            <b class="text-primary">
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', request()->query('from_date'))->isoFormat('D MMMM Y'); }} 
                            </b>
                            &nbsp;
                            -
                            &nbsp;
                            <b class="text-primary">
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', request()->query('to_date'))->isoFormat('D MMMM Y'); }}
                            </b>
                        </h6>
    
                        <h6 style="font-size: 14px;" class="text-dark"> &nbsp;&nbsp;|&nbsp;&nbsp;</h6>
                        <h6 style="font-size: 14px;" class="text-dark"><b> Jumlah Hari : </b> <b>( {{$total_days}} Hari )</b> </h6>
                        <h6 style="font-size: 14px;" class="text-dark"> &nbsp;&nbsp;|&nbsp;&nbsp;</h6>
                        <h6 style="font-size: 14px;" class="text-dark"><b> Hari Kerja : </b> <b>( {{$total_working_days}} Hari )</b> </h6>
                    </div>
                    @endif
                </div>
                
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-6 col-md">
                            <div style="background-color: #FFDD7F" class="card rounded overflow-hidden">
                                <div class="d-flex align-items-center card-body">
                                    <div class="">
                                        <span class="font-weight-bold text-medium text-uppercase text-dark">Presensi Harian
                                        </span>
                                        <h5 class="text-dark font-weight-bolder mt-2">{{$total_hari_hadir}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div><!-- col-3 -->
                        <div class="col-sm-6 col-md">
                            <div style="background-color: #FFDD7F" class="card rounded overflow-hidden">
                                <div class="d-flex align-items-center card-body">
                                    <div class="">
                                        <span class="font-weight-bold text-medium text-uppercase text-dark">Presensi Lembur
                                        </span>
                                        <h5 class="text-dark font-weight-bolder mt-2">{{$total_hari_lembur}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div><!-- col-3 -->
                        <div class="col-sm-6 col-md">
                            <div style="background-color: #FFDD7F" class="card rounded overflow-hidden">
                                <div class="d-flex align-items-center card-body">
                                    <div class="">
                                        <span class="font-weight-bold text-medium text-uppercase text-dark">Izin
                                        </span>
                                        <h5 class="text-dark font-weight-bolder mt-2">{{$total_izin}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div><!-- col-3 -->
                        <div class="col-sm-6 col-md">
                            <div style="background-color: #FFDD7F" class="card rounded overflow-hidden">
                                <div class="d-flex align-items-center card-body">
                                    <div class="">
                                        <span class="font-weight-bold text-medium text-uppercase text-dark">Terlambat
                                        </span>
                                        <h5 class="text-dark font-weight-bolder mt-2">{{$total_telat}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div><!-- col-3 -->
                        <div class="col-sm-6 col-md">
                            <div style="background-color: #FFDD7F" class="card rounded overflow-hidden">
                                <div class="d-flex align-items-center card-body">
                                    <div class="">
                                        <span class="font-weight-bold text-medium text-uppercase text-dark">Tidak Hadir
                                        </span>
                                        <h5 class="text-dark font-weight-bolder mt-2">{{$total_alfa}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div><!-- col-3 -->
                    </div>
    
                    <div class="row mb-3">
                        <div class="col-sm-6 col-md">
                            <div style="background-color: #B0FFDB" class="card rounded overflow-hidden">
                                <div class="d-flex align-items-center card-body">
                                    <div class="">
                                        <span class="font-weight-bold text-medium text-uppercase text-dark">Total Jam Kerja <br> Presensi Harian
                                        </span>
                                        <h5 class="text-dark font-weight-bolder mt-2">{{$total_jam_kerja}}</h5>
                                        <span class="text-11 text-roboto text-dark">Jam : Menit : Detik</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- col-3 -->
                        <div class="col-sm-6 col-md">
                            <div style="background-color: #B0FFDB" class="card rounded overflow-hidden">
                                <div class="d-flex align-items-center card-body">
                                    <div class="">
                                        <span class="font-weight-bold text-medium text-uppercase text-dark">Total Jam Kerja <br> Lemburan
                                        </span>
                                        <h5 class="text-dark font-weight-bolder mt-2">{{$total_jam_lembur}}</h5>
                                        <span class="text-11 text-roboto text-dark">Jam : Menit : Detik</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- col-3 -->
                        <div class="col-sm-6 col-md">
                            <div style="background-color: #B0FFDB" class="card rounded overflow-hidden">
                                <div class="d-flex align-items-center card-body">
                                    <div class="">
                                        <span class="font-weight-bold text-medium text-uppercase text-dark">Total Jam <br> Keterlambatan Presensi Harian
                                        </span>
                                        <h5 class="text-dark font-weight-bolder mt-2">{{$total_jam_telat}}</h5>
                                        <span class="text-11 text-roboto text-dark">Jam : Menit : Detik</span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- col-3 -->
                    </div>
                    
                    <div class="overflow-auto tableFixHead">
                        <table id="" class="table table-bordered table-striped table-hover ">
                            <thead class="">
                                <tr>
                                    <th class="text-center bg-dark text-light pb-4" rowspan="2"> <span class="text-14 mb-5"> Hari Tanggal </span></th>
                                    <th class="text-center bg-primary text-white" colspan="2">Presensi Harian</th>
                                    @foreach ($jenis_lembur as $lembur)
                                        <th class="bg-info text-white text-center"  colspan="2">{{$lembur->type}}</th>
                                    @endforeach
                                </tr>
                                <tr>
                                    <th class="bg-success text-white text-center">IN</th>
                                    <th class="bg-danger text-white text-center">OUT</th>
                                    @foreach ($jenis_lembur as $lembur)
                                        <th class="bg-success text-white text-center">IN</th>
                                        <th class="bg-danger text-white text-center">OUT</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
    
                                @foreach ($dates as $date)
    
                                @if ($date['libur'] == true && $date['ket'] == null)
                                    @php
                                        $tr = 'libur-merah text-light';
                                        $libur_keterangan = '';
                                    @endphp
                                @elseif ($date['libur'] == true && $date['ket'] != null)
                                    @php
                                        $tr = 'bg-warning text-dark';
                                        $libur_keterangan = $date['ket'];
                                    @endphp
                                @elseif ($date['libur'] == false && $date['ket'] == null)
                                    @php
                                        $tr = 'bg-white text-dark';
                                        $libur_keterangan = null;
                                    @endphp
                                @endif
                                <tr>
                                    <td class="text-center {{$tr}}">
                                        <b> {{$date['date']}} </b> <br>
                                        {{$date['ket']}}
                                    </td>
                                    <td class="text-center {{$tr}}">
                                        <span class="{{$date['presensi']['harian']['late'] != '' ? 'text-danger':''}}" > {{$date['presensi']['harian']['in']}} </span>
                                        <br>
                                        <small class="{{$date['presensi']['harian']['late'] != '' ? 'text-danger':''}}" > {{$date['presensi']['harian']['late'] != '' ? 'Telat: '.\App\Helpers\General::convertSecondToStringTime($date['presensi']['harian']['late']) : ''}}</small>
                                    </td>
                                    <td class="text-center {{$tr}}">
                                        {{$date['presensi']['harian']['out']}}
                                    </td>
                                    @foreach ($jenis_lembur as $lembur)
                                            <td class="{{$tr}}">
                                                @if (!empty($date['presensi']['lembur'][$lembur->slug]))
                                                    @foreach ($date['presensi']['lembur'][$lembur->slug] as $key => $item)
                                                        {{$item['in'] }}
                                                        <br>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="{{$tr}}">
                                                @if (!empty($date['presensi']['lembur'][$lembur->slug]))
                                                    @foreach ($date['presensi']['lembur'][$lembur->slug] as $key => $item)
                                                        {{$item['out'] }}
                                                        <small>
                                                            @if ($item['date_out'] != $date['ymd'])
                                                            <i> {{ date('d-M-Y', strtotime($item['date_out'])) }} </i>
                                                            @endif
                                                        </small>
                                                        <br>
                                                    @endforeach
                                                @endif
                                            </td>
                                    @endforeach
                                    
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div><!-- bd -->
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('active-report')
active
@endpush

@push('menuOpen-report')
style="display: block;"
@endpush

@push('showSub-report')
show-sub
@endpush

@push('styles')
<style>
.libur-merah {
    background-color: #ff7474;
}
.tableFixHead { overflow: auto; height: 100vh; }
.tableFixHead thead  { position: sticky; top: 0; z-index: 1; }

Just common table stuff. Really.
table  { border-collapse: collapse; width: 100%; }
th, td { padding: 8px 16px; }
th     { background:#eee; }
</style>
@endpush

@push('scripts')
@endpush
