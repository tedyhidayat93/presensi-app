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
                      <div class="card-stats-item-count text-dark">{{$total_employee}}</div>
                      <div class="card-stats-item-label"> <i style="font-size: 10px;" class="fas fa-user"></i>&nbsp; Semua Pegawai</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count text-info">{{$total_employee_staff}}</div>
                      <div class="card-stats-item-label"> <i style="font-size: 10px;" class="fas fa-user"></i>&nbsp; Staff</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count text-warning">{{$total_employee_non_staff}}</div>
                      <div class="card-stats-item-label"> <i style="font-size: 10px;" class="fas fa-user"></i>&nbsp; Non Staff</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count text-success">{{$total_employee_tetap}}</div>
                      <div class="card-stats-item-label"> <i style="font-size: 10px;" class="fas fa-user"></i>&nbsp; Tetap</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count text-primary">{{$total_employee_kontrak}}</div>
                      <div class="card-stats-item-label"> <i style="font-size: 10px;" class="fas fa-user"></i>&nbsp; Kontrak</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count text-gray">{{$total_employee_magang}}</div>
                      <div class="card-stats-item-label"> <i style="font-size: 10px;" class="fas fa-user"></i>&nbsp; Magang</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count text-secondary">{{$total_employee_harian}}</div>
                      <div class="card-stats-item-label"> <i style="font-size: 10px;" class="fas fa-user"></i>&nbsp; Harian</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count text-danger">{{$total_employee_non_active}}</div>
                      <div class="card-stats-item-label"> <i style="font-size: 10px;" class="fas fa-user"></i>&nbsp; Non Aktif</div>
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
                    <div class="card-body d-md-flex justify-content-md-between align-items-md-center">
                        {{-- <h6 class="card-title"></h6> --}}
                        <div>
                            <form action="" method="get" class="d-flex align-item-center">
                                <div class="form-group mb-0 mr-1">
                                    <select name="status" class="form-control select2 form-control-sm" >
                                        <option value="" selected>-- Status --</option>
                                        <option value="magang">Magang</option>
                                        <option value="tetap">Tetap</option>
                                        <option value="kontrak">Kontrak</option>
                                        <option value="harian">Harian</option>
                                    </select>
                                </div>
                                <div class="form-group mb-0 mr-1">
                                    <select name="type" class="form-control select2 form-control-sm" >
                                        <option value="" selected>-- Tipe --</option>
                                        <option value="staff">Staff</option>
                                        <option value="non_staff">Non Staff</option>
                                    </select>
                                </div>
                                <div class="form-group mb-0 mr-1">
                                    <select name="employee_type" class="form-control select2 form-control-sm" >
                                        <option value="" selected disabled>-- Jabatan --</option>

                                            @if ($jabatan)
                                            @foreach ($jabatan as $j)
                                            <option value="{{$j->id}}">{{$j->type}}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                </div>
                                <div class="form-group mb-0 mr-1">
                                    <select name="gender" class="form-control select2 form-control-sm" >
                                        <option value="" selected>-- Jenis Kelamin --</option>
                                        <option value="L">Laki - Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                {{-- <div class="form-group mb-0 mr-1">
                                    <select name="shift" class="form-control form-control-sm" >
                                        <option value="" selected disabled>-- Shift --</option>

                                            @if ($shifts)
                                            @foreach ($shifts as $j)
                                            <option value="{{$j->id}}">{{$j->shift_name}}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                </div> --}}
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    <span class="pd-x-5">Filter</span>
                                </button>
                                
                            </form>
                        </div>
                        <div>
                            @canany(['admin-karyawan-create'])
                            <a href="#" data-toggle="modal" data-target="#modaldemoImport" class="btn btn-light btn-sm btn-with-icon mr-1">
                                <div class="ht-40">
                                    <span class="icon wd-40"><i class="fa fa-upload"></i></span>
                                    <span class="pd-x-15">Import</span>
                                </div>
                            </a>
                            <a target="_blank" href="{{route('adm.employee.export', ['data' => 'excel', 'tipe' => request()->query('type'), 'status' => request()->query('status')])}}" class="btn btn-light btn-sm btn-with-icon mr-1">
                                <div class="ht-40">
                                    <span class="icon wd-40"><i class="fa fa-download"></i></span>
                                    <span class="pd-x-15">Export</span>
                                </div>
                            </a>
                            <a href="{{$route_create}}" class="btn btn-primary btn-sm">
                                <div class="ht-40">
                                    <span class="icon wd-40"><i class="fa fa-plus"></i></span>
                                    <span class="pd-x-15">Tambah Pegawai</span>
                                </div>
                            </a>
                            @endcanany
                        </div>
                    </div><!-- card-header -->
                    <div class="card-body pd-15 bd-color-gray-lighter table-responsive overflow-auto">
                        @if (request()->query('status') || request()->query('type') || request()->query('employee_type') || request()->query('gender') || request()->query('shift') )
                        <p>
                            <b>Filter By : </b>
                            
                            @if (request()->query('status'))
                            {{request()->query('status')}}, 
                            @endif

                            @if (request()->query('type'))
                            {{request()->query('type') == 'staff' ? 'Staff' : 'Non Staff'}}, 
                            @endif

                            @if (request()->query('employee_type'))
                            {{$jabatan_name}}, 
                            @endif
                            
                            @if (request()->query('gender'))
                            {{request()->query('gender') == 'L' ? 'Laki-laki' : 'Perempuan'}}, 
                            @endif
                            
                            @if (request()->query('shift'))
                            {{$shift_name}},  
                            @endif

                            <a href="{{route('adm.employee')}}" class="ml-2 text-danger"><small>&times; Reset Filter</small> </a>
                        </p>
                        @endif
                        <table id="datatable1" class="table display nowrap">
                            <thead class="">
                                <tr>
                                    <th class="wd-5p">#</th>
                                    <th class="">Foto</th>
                                    <th class="">Nama Lengkap</th>
                                    <th class="">Jenis Kelamin</th>
                                    <th class="">NIP & NIK</th>
                                    {{-- <th class="">Pendidikan</th> --}}
                                    <th class="">Email</th>
                                    <th class="">Status</th>
                                    {{-- <th class="">Tipe</th>
                                    <th class="">Jabatan</th>
                                    <th class="">Shift</th>
                                    <th class="">Tanggal Masuk</th> --}}
                                    <th class="">Masa Kerja</th>
                                    {{-- <th class="">Tanggal Register</th> --}}
                                    {{-- <th class="">Shift</th> --}}
                                    <th class="">Status</th>
                                    <th class="wd-5p">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=1;
                                @endphp
                                @foreach ($data as $row)
                                <tr>
                                    <td>{{$i++}}.</td>
                                    <td>
                                        @if ($row->photo_profile)
                                        <img width="35" class="rounded-circle"
                                            src="{{ asset('uploads/images/employee/'. $row->photo_profile) }}">
                                        @else
                                        <img width="35" class="rounded-circle" src="{{ asset('images/default-ava.jpg') }}"> 
                                        @endif
                                    </td>
                                    <td>{{$row->full_name ?? '-'}}</td>
                                    <td>
                                        @php 
                                            $gender = '-';
                                            if($row->gender == 'L') {
                                                $gender = 'Laki -Laki';
                                            }else {
                                                $gender = 'Perempuan';
                                            }
                                        @endphp
                                        {{$gender}}
                                    </td>
                                    <td>
                                        NIK : <b> {{$row->nik ?? '-'}} </b>
                                         <br>
                                        NIP : <b>{{$row->nip ?? '-'}} </b>
                                    </td>
                                    {{-- <td>{{$row->education->education ?? '-'}}</td> --}}
                                    <td>{{$row->email ?? '-'}}</td>
                                    <td class="text-capitalize">{{$row->status}}</td>
                                    {{-- <td>{{$row->type == 'staff' ? 'Staff' : 'Non Staff'}}</td> --}}
                                    {{-- <td>{{$row->jabatan->type ?? "-"}}</td> --}}
                                    {{-- <td>{{$row->shifft->shift_name ?? '-'}}</td> --}}
                                    {{-- <td>{{ date('d-M-Y', strtotime($row->tanggal_masuk ?? '0000-00-00'))}}</td> --}}
                                    <td>
                                    @php
                                        $startDate = \Carbon\Carbon::parse($row->tanggal_masuk);
                                        if($row->is_active == 1) {
                                            $endDate = \Carbon\Carbon::now();
                                        } else {
                                            $endDate = \Carbon\Carbon::parse($row->tanggal_keluar);
                                        }
                                        $duration = $endDate->diff($startDate);
                                        echo $duration->format('%y tahun %m bulan')
                                    @endphp
                                    </td>
                                    {{-- <td>{{ date('d-M-Y', strtotime($row->registered_at ?? '0000-00-00'))}}</td> --}}
                                    <td>{!!$row->is_active == 1 ? '<span
                                            class="badge badge-success">Aktif</span>':'<span
                                            class="badge badge-danger">Non Aktif</span>' !!}</td>
                                    <td>

                                        @canany(['admin-karyawan-is-active'])
                                        <a href="#"
                                            class="btn btn-{{$row->is_active == 1 ? 'danger':'success' }} btn-icon wd-35 ht-35"
                                            data-toggle="modal" data-target="#modaldemo{{$row->id}}">
                                            <div><i
                                                    class="fa {{$row->is_active == 1 ? 'fa-toggle-on':'fa-toggle-off' }} "></i>
                                            </div>
                                        </a>
                                        @endcanany

                                        @canany(['admin-karyawan-edit'])
                                        <a href="{{route('adm.employee.edit', $row->id)}}"
                                            class="btn btn-info btn-sm btn-icon wd-35 ht-35 ">
                                            <div><i class="fa fa-edit"></i></div>
                                        </a>
                                        @endcanany
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div><!-- card-body -->
                </div>
            </div>
        </div>
    </div>

</div>

<!-- MODAL IMPORT -->
<div id="modaldemoImport" class="modal fade">
   <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fa fa-upload text-50  text-info lh-1 mg-t-20 d-inline-block mb-4" style="font-size: 35px;"></i>
                <h4 class="text-info font-weight-bold mg-b-20">Import Data Karyawan</h4>
                <form action="{{route('adm.employee.import')}}" method="POST" enctype="multipart/form-data">
                    <small class="mb-4">
                        Untuk dapat mengimport data karyawan, silakan ikuti format berikut : <br> <u><a href="{{asset('template-import-akun-karyawan.xlsx')}}" target="_blank" class="text-info">Download Format Excel</a></u> 
                    </small>
                    @csrf
                    <div class="forom-group mb-3">
                        <label for=""><small class="text-info"> (Tipe: Excel) </small></label>
                        <input class="form-control form-control-sm" type="file" name="data" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    </div>
                    
                    {{-- <button type="button"
                        class="btn btn-light text-11 text-uppercase pd-y-12 pd-x-25 text-mont text-medium mg-b-20"
                        data-dismiss="modal" aria-label="Close">Batal</button> --}}
                    <button type="submit"
                        class="btn btn-info text-11 text-uppercase pd-y-12 pd-x-25 text-mont text-medium mg-b-20">Import</button>
                </form>
            </div><!-- modal-body -->
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<!-- MODAL ALERT MESSAGE DELETE -->
@foreach ($data as $row)
<div id="modaldemo{{$row->id}}" class="modal fade">
   <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
                <i
                    class="fa fa-question-circle text-100  {{$row->is_active == 1 ? 'text-danger' : 'text-success'}} lh-1 mg-t-20 d-inline-block mb-4" style="font-size: 35px;"></i>
                <h4 class="{{$row->is_active == 1 ? 'text-danger' : 'text-success'}} font-weight-bold mg-b-20">Yakin ingin
                    {{$row->is_active == 1 ? 'me-nonaktifkan' : 'meng-aktifkan'}} Karyawan ?
                </h4>
                <p class="mg-b-20 mg-x-20">User <b> "{{$row->full_name}}" </b> akan
                    {{$row->is_active == 1 ? 'non-aktif' : 'aktif'}}.</p>
                <form action="{{$route_delete}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{$row->id}}">
                    <input type="hidden" name="is_active" value="{{$row->is_active == 1 ? 0 : 1}}">
                    <button type="button"
                        class="btn btn-light text-11 text-uppercase pd-y-12 pd-x-25 text-mont text-medium mg-b-20"
                        data-dismiss="modal" aria-label="Close">Batal</button>
                    <button type="submit"
                        class="btn {{$row->is_active == 1 ? 'btn-danger' : 'btn-success'}} text-11 text-uppercase pd-y-12 pd-x-25 text-mont text-medium mg-b-20">Ya,
                        {{$row->is_active == 1 ? 'Non-Aktifkan' : 'Aktifkan'}}</button>
                </form>
            </div><!-- modal-body -->
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
@endforeach

@endsection


@push('active-employee')
active
@endpush

@push('menuOpen-employee')
style="display: block;"
@endpush

@push('showSub-employee')
show-sub
@endpush

@push('styles')
@endpush

@push('scripts')
@endpush
