@extends('layouts.admin.app', $head)


@section('dynamic-content')
<div class="br-pagebody mg-t-5 pd-x-20 pd-b-200">
    <div class="row row-sm mb-3">
        <div class="col-sm-6 col-md col-lg">
            <div class="bg-dark rounded overflow-hidden">
                <div class="pd-10 d-flex align-items-center">
                    <i class="ion ion-person-stalker tx-30 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-5">Presensi Lembur
                        </p>
                        <p class="tx-18 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_lembur}}</p>
                        <span class="tx-11 tx-roboto tx-white-6">Karyawan</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-md col-lg">
            <div class="bg-success rounded overflow-hidden">
                <div class="pd-10 d-flex align-items-center">
                    <i class="ion ion-person-stalker tx-30 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-5">Presensi Harian Tepat Waktu</p>
                        <p class="tx-18 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_tepatwaktu}}</p>
                        <span class="tx-11 tx-roboto tx-white-6">Karyawan</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-md col-lg">
            <div class="bg-primary rounded overflow-hidden">
                <div class="pd-10 d-flex align-items-center">
                    <i class="ion ion-person-stalker tx-30 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-5">Presensi Harian Pulang Lebih Awal</p>
                        <p class="tx-18 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_pulang_cepat}}</p>
                        <span class="tx-11 tx-roboto tx-white-6">Karyawan</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-md col-lg">
            <div class="bg-danger rounded overflow-hidden">
                <div class="pd-10 d-flex align-items-center">
                    <i class="ion ion-person-stalker tx-30 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-5">Presensi Harian Terlambat 
                        </p>
                        <p class="tx-18 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_terlambat}}</p>
                        <span class="tx-11 tx-roboto tx-white-6">Karyawan</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-md col-lg">
            <div class="bg-warning rounded overflow-hidden">
                <div class="pd-10 d-flex align-items-center">
                    <i class="ion ion-person-stalker tx-30 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-5">Belum Checkout Harian/Lembur 
                        </p>
                        <p class="tx-18 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_belum_checkout}}</p>
                        <span class="tx-11 tx-roboto tx-white-6">Presensi</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        
    </div><!-- row -->

    <div class="row">
        <div class="col">
            <div class="widget-2">
                <div class="card shadow-base overflow-hidden">
                    <div class="card-header">
                        <h6 class="card-title">
                            <span class="tx-gray">Per Tanggal : <br> <b class="tx-info"> {{ \App\Helpers\General::dateIndo($date) ?? $date_now}} </b></span>
                        </h6>
                        <form action="" method="get" class="d-block d-md-flex">
                            {{-- @csrf --}}
                            <div class="form-group mb-0 mr-1">
                                <select name="tipe" class="form-control" >
                                    <option value="" selected>-- Jenis Presensi --</option>
                                    <option value="absen_biasa">Presensi Harian</option>
                                    <option value="absen_lembur">Presensi Lembur</option>
                                </select>
                            </div>
                            <div class="form-group mb-0 mr-1">
                                <select name="keterangan" class="form-control" >
                                    <option value="" selected>-- keterangan --</option>
                                    <option value="terlambat">Terlambat</option>
                                    <option value="tepat_waktu">Tepat Waktu</option>
                                    <option value="pulang_cepat">Pulang Lebih Awal</option>
                                    <option value="belum_checkout">Belum Checkout (Harian/Lembur)</option>
                                </select>
                            </div>
                            <div class="form-group mb-0 mr-1">
                                <select name="employee_id" class="selecttu form-control" >
                                    <option value="" selected disabled>-- Karyawan --</option>
                                    @if ($users)
                                    @foreach ($users as $j)
                                    <option value="{{$j->id}}">{{$j->full_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group d-flex align-items-center">
                                {{-- <input type="date" value="{{Carbon\Carbon::now()->toDateString()}}" name="date" class="form-control form-sm"> --}}
                                <input type="date" value="" name="date" class="form-control form-sm">
                                &nbsp;
                                <button type="submit" class="btn btn-teal btn-with-icon">
                                    <div class="ht-40">
                                        <span class="pd-x-20">Filter</span>
                                        {{-- <span class="icon wd-40"><i class="fa fa-search"></i></span> --}}
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div><!-- card-header -->
                    <div class="card-body pd-15 bd-color-gray-lighter table-responsive overflow-auto">
                        @if (request()->query('tipe') || request()->query('employee_id') || request()->query('keterangan') )
                        <p class="mb-4">
                            <b>Filter By : </b>
                            
                            @if (request()->query('tipe') === 'absen_biasa')
                                Presensi Harian
                            @elseif (request()->query('tipe') === 'absen_lembur')
                                Presensi Lembur
                            @elseif (request()->query('tipe') === 'undefine')
                                Undefine
                            @endif

                            @if (request()->query('employee_id'))
                                {{$employee_name}}, 
                            @endif
                            @if (request()->query('keterangan'))
                                @if (request()->query('keterangan') == 'pulang_cepat')
                                    Pulang Lebih Awal, 
                                @elseif (request()->query('keterangan') == 'tepat_waktu')
                                    Tepat Waktu, 
                                @elseif (request()->query('keterangan') == 'terlambat')
                                    Terlambat, 
                                @elseif (request()->query('keterangan') == 'belum_checkout')
                                    Belum Checkout (Harian/Lembur) 
                                @endif
                            @endif
                            
                            <a href="{{route('adm.absen')}}" class="ml-2 text-danger"><small>&times; Reset Filter</small> </a>
                        </p>
                        @endif
                        
                        <table id="customDatatble" class="table display nowrap">
                            <thead class="table-info">
                                <tr>
                                    <th class="wd-5p">#</th>
                                    <th class="">Karyawan</th>
                                    <th class="">Jenis</th>
                                    <th class="">Tanggal Masuk</th>
                                    <th class="">Check In</th>
                                    <th class="">Tanggal Pulang</th>
                                    <th class="">Check Out</th>
                                    <th class="">Terlambat</th>
                                    <th class="">Total Jam Kerja</th>
                                    <th class="wd-5p">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=1;
                                @endphp
                                @foreach ($data as $row)

                                @if($row->type == 'absen_biasa' || $row->type == 'absen_lembur')
                                    <tr>
                                        <td>{{$i++}}.</td>
                                        <td>
                                            @if ($row->karyawan->photo_profile)
                                            <img width="32" src="{{ asset('uploads/images/employee/'. $row->karyawan->photo_profile) }}">
                                            @else
                                            <img width="32" src="{{ asset('images/default-ava.jpg') }}"> 
                                            @endif
                                            {{$row->karyawan->full_name}}
                                        </td>
                                        <td>
                                            @if ($row->type == 'absen_lembur')
                                                <span class="badge badge-dark">Presensi Lembur</span><br>
                                                <span class="badge badge-light">{{$row->jenisLembur->type ?? ''}}</span>
                                                @php
                                                    // $total_kerja = $row->overtime != null ? \Carbon\Carbon::createFromTimestampUTC($row->overtime)->format('H:i:s') : '-';
                                                    $total_kerja = $row->overtime != null ? \App\Helpers\General::convertSecondToStringTime($row->overtime) : '-';
                                                @endphp
                                            @elseif ($row->type == 'absen_biasa')
                                                <span class="badge badge-info">Presensi Harian</span>
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
                                            <span class="tx-18 mt-1 font-weight-bold {{$row->late != null ? 'tx-danger':'text-dark'}}">  {{ $row->clock_in != null ? date('H:i:s', strtotime($row->clock_in)) : '-'}} </span>

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
                                            <span class="tx-18 mt-1 font-weight-bold text-dark">  {{ $row->clock_out != null ? date('H:i:s', strtotime($row->clock_out)) : '-'}} </span>
                                        </td>
                                        <td> <span class="{{$row->late != null ? 'tx-danger':''}}"> {{ $row->late != null ?  \App\Helpers\General::convertSecondToStringTime($row->late) : '-'}} </span></td>
                                        <td>{{ $total_kerja ?? '-'}}</td>
                                        <td>
                                            <a href="{{route('adm.absen.detail', $row->id)}}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> Detail</a>
                                            @if ($row->clock_out == null)
                                            <a href="#" title="Untuk mencheckout karyawan yang lupa checkout presensinya." class="btn btn-warning tx-dark btn-sm" data-toggle="modal" data-target="#modaldemo{{$row->id}}">
                                                <div><i class="fa fa-sign-out "></i> Checkout</div> 
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- card-body -->
                </div>
            </div>
        </div>
    </div>

</div>


<!-- MODAL ALERT MESSAGE DELETE -->
@foreach ($data as $row)
<div id="modaldemo{{$row->id}}" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
            <form action="{{route('adm.absen.checkout.manual')}}" method="post" class="submit_form">
                @csrf
                @method('PUT')
                <div class="modal-body pd-y-20 pd-x-20">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="d-flex align-items-center justify-content-start mg-b-20">
                        <i class="fa fa-sign-out tx-40  tx-warning lh-1 d-inline-block"></i>
                        <h4 class="tx-warning tx-semibold">Checkout Presensi</h4>
                    </div>
    
                    <p class="text-info">Fitur ini hanya untuk karyawan yang lupa melakukan presensi cehckout.</p>
                    <p class="">Lakukan checkout jika karyawan tidak dapat melakukan presensi (harian/lembur) dikarenakan belum checkout presensi (harian/lembur) sebelumnya.</p>
    
                    <table class="table table-striped table-borderless mt-4">
                        <tr>
                            <th>Nama Karyawan</th>
                            <td>:</td>
                            <td>{{$row->karyawan->full_name}}</td>
                        </tr>
                        <tr>
                            <th>Jenis Presensi</th>
                            <td>:</td>
                            <td>
                                @if ($row->type == 'absen_lembur')
                                    <span class="badge badge-dark">Presensi Lembur</span><br>
                                    <span class="badge badge-light">{{$row->jenisLembur->type ?? ''}}</span>
                                    @php
                                        $total_kerja = $row->overtime != null ? \Carbon\Carbon::createFromTimestampUTC($row->overtime)->format('H:i:s') : '-';
                                    @endphp
                                @elseif ($row->type == 'absen_biasa')
                                    <span class="badge badge-info">Presensi Harian</span>
                                    @php
                                        $total_kerja = $row->total_work != null ? \Carbon\Carbon::createFromTimestampUTC($row->total_work)->format('H:i:s') : '-';
                                    @endphp
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Masuk</th>
                            <td>:</td>
                            <td>{{ date('d-M-Y', strtotime($row->date))}}</td>
                        </tr>
                        <tr>
                            <th>Jam Masuk</th>
                            <td>:</td>
                            <td> <span class="tx-18 mt-1 font-weight-bold text-dark">  {{ $row->clock_in != null ? date('H:i:s', strtotime($row->clock_in)) : '-'}} </span></td>
                        </tr>
                        <tr>
                            <th>Tanggal Keluar</th>
                            <td>:</td>
                            <td>
                                <input type="date" name="date_out" value="{{date('Y-m-d')}}" required class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th>Jam Keluar</th>
                            <td>:</td>
                            <td>
                                <input type="time" name="clock_out" value="" required class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="form-group">
                                    <label for=""> Catatan </label>
                                    <textarea name="note" class="form-control" id="" cols="30" rows="3"></textarea>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div><!-- modal-body -->
                <div class="modal-footer tx-center">
                    <input type="hidden" name="id" value="{{$row->id}}">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-sm btn-success">
                        Checkout Presensi
                    </button>
                </div>
            </form>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
@endforeach


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

<script>
    $(document).ready(function(){
        $("input[name=datetime_checkout_system]").toggle(function(event){
            $("input[name=date_out]").val('');
            $("input[name=clock_out]").val('');
        });
        var dataTable = $('#customDatatble').DataTable({
                // responsive: true,
                aLengthMenu: [
                    [10, 30, 50, 100, 200, 300, -1],
                    [10, 30, 50, 100, 200, 300, "Semua"]
                ],
                iDisplayLength: -1,
                responsive: false,
                "ordering": false,
                language: {
                    sSearch: '',
                    lengthMenu: '_MENU_ Data yang ditampilkan',
                }
            });
    })

</script>

@endpush



{{-- <table id="datatable1" class="table display nowrap">
    <thead class="">
        <tr>
            <th class="wd-5p">#</th>
            <th class="">Foto</th>
            <th class="">Nama Karyawan</th>
            <th class="">Jenis Presensi</th>
            <th class="">Device</th>
            <th class="">Shift</th>
            <th class="">Tanggal</th>
            <th class="">Jam Masuk</th>
            <th class="">Lokasi Masuk</th>
            <th class="">Foto Masuk</th>
            <th class="">Jam Pulang</th>
            <th class="">Lokasi Pulang</th>
            <th class="">Foto Pulang</th>
            <th class="">Total Waktu Kerja</th>
            <th class="">Total Waktu Terlambat</th>
            <th class="wd-5p">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php
        $i=1;
        @endphp
        @foreach ($data as $row)

        @if($row->type == 'absen_biasa' || $row->type == 'absen_lembur')
            <tr>
                <td>{{$i++}}.</td>
                <td>
                    @if ($row->karyawan->photo_profile)
                    <img width="32" src="{{ asset('uploads/images/employee/'. $row->karyawan->photo_profile) }}">
                    @else
                    <img width="32" src="{{ asset('images/default-ava.jpg') }}"> 
                    @endif
                </td>
                <td>{{$row->karyawan->full_name}}</td>
                <td>
                    @if ($row->type == 'absen_lembur')
                        <span class="badge badge-info">Lembur</span>
                        @php
                            $total_kerja = $row->overtime != null ? \Carbon\Carbon::createFromTimestampUTC($row->overtime)->format('H:i:s') : '-';
                        @endphp
                    @elseif ($row->type == 'absen_biasa')
                        <span class="badge badge-info">Harian</span>
                        @php
                            $total_kerja = $row->total_work != null ? \Carbon\Carbon::createFromTimestampUTC($row->total_work)->format('H:i:s') : '-';
                        @endphp
                    @else
                        -
                    @endif
                </td>
                <td>{{$row->device ?? "-"}}</td>
                <td>{{$row->karyawan->shifft->shift_name ?? "-"}}</td>
                <td>{{ date('d-M-Y', strtotime($row->date))}}</td>
                <td>{{ $row->clock_in != null ? date('H:i:s', strtotime($row->clock_in)) : '-'}}</td>
                <td>{{$row->latlong_in ?? '-'}}</td>
                <td>
                    @if ($row->foto_masuk != null)
                    <img width="32" src="{{ asset('uploads/images/attendance/'.$row->foto_masuk) }}">
                    @else
                    -
                    @endif
                </td>
                <td>@if ($row->is_auto_checkout_daily == 1) <i class="text-warning fa fa-sign-out"></i> @endif {{ $row->clock_out != null ? date('H:i:s', strtotime($row->clock_out)) : '-'}}</td>
                <td>{{$row->latlong_out ?? '-'}}</td>
                <td>
                    @if ($row->foto_keluar != null)
                    <img width="32" src="{{ asset('uploads/images/attendance/'.$row->foto_keluar) }}">
                    @else
                    -
                    @endif
                </td>
                <td>{{ $total_kerja ?? '-'}}</td>
                <td>{{ $row->late != null ? \Carbon\Carbon::createFromTimestampUTC($row->late)->format('H:i:s') : '-'}}</td>
                <td>
                    <a href="{{route('adm.absen.detail', $row->id)}}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> Detail</a>
                </td>
            </tr>
        @endif
        @endforeach
    </tbody>
</table> --}}
