@extends('layouts.app_panel.app', $head)


@section('content')
<div class="section">
    <div class="section-header">
        <h1> {{$head['head_title_per_page'] ?? 'Title' }}</h1>
    </div>

    <div class="row">
        <div class="col">
            <div class="card card-statistic-2">
                <div class="card-stats">
                  <div class="card-stats-title"></div>
                  <div class="card-stats-items">
                    <div class="card-stats-item">
                      <div class="card-stats-item-count text-dark">{{$total_lembur}}</div>
                      <div class="card-stats-item-label"> <i style="font-size: 10px;" class="fas fa-user"></i>&nbsp; Lembur</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count text-success">{{$total_tepatwaktu}}</div>
                      <div class="card-stats-item-label"> <i style="font-size: 10px;" class="fas fa-user"></i>&nbsp; Harian Tepat Waktu</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count text-danger">{{$total_terlambat}}</div>
                      <div class="card-stats-item-label"> <i style="font-size: 10px;" class="fas fa-user"></i>&nbsp; Harian Telat</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count text-primary">{{$total_pulang_cepat}}</div>
                      <div class="card-stats-item-label"> <i style="font-size: 10px;" class="fas fa-user"></i>&nbsp; Harian Pulang Lebih Awal</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count text-warning">{{$total_belum_checkout}}</div>
                      <div class="card-stats-item-label"> <i style="font-size: 10px;" class="fas fa-user"></i>&nbsp; Harian/Lembur Belum Checkout</div>
                    </div>
                  </div>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                  </div>
                  <div class="card-body">
                  </div>
                </div>
            </div>
        </div>
    </div><!-- row -->

    <div class="row">
        <div class="col">
            <div class="widget-2">
                <div class="card shadow-base overflow-hidden">
                    <div class="card-body d-md-flex justify-content-between align-items-center">
                        <h6 class="" style="font-size: 14px;">
                            <span class="text-gray">Per Tanggal : <br> <b class="text-info"> {{ \App\Helpers\General::dateIndo($date) ?? $date_now}} </b></span>
                        </h6>
                        <form action="" method="get" class="d-block d-md-flex">
                            {{-- @csrf --}}
                            <div class="form-group mb-0 mr-1">
                                <select name="tipe" class="form-control form-control-sm" >
                                    <option value="" selected>-- Jenis Presensi --</option>
                                    <option value="absen_biasa">Presensi Harian</option>
                                    <option value="absen_lembur">Presensi Lembur</option>
                                </select>
                            </div>
                            <div class="form-group mb-0 mr-1">
                                <select name="keterangan" class="form-control form-control-sm" >
                                    <option value="" selected>-- keterangan --</option>
                                    <option value="terlambat">Terlambat</option>
                                    <option value="tepat_waktu">Tepat Waktu</option>
                                    <option value="pulang_cepat">Pulang Lebih Awal</option>
                                    <option value="belum_checkout">Belum Checkout (Harian/Lembur)</option>
                                </select>
                            </div>
                            <div class="form-group mb-0 mr-1">
                                <select name="employee_id" class="select2 form-control" >
                                    <option value="" selected disabled>-- Karyawan --</option>
                                    @if ($users)
                                    @foreach ($users as $j)
                                    <option value="{{$j->id}}">{{$j->full_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group d-flex align-items-center">
                                {{-- <input type="date" value="{{Carbon\Carbon::now()->toDateString()}}" name="date" class="form-control form-control-sm"> --}}
                                <input type="date" value="" name="date" class="form-control form-control-md">
                                &nbsp;
                                <button type="submit" class="btn btn-primary">
                                    Filter
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
                            <thead class="">
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
                                            @canany(['admin-log-presensi-show'])
                                            <a href="{{route('adm.absen.detail', $row->id)}}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> Detail</a>
                                            @endcanany

                                            @canany(['admin-log-presensi-checkout'])
                                            @if ($row->clock_out == null)
                                            <a href="#" title="Untuk mencheckout karyawan yang lupa checkout presensinya." class="btn btn-warning text-dark btn-sm" data-toggle="modal" data-target="#modaldemo{{$row->id}}">
                                                <div><i class="fa fa-sign-out "></i> Checkout</div> 
                                            </a>
                                            @endif
                                            @endcanany
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
   <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{route('adm.absen.checkout.manual')}}" method="post" class="submit_form">
                @csrf
                @method('PUT')
                <div class="modal-body pd-y-20 pd-x-20">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="d-flex align-items-center justify-content-start mg-b-20">
                        <i class="fa fa-sign-out text-40  text-warning lh-1 d-inline-block"></i>
                        <h4 class="text-warning font-weight-bold">Checkout Presensi</h4>
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
                            <td> <span class="text-18 mt-1 font-weight-bold text-dark">  {{ $row->clock_in != null ? date('H:i:s', strtotime($row->clock_in)) : '-'}} </span></td>
                        </tr>
                        <tr>
                            <th>Tanggal Keluar</th>
                            <td>:</td>
                            <td>
                                <input type="date" name="date_out" value="{{date('Y-m-d')}}" required class="form-control form-control-sm">
                            </td>
                        </tr>
                        <tr>
                            <th>Jam Keluar</th>
                            <td>:</td>
                            <td>
                                <input type="time" name="clock_out" value="" required class="form-control form-control-sm">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="form-group">
                                    <label for=""> Catatan </label>
                                    <textarea name="note" class="form-control form-control-sm" id="" cols="30" rows="3"></textarea>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div><!-- modal-body -->
                <div class="modal-footer text-center">
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
                    [10, 15, 30, 50, 100, 200, 300, -1],
                    [10, 15, 30, 50, 100, 200, 300, "Semua"]
                ],
                // iDisplayLength: -1,
                pageLength: 15,
                responsive: false,
                "ordering": true,
                language: {
                    searchPlaceholder: 'Cari data...',
                    sSearch: '',
                    lengthMenu: '_MENU_ Data yang ditampilkan',
                }
            });
    })

</script>

@endpush

