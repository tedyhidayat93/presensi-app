@extends('layouts.admin.app', $head)


@section('dynamic-content')
<div class="br-pagebody mg-t-0 pd-x-20 pd-b-200">

    <div class="row">
        <div class="col-12 mt-3">
            <div class="card shadow-base">
                
                @include('pages.admin.reporting.form')
            </div>
        </div>
    </div>

    @if ( request()->query('type') != '' || request()->query('from') != '' || request()->query('to') != '' )
    <div class="row mt-3">
        <div class="col-12">
            <div class="br-section-wrapper pd-15">
                <div class="d-block d-md-flex align-item-center justify-content-between mb-3">
                    <div>
                        <h4 class="text-dark mb-1 card-title">Laporan Kehadiran Karyawan</h4>
                        <h6 class="tx-dark">PT. Maggiollini Indonesia</h6>
                    </div>
                    <div>
                    </div>
                </div>
                
                <hr>
               
                <div class="row mb-2 mt-2 ">
                    <div class="col-12 col-md-6">
                        <table class="table table-bordered w-100">
                            <tr>
                                <td width="150" class="tx-dark"><b> Jenis </b></th>
                                <td width="10">:</td>
                                <td>
                                    <b>
                                        @if (request()->query('jenis_presensi') == 'absen_biasa')
                                        <span class="text-info"> Presensi Harian </span>
                                        @elseif (request()->query('jenis_presensi') == 'absen_lembur')
                                        <span class="text-info"> Presensi Lembur </span>
                                        @elseif (request()->query('jenis_presensi') == 'absen_biasa_lembur')
                                        <span class="text-info"> Presensi Harian & Lembur </span>
                                        @endif
                                    </b>
                                </td>
                            </tr>
                            <tr>
                                <td width="150" class="tx-dark"><b> Periode </b></th>
                                <td width="10">:</td>
                                <td>
                                    @if (request()->query('from') != '' || request()->query('to') != '')
                                    <h6 class="tx-13 tx-info"> 
                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d', request()->query('from'))->isoFormat('D MMMM Y'); }} 
                                        &nbsp;
                                        -
                                        &nbsp;
                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d', request()->query('to'))->isoFormat('D MMMM Y'); }}
                                    </h6>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td width="150" class="tx-dark"><b> Hari Kerja </b></th>
                                <td width="10">:</td>
                                <td>
                                    @if (request()->query('from') != '' || request()->query('to') != '')
                                    <h6 class="tx-13 text-info"> {{$total_working_days}} Hari (Tanpa Hari Minggu)</h6>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td width="150" class="tx-dark"><b> Tipe Pegawai </b></td>
                                <td width="10">:</td>
                                <td>
                                    <b>
                                        @if (request()->query('type') == 'all')
                                        <span class="text-info"> Staff & Non Staff </span>
                                        @elseif (request()->query('type') == 'staff')
                                        <span class="text-info"> Staff </span>
                                        @elseif (request()->query('type') == 'non_staff')
                                        <span class="text-info"> Non Staff </span>
                                        @endif
                                    </b>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-12 col-md-6">
                        <small>
                            <table class="table display">
                                <tr>
                                    <th colspan="2">Keterangan :</th>
                                </tr>
                                <tr>
                                    <th> 1.</th>
                                    <td>Warna <span class="tx-danger font-weight-bold"> Merah </span> pada jam kerja menandakan keterlambatan.</td>
                                </tr>
                                <tr>
                                    <th>2.</th>
                                    <td>Warna <span class="tx-danger font-weight-bold"> Merah </span> pada kolom tanggal di tabel kehadiran menandakan tanggal merah hari libur (Minggu).</td>
                                </tr>
                                <tr>
                                    <th>3.</th>
                                    <td>Warna <span class="tx-warning font-weight-bold"> Oranye </span> pada Tanggal di tabel kehadiran menandakan tanggal merah hari libur nasional. Arahkan kursor selama 3 detik untuk mengetahui keterangan hari libur nasional.</td>
                                </tr>
                                <tr>
                                    <th>4.</th>
                                    <td>Warna <span class="tx-success font-weight-bold"> Hijau </span> pada Tanggal di tabel kehadiran menandakan hari kerja.</td>
                                </tr>
                                <tr>
                                    <th>5.</th>
                                    <td>Total hadir terhitung jika karyawan sudah melakukan checkin dan checkout. Jika belum checkout maka tidak terhitung hadir.</td>
                                </tr>
                            </table>
                        </small>
                    </div>
                </div>

                <hr>
                
                <form id="custom-search-form" class="row mb-2 mt-5">
                    <div class="col-12 col-md-4">
                        <div class="form-group d-flex">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Cari Karyawan">
                            <button type="submit" class="ml-2 btn btn-teal"><i class="fa fa-search"></i> Cari</button>
                        </div>
                    </div>
                    <div class="col-md-8 d-flex justify-content-end align-items-start">
                        {{-- <a href="#"  data-toggle="modal" class="btn btn-success" data-target="#modalEkspor"> --}}
                        <a href="{{route('adm.report.export', ['file_type' => 'excel', 'jenis_presensi' => request()->query('jenis_presensi'), 'type' => request()->query('type'), 'from' => request()->query('from'), 'to' => request()->query('to')])}}" class="download-loading btn btn-success">
                            <i class="fa fa-download"></i>
                            Download Laporan Kehadiran
                        </a>
                    </div>
                </form>
                <div class=" bd-gray-300 rounded table-responsive p-0 overflow-auto">
                    <table id="customDatatble" class="table display nowrap table-hover p-0">
                        
                        <thead class="thead-colored thead-light">
                           
                            <tr>
                                <th class="bg-dark text-light">No</th>
                                <th class="tx-center bg-dark text-light" ><i class="fa fa-cog"></i> <br> Aksi</th>
                                <th class="bg-dark text-light" >Nama Karyawan </th>
                                @if (request()->query('jenis_presensi') == 'absen_biasa')
                                    <th class="bg-info text-light">Hadir</th>
                                    <th class="bg-info text-light">Tidak <br> Hadir </th>
                                    <th class="bg-info text-light">Izin </th>
                                    <th class="bg-info text-light">Telat </th>
                                    <th class="bg-info text-light">Total <br> Jam Kerja</th>
                                    <th class="bg-info text-light">Total <br> Jam Telat</th>
                                @elseif (request()->query('jenis_presensi') == 'absen_lembur')
                                    <th class="bg-primary text-light">Total <br> Jam Lembur</th>
                                    @foreach ($jenis_lembur as $lembur)
                                    <th class="bg-info text-light">{{$lembur->type}}</th>
                                    @endforeach
                                @elseif (request()->query('jenis_presensi') == 'absen_biasa_lembur')
                                    <th class="bg-info text-light">Hadir Harian</th>
                                    <th class="bg-info text-light">Tidak Hadir <br> Harian </th>
                                    <th class="bg-info text-light">Izin </th>
                                    <th class="bg-info text-light">Telat <br> Harian </th>
                                    <th class="bg-info text-light">Total <br> Jam Kerja Harian</th>
                                    <th class="bg-info text-light">Total <br> Jam Telat Harian</th>
                                    <th class="bg-info text-light">Total <br> Jam Lembur</th>
                                    @foreach ($jenis_lembur as $lembur)
                                    <th class="bg-info text-light">{{$lembur->type}}</th>
                                    @endforeach
                                @endif

                                @php
                                    $tanggal = clone $start;
                                    while ($tanggal->lte($end)) {
                                        
                                        if ($tanggal->isWeekday() || $tanggal->dayOfWeek === \Carbon\Carbon::SATURDAY) {
                                            $total_working_days++;
                                        }
                                        $libur_cek = \App\Helpers\General::tanggalMerahOnline($tanggal->format('Ymd'));

                                        if ($libur_cek['libur'] == true && $libur_cek['ket'] == null) {
                                            $tr = 'bg-danger text-light';
                                            $libur_keterangan = 'Libur';
                                        }
                                        elseif ($libur_cek['libur'] == true && $libur_cek['ket'] != null) 
                                        {
                                            $tr = 'bg-warning text-dark';
                                            $libur_keterangan = $libur_cek['ket'];
                                        }
                                        elseif ($libur_cek['libur'] == false && $libur_cek['ket'] == null)
                                        {
                                            $tr = 'bg-success text-dark';
                                            $libur_keterangan = 'Hari Kerja';
                                        }

                                        echo "<th class='".$tr."'><span title='".$libur_keterangan."'>".$tanggal->format('d M Y')."</span></th>";
                                        // echo "<th class='".$tr."'><span class='trigger' title='".$libur_keterangan."'>".$tanggal->format('d M Y')."</span><div class='pop-up'>".$libur_keterangan."</div></th>";
                                        $tanggal->addDay();
                                    }
                                @endphp
                                
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=1;
                            @endphp
                            @foreach ($list_user as $row) 
                             <tr>
                                <td>{{$i++}}.</td>

                                <td class="tx-center" >
                                    <a href="{{route('adm.report.detail', ['karyawan' => $row['usr_id'], 'from_date' => request()->query('from'), 'to_date' => request()->query('to')])}}" target="_blank" class="btn btn-sm btn-outline-info">
                                       <i class="fa fa-eye"></i>
                                       Detail
                                   </a>
                                   <a target="_blank" href="{{route('adm.report.export.detail', ['data' => 'excel', 'karyawan' => $row['usr_id'], 'from' => request()->query('from'), 'to' => request()->query('to')])}}" class="btn btn-sm btn-outline-success">
                                       <i class="fa fa-download"></i>
                                       Ekspor
                                   </a>
                                </td>
                                <td class="d-flex flex-column">
                                    <span class="text-dark font-weight-bold mb-1"> {{$row['full_name']}} </span>
                                </td>
                                
                                @if (request()->query('jenis_presensi') == 'absen_biasa')
                                    <td>{{$row['kalkulasi']['total_hari_hadir']}}</td>
                                    <td>{{$row['kalkulasi']['total_hari_alfa']}}</td>
                                    <td>{{$row['kalkulasi']['total_izin']}}</td>
                                    <td>{{$row['kalkulasi']['total_telat']}}</td>
                                    <td>{{$row['kalkulasi']['total_jam_kerja']}}</td>
                                    <td>{{$row['kalkulasi']['total_jam_terlambat']}}</td>
                                @elseif (request()->query('jenis_presensi') == 'absen_lembur')
                                    <td>{{$row['kalkulasi']['total_jam_lembur']}}</td>
                                    @foreach ($jenis_lembur as $lembur)
                                        <td>{{$row['kalkulasi']['total_jenis_lembur'][$row['usr_id']][$lembur->slug]['total']}}</td>
                                    @endforeach
                                @elseif (request()->query('jenis_presensi') == 'absen_biasa_lembur')
                                    <td>{{$row['kalkulasi']['total_hari_hadir']}}</td>
                                    <td>{{$row['kalkulasi']['total_hari_alfa']}}</td>
                                    <td>{{$row['kalkulasi']['total_izin']}}</td>
                                    <td>{{$row['kalkulasi']['total_telat']}}</td>
                                    <td>{{$row['kalkulasi']['total_jam_kerja']}}</td>
                                    <td>{{$row['kalkulasi']['total_jam_terlambat']}}</td>
                                    <td>{{$row['kalkulasi']['total_jam_lembur']}}</td>
                                    @foreach ($jenis_lembur as $lembur)
                                        <td>{{$row['kalkulasi']['total_jenis_lembur'][$row['usr_id']][$lembur->slug]['total']}}</td>
                                    @endforeach
                                @endif
                               

                                 @for ($hari = 1; $hari <= $end->diffInDays($start) + 1; $hari++)
                                    <td class="{{ $detail_presensi[$row['usr_id']][$hari]['td_color'] }}">
                                        <small>
                                            @if( $detail_presensi[$row['usr_id']][$hari]['hari'] == 'Sun' && $detail_presensi[$row['usr_id']][$hari]['jam'] == null)
                                                libur
                                            @else 
                                                @if ($detail_presensi[$row['usr_id']][$hari]['jam'] != null)
                                                    @foreach ($detail_presensi[$row['usr_id']][$hari]['jam'] as $key => $val)
                                                        @if ($val['izin'] != null)
                                                            <a href="{{route('adm.izin.detail',$val['id_izin'])}}" target="_blank" title="Lihat Detail">
                                                                <b class="tx-info">IZIN</b>
                                                                <br> 
                                                                <span class="text-primary"> {{ $val['izin'] }}</span>
                                                                <br>
                                                            </a>
                                                        @else
                                                                @if ($val['jenis_lembur'] != null)
                                                                    <b class="tx-dark"> <span> {{ $val['jenis_lembur'] }}</span> </b>
                                                                    <br>
                                                                @else
                                                                    @if (request()->query('jenis_presensi') == 'absen_biasa_lembur')
                                                                    <b class="tx-info"> <span> Presensi Harian</span> </b>
                                                                    <br>
                                                                    @endif
                                                                @endif
                                                                
                                                                <b> IN: </b> <span class="{{ $val['late'] != null ? 'tx-danger' : '' }}"> {{ $val['in'] ?? '-' }}</span>
                                                                <br>
                                                                <b> OUT: </b> <span class="{{ $val['late'] != null ? 'tx-danger' : '' }}">  {{ $val['out']  ?? '-' }}</span> 
                                                                <br>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    Tidak Hadir
                                                @endif
                                            @endif
                                        </small>
                                    </td>
                                @endfor
                             </tr> 
                             @endforeach
                        </tbody>
                    </table>
                </div><!-- bd -->
            </div>
        </div>
    </div>
    @else
    <div class="row mt-3">
        <div class="col-12">
            <div class="br-section-wrapper pd-15 h-100 text-center">
                <h6 class="my-5">
                    Silakan pilih <b class="tx-info"> Jenis Presensi </b> dan <b class="tx-info"> Periode (Dari Tanggal - Sampai Tanggal) </b> untuk menampilkan data laporan presensi.
                </h6>
            </div>
        </div>
    </div>
    @endif
    
</div>

<div id="modalEkspor" class="modal fade">
    <div class="modal-dialog modal-dialog-lg modal-dialog-centered" role="document">
        <div class="modal-content tx-size-sm">
            <div class="card-header d-flex justify-content-between">
                <span class="d-flex align-items-center">
                    <i class="fa fa-download tx-primary lh-1 d-inline-block"></i>
                    <span class="tx-primary ml-2 font-weight-bold">
                        Ekspor Laporan
                    </span>
                </span>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body tx-center pd-y-20 pd-x-20">

                <div class="row">
                    <div class="col-12 col-md">
                        <div class="card">
                            <div class="card-body">
                                <a target="_blank" href="{{route('adm.report.export', ['file_type' => 'excel', 'jenis_presensi' => request()->query('jenis_presensi'), 'type' => request()->query('type'), 'from' => request()->query('from'), 'to' => request()->query('to')])}}" class="btn btn-block btn-sm btn-success">
                                    <i class="fa fa-download"></i>
                                    Ekspor Excel
                                </a>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <a target="_blank" href="{{route('adm.report.export', ['file_type' => 'pdf', 'jenis_presensi' => request()->query('jenis_presensi'), 'type' => request()->query('type'), 'from' => request()->query('from'), 'to' => request()->query('to')])}}" class="btn btn-block btn-sm btn-danger">
                                    <i class="fa fa-download"></i>
                                    Ekspor PDF
                                </a>
                            </div>
                        </div>
                    </div> --}}
                </div>


            </div><!-- modal-body -->
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


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

    .dataTables_filter {
  display: none;
}

 
    </style> 
@endpush

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    // var loadTime = window.performance.timing.domContentLoadedEventEnd-window.performance.timing.navigationStart;
    // console.log(loadTime);
    $(document).ready(function() {

        // $("th").tooltip();  
        
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
        
        $('#custom-search-form').on('submit', function(e) {
            e.preventDefault();
            
            var name = $('#name').val();
            dataTable.search(name).draw();
        });
    });

    $('#filter_form').submit(function() {

        var from_date = $('input[name=from]').val(); 
        var to_date = $('input[name=to]').val(); 
        var jenis_presensi = $('select[name=jenis_presensi] option:selected').val(); 

        if(jenis_presensi === "") {
            Swal.fire({
                title: 'Peringatan !',
                text: 'Jenis Presensi Masih kosong. Pilih jenis presensi terlebih dahulu.',
                icon: 'warning',
                confirmButtonText: 'Tutup'
            })
            return false;
        }

        if(from_date === "" || to_date === "" || jenis_presensi === "") {
            Swal.fire({
                title: 'Peringatan !',
                text: 'Tanggal masih kosong. Harap isi 2 rentang tanggal periode terlebih dahulu.',
                icon: 'warning',
                confirmButtonText: 'Tutup'
            })
            return false;
        }

        if(from_date !== "" || to_date !== "" || jenis_presensi !== "") {
            Swal.fire({
                title: 'Proses Genereate Laporan',
                html: 'Harap tunggu beberapa saat ...',
                allowEscapeKey: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        }
       
    });

    $('.download-loading').click(function() {

        Swal.fire({
            title: 'Proses Download Laporan',
            html: 'Harap tunggu ...',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timer: 10000,
            didOpen: () => {
                Swal.showLoading()
            }
        });
       
    });

</script>
@endpush
