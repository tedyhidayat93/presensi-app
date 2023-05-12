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
                        <h6 class="tx-teal">PT. Maggiollini Indonesia</h6>
                    </div>
                    <div>
                        
                        <a href="#"  data-toggle="modal" class="btn btn-sm btn-primary" data-target="#modalEkspor">
                            <i class="fa fa-download"></i>
                            Ekspor Rekapitulasi Laporan
                        </a>
                    </div>
                </div>
                
                <hr>
               
                <div class="d-block mb-2 mt-2 d-md-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        @if (request()->query('from') != '' || request()->query('to') != '')
                        <h6 class="tx-13 text-dark"> 
                            <b> Periode :  </b>
                            <b class="text-info">
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', request()->query('from'))->isoFormat('D MMMM Y'); }} 
                            </b>
                            &nbsp;
                            -
                            &nbsp;
                            <b class="text-info">
                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', request()->query('to'))->isoFormat('D MMMM Y'); }}
                            </b>
                        </h6>

                        <h6 class="tx-13 text-dark"> &nbsp;&nbsp;|&nbsp;&nbsp;</h6>
                        <h6 class="tx-13 text-dark"><b> Hari Kerja : </b> <b>( {{$total_working_days}} Hari )</b> </h6>
                        @endif
                    </div>
                    <div class="d-flex align-items-center">

                        {{-- <h6 class="tx-13 text-dark mr-2">
                            <b> Status : </b>  
                            @if (request()->query('status') == 'all')
                            <span class="text-info"> Tetap & Kontrak </span>
                            @elseif (request()->query('status') == 'tetap')
                            <span class="text-info"> Tetap </span>
                            @elseif (request()->query('status') == 'kontrak')
                            <span class="text-info"> Kontrak </span>
                            @endif
                        </h6> --}}

                        {{-- <span> &nbsp;|&nbsp; </span> --}}
                        
                        <h6 class="tx-13 text-dark">
                            <b> Tipe : </b>  
                            @if (request()->query('type') == 'all')
                            <span class="text-info"> Staff & Non Staff </span>
                            @elseif (request()->query('type') == 'staff')
                            <span class="text-info"> Staff </span>
                            @elseif (request()->query('type') == 'non_staff')
                            <span class="text-info"> Non Staff </span>
                            @endif
                        </h6>

                    </div>
                </div>

                <hr>
                
                <div class="d-block mt-2 mb-2 py-2 rounded px-3" style="background-color: #fcfcfc; box-shadow: 0 0 10px rgb(211, 211, 211);">
                    {{-- <input type="text" id="search_any" class="form-control" placeholder="Cari Karyawan..."> --}}
                    <form id="custom-search-form" class="row">
                        <div class="col-12 col-md-5">
                            <div class="form-group">
                                <label for="name">Nama Karyawan</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Karyawan">
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="gender">Jenis Kelamin</label>
                                <select name="gender" class="form-control" id="gender">
                                    <option value="">Laki-Laki & Perempuan</option>
                                    <option value="Laki-Laki">Laki - Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>
                                <select name="jabatan" id="jabatan" class="selecttu form-control" >
                                    <option value="">Semua Jabatan</option>

                                        @if ($jabatan)
                                        @foreach ($jabatan as $j)
                                        <option value="{{$j->type}}">{{$j->type}}</option>
                                        @endforeach
                                        @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-block btn-success">Cari</button>
                        </div>
                      </form>
                </div>
                <div class=" bd-gray-300 rounded table-responsive p-0 overflow-auto">
                    <table id="customDatatble" class="table table-bordered table-hover p-0">
                        
                        <thead class="thead-colored thead-light">
                           
                            <tr>
                                <th class="bg-dark text-light">No</th>
                                <th class="bg-dark text-light">Nama</th>
                                <th class="bg-dark text-light">Jenis Kelamin</th>
                                <th class="bg-dark text-light">Jabatan</th>
                                <th class="bg-warning">Total Hadir</th>
                                <th class="bg-warning">Total Jam Kerja</th>
                                <th class="bg-warning">Total Terlambat</th>
                                <th class="bg-warning">Total Lembur</th>
                                <th class="bg-warning">Total Jam Lembur</th>
                                <th class="bg-warning">Total Ijin</th>
                                <th class="bg-warning">Total Tidak Hadir</th>
                                <th class="tx-center bg-info text-light" width="180"><i class="fa fa-cog"></i> <br> Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=1;
                            @endphp
                             @foreach ($list_user as $row) 
                             <tr>
                                <td>{{$i++}}.</td>
                                 <td class="d-flex flex-column">
                                     <span class="text-dark font-weight-bold mb-1"> {{$row['full_name']}} </span>
                                     <small><b> Status:</b> {{$row['status'] ?? '-'}}</small>
                                     <small><b> Tipe:</b> {{$row['type'] ?? '-'}}</small>
                                     <small><b> NIP:</b> {{$row['nip'] ?? '-'}}</small>
                                     <small><b> NIK:</b> {{$row['nik'] ?? '-'}}</small>
                                 </td>
                                 <td>{{$row['gender'] ?? '-'}}</td>
                                 <td>{{$row['jabatan'] ?? '-'}}</td>

                                 <td class="text-center">{{$row['data_absen']['total_hari_hadir'] ?? '-'}}</td>
                                 <td class="text-center">{{$row['data_absen']['total_jam_kerja'] ?? '-'}}</td>
                                 <td class="text-center">{{$row['data_absen']['total_jam_terlambat'] ?? '-'}}</td>
                                 <td class="text-center">{{$row['data_absen']['total_hari_lembur'] ?? '-'}}</td>
                                 <td class="text-center">{{$row['data_absen']['total_jam_lembur'] ?? '-'}}</td>
                                 <td class="text-center">{{$row['data_absen']['total_izin'] ?? '-'}}</td>
                                 <td class="text-center">{{$row['data_absen']['total_hari_alfa'] ?? '-'}}</td>
                                 <td class="tx-center">
                                     <a href="{{route('adm.report.detail', ['karyawan' => $row['usr_id'], 'from_date' => request()->query('from'), 'to_date' => request()->query('to')])}}" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="fa fa-eye"></i>
                                        Detail
                                    </a>
                                    <a target="_blank" href="{{route('adm.report.export.detail', ['data' => 'excel', 'karyawan' => $row['usr_id'], 'from' => request()->query('from'), 'to' => request()->query('to')])}}" class="btn btn-sm btn-outline-success">
                                        <i class="fa fa-download"></i>
                                        Ekspor
                                    </a>
                                 </td>
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
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <p>Ekspor Detail Laporan Kehadiran Semua Karyawan</p>
                                <a target="_blank" href="{{route('adm.report.export', ['data' => 'excel', 'status' => request()->query('status'), 'type' => request()->query('type'), 'from' => request()->query('from'), 'to' => request()->query('to'), 'method' => 'bulk'])}}" class="btn btn-block btn-sm btn-success">
                                    <i class="fa fa-download"></i>
                                    Ekspor Excel
                                </a>
                                <a target="_blank" href="{{route('adm.report.export', ['data' => 'pdf', 'status' => request()->query('status'), 'type' => request()->query('type'), 'from' => request()->query('from'), 'to' => request()->query('to'), 'method' => 'bulk'])}}" class="btn btn-block btn-sm btn-danger">
                                    <i class="fa fa-download"></i>
                                    Ekspor PDF
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <p>Ekspor Hanya Rekapan Global Kehadiran Semua Karyawan</p>
                                <a target="_blank" href="{{route('adm.report.export', ['data' => 'excel', 'status' => request()->query('status'), 'type' => request()->query('type'), 'from' => request()->query('from'), 'to' => request()->query('to'), 'method' => 'single'])}}" class="btn btn-block btn-sm btn-success">
                                    <i class="fa fa-download"></i>
                                    Ekspor Excel
                                </a>
                                <a target="_blank" href="{{route('adm.report.export', ['data' => 'pdf', 'status' => request()->query('status'), 'type' => request()->query('type'), 'from' => request()->query('from'), 'to' => request()->query('to'), 'method' => 'single'])}}" class="btn btn-block btn-sm btn-danger">
                                    <i class="fa fa-download"></i>
                                    Ekspor PDF
                                </a>
                            </div>
                        </div>
                    </div>
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

    /* #custom-search-form {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  margin-bottom: 20px;
}

#custom-search-form label {
  margin-right: 10px;
}

#custom-search-form input[type="text"] {
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 3px;
  margin-right: 10px;
}

#custom-search-form button[type="submit"] {
  padding: 5px 10px;
  background-color: #4CAF50;
  color: #fff;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}*/
    </style> 
@endpush

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    $(document).ready(function() {
        var dataTable = $('#customDatatble').DataTable({
                // responsive: true,
                aLengthMenu: [
                    [10, 30, 50, 100, 200, 300, -1],
                    [10, 30, 50, 100, 200, 300, "Semua"]
                ],
                iDisplayLength: -1,
                responsive: false,
                language: {
                    sSearch: '',
                    lengthMenu: '_MENU_ Data yang ditampilkan',
                }
            });
        
        $('#custom-search-form').on('submit', function(e) {
            e.preventDefault();
            
            var name = $('#name').val();
            var gender = $('#gender option:selected').val();
            var jabatan = $('#jabatan option:selected').val();


            
            dataTable.search(name).draw();
            dataTable.columns(1).search(gender).draw();
            dataTable.columns(2).search(jabatan).draw();
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
       
    });

</script>
@endpush
