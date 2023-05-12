@extends('layouts.app_panel.app', $head)

@section('content')
<div class="br-pagebody mg-t-0 pd-x-20 pd-b-200">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card shadow-base bd-0">
                <div class="card-header bg-transparent pd-x-10">
                  <h6 class="card-title text-info text-uppercase text-12 mg-b-0">Informasi Karyawan</h6>
                </div><!-- card-header -->
                <table class="table table-responsive mg-b-0 text-12">
                <tbody>
                      <tr class="text-12">
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
                        <span class="text-14 text-inverse d-block">{{$user->full_name ?? '-'}}</span>
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
                        <span class="text-11 d-block">
                            {{$gender}}
                        </span>
                      </td>
                      <td>
                        <span class="text-11 d-block">{{$user->email ?? '-'}}</span>
                      </td>
                      <td>
                        <span class="text-11 d-block">{{$user->nik ?? '-'}}</span>
                      </td>
                      <td>
                        <span class="text-11 d-block">{{$user->nip ?? '-'}}</span>
                      </td>
                      <td>
                        <span class="text-11 d-block">{{$user->type == 'staff' ? 'Staff' : 'Non Staff'}}</span>
                      </td>
                      <td>
                          <span class="text-11 d-block">{{$user->status}}</span>
                        </td>
                        <td>
                            <span class="text-11 d-block">{{$user->jabatan->type ?? "-"}}</span>
                        </td>
                        <td>
                            <span class="text-11 d-block">{{$user->education->education ?? "-"}}</span>
                        </td>
                        <td>
                            <span class="text-11 d-block">{{date('d-M-Y', strtotime($user->tanggal_masuk ?? '0000-00-00'))}}</span>
                        </td>
                        <td>
                            <span class="text-11 d-block">
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
                        <h6 class="card-title text-info text-uppercase text-12 mg-b-0">Riwayat Presensi</h6>
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
                    <h6 class="text-13 text-dark"> 
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

                    <h6 class="text-13 text-dark"> &nbsp;&nbsp;|&nbsp;&nbsp;</h6>
                    <h6 class="text-13 text-dark"><b> Jumlah Hari : </b> <b>( {{$total_days}} Hari )</b> </h6>
                    <h6 class="text-13 text-dark"> &nbsp;&nbsp;|&nbsp;&nbsp;</h6>
                    <h6 class="text-13 text-dark"><b> Hari Kerja : </b> <b>( {{$total_working_days}} Hari )</b> </h6>
                    @endif
                </div>

                <div class="row row-sm mb-3">
                    <div class="col-sm-6 col-md">
                        <div style="background-color: #FFDD7F" class=" rounded overflow-hidden">
                            <div class="pd-10 d-flex align-items-center">
                                <div class="mg-l-20">
                                    <p class="text-12 text-spacing-1 text-mont text-medium text-uppercase text-dark mg-b-5">Presensi Harian
                                    </p>
                                    <p class="text-20 text-dark text-lato text-bold mg-b-2 lh-1">{{$total_hari_hadir}}</p>
                                    <span class="text-11 text-roboto text-dark">Kali</span>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-sm-6 col-md">
                        <div style="background-color: #FFDD7F" class=" rounded overflow-hidden">
                            <div class="pd-10 d-flex align-items-center">
                                <div class="mg-l-20">
                                    <p class="text-12 text-spacing-1 text-mont text-medium text-uppercase text-dark mg-b-5">Presensi Lembur
                                    </p>
                                    <p class="text-20 text-dark text-lato text-bold mg-b-2 lh-1">{{$total_hari_lembur}}</p>
                                    <span class="text-11 text-roboto text-dark">Kali</span>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-sm-6 col-md">
                        <div style="background-color: #FFDD7F" class=" rounded overflow-hidden">
                            <div class="pd-10 d-flex align-items-center">
                                <div class="mg-l-20">
                                    <p class="text-12 text-spacing-1 text-mont text-medium text-uppercase text-dark mg-b-5">Izin
                                    </p>
                                    <p class="text-20 text-dark text-lato text-bold mg-b-2 lh-1">{{$total_izin}}</p>
                                    <span class="text-11 text-roboto text-dark">Kali</span>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-sm-6 col-md">
                        <div style="background-color: #FFDD7F" class=" rounded overflow-hidden">
                            <div class="pd-10 d-flex align-items-center">
                                <div class="mg-l-20">
                                    <p class="text-12 text-spacing-1 text-mont text-medium text-uppercase text-dark mg-b-5">Terlambat <br> (Presensi Harian)
                                    </p>
                                    <p class="text-20 text-dark text-lato text-bold mg-b-2 lh-1">{{$total_telat}}</p>
                                    <span class="text-11 text-roboto text-dark">Kali</span>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-sm-6 col-md">
                        <div style="background-color: #FFDD7F" class=" rounded overflow-hidden">
                            <div class="pd-10 d-flex align-items-center">
                                <div class="mg-l-20">
                                    <p class="text-12 text-spacing-1 text-mont text-medium text-uppercase text-dark mg-b-5">Tidak Hadir <br> (Presensi Harian)
                                    </p>
                                    <p class="text-20 text-dark text-lato text-bold mg-b-2 lh-1">{{$total_alfa}}</p>
                                    <span class="text-11 text-roboto text-dark">Kali</span>
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
                                    <p class="text-12 text-spacing-1 text-mont text-medium text-uppercase text-dark mg-b-5">Total Jam Kerja <br> Presensi Harian
                                    </p>
                                    <p class="text-20 text-dark text-lato text-bold mg-b-2 lh-1">{{$total_jam_kerja}}</p>
                                    <span class="text-11 text-roboto text-dark">Jam : Menit : Detik</span>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-sm-6 col-md">
                        <div style="background-color: #B0FFDB" class=" rounded overflow-hidden">
                            <div class="pd-10 d-flex align-items-center">
                                <div class="mg-l-20">
                                    <p class="text-12 text-spacing-1 text-mont text-medium text-uppercase text-dark mg-b-5">Total Jam Kerja <br> Lemburan
                                    </p>
                                    <p class="text-20 text-dark text-lato text-bold mg-b-2 lh-1">{{$total_jam_lembur}}</p>
                                    <span class="text-11 text-roboto text-dark">Jam : Menit : Detik</span>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-sm-6 col-md">
                        <div style="background-color: #B0FFDB" class=" rounded overflow-hidden">
                            <div class="pd-10 d-flex align-items-center">
                                <div class="mg-l-20">
                                    <p class="text-12 text-spacing-1 text-mont text-medium text-uppercase text-dark mg-b-5">Total Jam <br> Keterlambatan Presensi Harian
                                    </p>
                                    <p class="text-20 text-dark text-lato text-bold mg-b-2 lh-1">{{$total_jam_telat}}</p>
                                    <span class="text-11 text-roboto text-dark">Jam : Menit : Detik</span>
                                </div>
                            </div>
                        </div>
                    </div><!-- col-3 -->
                </div>
                
                <div class="bd rounded table-responsive p-0 overflow-auto tableFixHead">
                    <table id="" class="table table-bordered table-striped table-hover mg-b-0">
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
