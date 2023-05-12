@extends('layouts.admin.app', $head)

@section('dynamic-content')
<div class="br-pagebody mg-t-0 pd-x-20 pd-b-200">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card shadow-base bd-0">
                <div class="card-header bg-transparent pd-x-10">
                  <h6 class="card-title tx-teal tx-uppercase tx-12 mg-b-0">Informasi Karyawan</h6>
                </div><!-- card-header -->
                <table class="table table-responsive mg-b-0 tx-12">
                <tbody>
                      <tr class="tx-12">
                        <th rowspan="2" class="pd-y-5">
                          @if ($user->photo_profile)
                          <img width="100" class="wd-75 rounded-circle" src="{{ asset('uploads/images/employee/'. $user->photo_profile) }}">
                          @else
                          <img width="100" class="wd-75 rounded-circle" src="{{ asset('images/default-ava.jpg') }}"> 
                          @endif
                        </th>
                        <th class="pd-y-5">Nama Lengkap</th>
                        <th class="pd-y-5">Jenis Kelamin</th>
                        <th class="pd-y-5">Email</th>
                        <th class="pd-y-5">NIK</th>
                        <th class="pd-y-5">NIP</th>
                        <th class="pd-y-5">Tipe</th>
                        <th class="pd-y-5">Status</th>
                        <th class="pd-y-5">Jabatan</th>
                        <th class="pd-y-5">Pendidikan</th>
                        <th class="pd-y-5">Tanggal Masuk</th>
                        <th class="pd-y-5">Masa Kerja</th>
                      </tr>
                    <tr>
                      {{-- <td rowspan="2" class="pd-l-20">
                        
                      </td> --}}
                      <td>
                        <span class="tx-14 tx-inverse d-block">{{$user->full_name ?? '-'}}</span>
                      </td>
                      <td>
                        @php 
                            $gender = '-';
                            if($user->gender == 'L') {
                                $gender = 'Laki -Laki';
                            }else {
                                $gender = 'Perempuan';
                            }
                        @endphp
                        <span class="tx-11 d-block">
                            {{$gender}}
                        </span>
                      </td>
                      <td>
                        <span class="tx-11 d-block">{{$user->email ?? '-'}}</span>
                      </td>
                      <td>
                        <span class="tx-11 d-block">{{$user->nik ?? '-'}}</span>
                      </td>
                      <td>
                        <span class="tx-11 d-block">{{$user->nip ?? '-'}}</span>
                      </td>
                      <td>
                        <span class="tx-11 d-block">{{$user->type == 'staff' ? 'Staff' : 'Non Staff'}}</span>
                      </td>
                      <td>
                          <span class="tx-11 d-block">{{$user->status}}</span>
                        </td>
                        <td>
                            <span class="tx-11 d-block">{{$user->jabatan->type ?? "-"}}</span>
                        </td>
                        <td>
                            <span class="tx-11 d-block">{{$user->education->education ?? "-"}}</span>
                        </td>
                        <td>
                            <span class="tx-11 d-block">{{date('d-M-Y', strtotime($user->tanggal_masuk ?? '0000-00-00'))}}</span>
                        </td>
                        <td>
                            <span class="tx-11 d-block">
                                @php
                                $startDate = \Carbon\Carbon::parse($user->tanggal_masuk);
                                if($user->is_active == 1) {
                                    $endDate = \Carbon\Carbon::now();
                                } else {
                                    $endDate = \Carbon\Carbon::parse($user->tanggal_keluar);
                                }
                                $duration = $endDate->diff($startDate);
                                echo $duration->format('%y tahun %m bulan')
                                @endphp
                            </span>
                        </td>
                        
                    </tr>
                    
                  </tbody>
                </table>
                
              </div>
        </div>
        <div class="col-12">
            <div class="br-section-wrapper pd-15">
                <div class="d-block d-md-flex align-item-center justify-content-between mb-3">
                    <div class="d-flex align-items-center ">
                        <h6 class="card-title tx-teal tx-uppercase tx-12 mg-b-0">Riwayat Presensi</h6>
                    </div>
                    <div>
                        <a target="_blank" href="{{route('adm.report.export.detail', ['data' => 'excel', 'karyawan' => request()->query('karyawan'), 'from' => request()->query('from_date'), 'to' => request()->query('to_date')])}}" class="btn btn-sm btn-success">
                            <i class="fa fa-download"></i>
                            Ekspor Excel
                        </a>
                        <a target="_blank" href="{{route('adm.report.export.detail', ['data' => 'pdf', 'karyawan' => request()->query('karyawan'), 'from' => request()->query('from_date'), 'to' => request()->query('to_date')])}}" class="btn btn-sm btn-danger ml-2">
                            <i class="fa fa-download"></i>
                            Ekspor PDF
                        </a>
                    </div>
                </div>
                <hr>
                
                <div class="d-flex align-items-center my-3">
                    @if (request()->query('from_date') != '' || request()->query('to_date') != '')
                    <h6 class="tx-13 text-dark"> 
                        <b> Periode :  </b>
                        <b class="text-info">
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d', request()->query('from_date'))->isoFormat('D MMMM Y'); }} 
                        </b>
                        &nbsp;
                        -
                        &nbsp;
                        <b class="text-info">
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d', request()->query('to_date'))->isoFormat('D MMMM Y'); }}
                        </b>
                    </h6>

                    <h6 class="tx-13 text-dark"> &nbsp;&nbsp;|&nbsp;&nbsp;</h6>
                    <h6 class="tx-13 text-dark"><b> Jumlah Hari : </b> <b>( {{$total_days}} Hari )</b> </h6>
                    <h6 class="tx-13 text-dark"> &nbsp;&nbsp;|&nbsp;&nbsp;</h6>
                    <h6 class="tx-13 text-dark"><b> Hari Kerja : </b> <b>( {{$total_working_days}} Hari )</b> </h6>
                    @endif
                </div>

                <div class="row row-sm mb-3">
                    <div class="col-sm-6 col-md">
                        <div style="background-color: #FFDD7F" class=" rounded overflow-hidden">
                            <div class="pd-10 d-flex align-items-center">
                                <div class="mg-l-20">
                                    <p class="tx-12 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-dark mg-b-5">Hadir
                                    </p>
                                    <p class="tx-20 tx-dark tx-lato tx-bold mg-b-2 lh-1">{{$total_hari_hadir}}</p>
                                    <span class="tx-11 tx-roboto tx-dark">Kali</span>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-sm-6 col-md">
                        <div style="background-color: #FFDD7F" class=" rounded overflow-hidden">
                            <div class="pd-10 d-flex align-items-center">
                                <div class="mg-l-20">
                                    <p class="tx-12 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-dark mg-b-5">Lembur
                                    </p>
                                    <p class="tx-20 tx-dark tx-lato tx-bold mg-b-2 lh-1">{{$total_hari_lembur}}</p>
                                    <span class="tx-11 tx-roboto tx-dark">Kali</span>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-sm-6 col-md">
                        <div style="background-color: #FFDD7F" class=" rounded overflow-hidden">
                            <div class="pd-10 d-flex align-items-center">
                                <div class="mg-l-20">
                                    <p class="tx-12 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-dark mg-b-5">Izin
                                    </p>
                                    <p class="tx-20 tx-dark tx-lato tx-bold mg-b-2 lh-1">{{$total_izin}}</p>
                                    <span class="tx-11 tx-roboto tx-dark">Kali</span>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-sm-6 col-md">
                        <div style="background-color: #FFDD7F" class=" rounded overflow-hidden">
                            <div class="pd-10 d-flex align-items-center">
                                <div class="mg-l-20">
                                    <p class="tx-12 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-dark mg-b-5">Terlambat
                                    </p>
                                    <p class="tx-20 tx-dark tx-lato tx-bold mg-b-2 lh-1">{{$total_telat}}</p>
                                    <span class="tx-11 tx-roboto tx-dark">Kali</span>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-sm-6 col-md">
                        <div style="background-color: #FFDD7F" class=" rounded overflow-hidden">
                            <div class="pd-10 d-flex align-items-center">
                                <div class="mg-l-20">
                                    <p class="tx-12 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-dark mg-b-5">Tidak Hadir
                                    </p>
                                    <p class="tx-20 tx-dark tx-lato tx-bold mg-b-2 lh-1">{{$total_alfa}}</p>
                                    <span class="tx-11 tx-roboto tx-dark">Kali</span>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-3 -->
                </div>

                <div class="row row-sm mb-3">
                    <div class="col-sm-6 col-md">
                        <div style="background-color: #B0FFDB" class=" rounded overflow-hidden">
                            <div class="pd-10 d-flex align-items-center">
                                <div class="mg-l-20">
                                    <p class="tx-12 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-dark mg-b-5">Total Jam Kerja Harian
                                    </p>
                                    <p class="tx-20 tx-dark tx-lato tx-bold mg-b-2 lh-1">{{$total_jam_kerja}}</p>
                                    <span class="tx-11 tx-roboto tx-dark">Jam : Menit : Detik</span>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-sm-6 col-md">
                        <div style="background-color: #B0FFDB" class=" rounded overflow-hidden">
                            <div class="pd-10 d-flex align-items-center">
                                <div class="mg-l-20">
                                    <p class="tx-12 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-dark mg-b-5">Total Jam Kerja Lemburan
                                    </p>
                                    <p class="tx-20 tx-dark tx-lato tx-bold mg-b-2 lh-1">{{$total_jam_lembur}}</p>
                                    <span class="tx-11 tx-roboto tx-dark">Jam : Menit : Detik</span>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-sm-6 col-md">
                        <div style="background-color: #B0FFDB" class=" rounded overflow-hidden">
                            <div class="pd-10 d-flex align-items-center">
                                <div class="mg-l-20">
                                    <p class="tx-12 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-dark mg-b-5">Total Jam Keterlambatan Presensi Harian
                                    </p>
                                    <p class="tx-20 tx-dark tx-lato tx-bold mg-b-2 lh-1">{{$total_jam_telat}}</p>
                                    <span class="tx-11 tx-roboto tx-dark">Jam : Menit : Detik</span>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-3 -->
                </div>
                
                <div class="bd rounded table-responsive p-0 overflow-auto tableFixHead">
                    <table id="" class="table table-bordered table-striped table-hover mg-b-0">
                        <thead class="">
                            <tr>
                                <th class="tx-center bg-dark text-light pb-4" rowspan="2"> <span class="tx-14 mb-5"> Hari Tanggal </span></th>
                                <th class="tx-center" style="background-color: rgb(219, 246, 254);" colspan="2">Presensi Harian</th>
                                <th class="tx-center" style="background-color: rgb(202, 244, 255);" colspan="2">Lembur Workshop</th>
                                <th class="tx-center" style="background-color: rgb(184, 233, 254);" colspan="2">Operan Malam</th>
                                <th class="tx-center" style="background-color: rgb(166, 228, 255);" colspan="2">Operan Pagi</th>
                            </tr>
                            <tr>
                                {{-- <th class="bg-dark"></th> --}}
                                <th class="bg-success text-white tx-center">IN</th>
                                <th class="bg-primary text-white tx-center">OUT</th>
                                <th class="bg-success text-white tx-center">IN</th>
                                <th class="bg-primary text-white tx-center">OUT</th>
                                <th class="bg-success text-white tx-center">IN</th>
                                <th class="bg-primary text-white tx-center">OUT</th>
                                <th class="bg-success text-white tx-center">IN</th>
                                <th class="bg-primary text-white tx-center">OUT</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($dates as $date)

                            @if ($date['libur'] == true && $date['ket'] == null)
                                @php
                                    $tr = 'bg-danger text-light';
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
                                <td class="text-center">
                                    <span class="{{$date['presensi']['harian']['late'] != '' ? 'text-danger':''}}" > {{$date['presensi']['harian']['in']}} </span>
                                    <br>
                                    <small class="{{$date['presensi']['harian']['late'] != '' ? 'text-danger':''}}" > {{$date['presensi']['harian']['late'] != '' ? 'Telat: '.\App\Helpers\General::convertSecondToStringTime($date['presensi']['harian']['late']) : ''}}</small>
                                </td>
                                <td class="text-center">
                                    {{$date['presensi']['harian']['out']}}
                                </td>
                                <td class="text-center">
                                    {{$date['presensi']['lembur_workshop']['in']}}
                                </td>
                                <td class="text-center">
                                    {{$date['presensi']['lembur_workshop']['out']}}
                                    <br>
                                    <small class="{{$date['presensi']['lembur_workshop']['date_out'] != null ? 'text-info':''}}" > {{$date['presensi']['lembur_workshop']['date_out'] != null ? 'Tgl Check-out: '.\Carbon\Carbon::parse($date['presensi']['lembur_workshop']['date_out'])->format('d-M-Y') : ''}}</small>
                                </td>
                                <td class="text-center">
                                    {{$date['presensi']['operan_malam']['in']}}
                                </td>
                                <td class="text-center">
                                    {{$date['presensi']['operan_malam']['out']}}
                                    <br>
                                    <small class="{{$date['presensi']['operan_malam']['date_out'] != null ? 'text-info':''}}" > {{$date['presensi']['operan_malam']['date_out'] != null ? 'Tgl Check-out: '.\Carbon\Carbon::parse($date['presensi']['operan_malam']['date_out'])->format('d-M-Y') : ''}}</small>
                                </td>
                                <td class="text-center">
                                    {{$date['presensi']['operan_pagi']['in']}}
                                </td>
                                <td class="text-center">
                                    {{$date['presensi']['operan_pagi']['out']}}
                                    <br>
                                    <small class="{{$date['presensi']['operan_pagi']['date_out'] != null ? 'text-info':''}}" > {{$date['presensi']['operan_pagi']['date_out'] != null ? 'Tgl Check-out: '.\Carbon\Carbon::parse($date['presensi']['operan_pagi']['date_out'])->format('d-M-Y') : ''}}</small>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div><!-- bd -->
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
