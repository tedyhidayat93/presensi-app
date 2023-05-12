@extends('layouts.admin.app', $head)


@section('dynamic-content')
<div class="br-pagebody mg-t-5 pd-x-20 pd-b-200">
    <div class="row row-sm mb-3">
        <div class="col-sm-6 col-md">
            <div class="bg-dark rounded overflow-hidden">
                <div class="pd-10 d-flex align-items-center">
                    <i class="ion ion-person-stalker tx-30 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-5">Semua
                        </p>
                        <p class="tx-18 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_employee}}</p>
                        <span class="tx-11 tx-roboto tx-white-6">Karyawan</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-md">
            <div class="bg-info rounded overflow-hidden">
                <div class="pd-10 d-flex align-items-center">
                    <i class="ion ion-person-stalker tx-30 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-5">Staff
                        </p>
                        <p class="tx-18 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_employee_staff}}</p>
                        <span class="tx-11 tx-roboto tx-white-6">Karyawan</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-md">
            <div class="bg-warning rounded overflow-hidden">
                <div class="pd-10 d-flex align-items-center">
                    <i class="ion ion-person-stalker tx-30 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-5">Non Staff
                        </p>
                        <p class="tx-18 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_employee_non_staff}}</p>
                        <span class="tx-11 tx-roboto tx-white-6">Karyawan</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-md">
            <div class="bg-success rounded overflow-hidden">
                <div class="pd-10 d-flex align-items-center">
                    <i class="ion ion-person-stalker tx-30 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-5">Tetap
                        </p>
                        <p class="tx-18 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_employee_tetap}}</p>
                        <span class="tx-11 tx-roboto tx-white-6">Karyawan</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-md">
            <div class="bg-primary rounded overflow-hidden">
                <div class="pd-10 d-flex align-items-center">
                    <i class="ion ion-person-stalker tx-30 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-5">Kontrak
                        </p>
                        <p class="tx-18 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_employee_kontrak}}</p>
                        <span class="tx-11 tx-roboto tx-white-6">Karyawan</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-md">
            <div class="bg-teal rounded overflow-hidden">
                <div class="pd-10 d-flex align-items-center">
                    <i class="ion ion-person-stalker tx-30 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-5">Magang
                        </p>
                        <p class="tx-18 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_employee_magang}}</p>
                        <span class="tx-11 tx-roboto tx-white-6">Karyawan</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-md">
            <div class="bg-secondary rounded overflow-hidden">
                <div class="pd-10 d-flex align-items-center">
                    <i class="ion ion-person-stalker tx-30 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-5">Harian
                        </p>
                        <p class="tx-18 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_employee_harian}}</p>
                        <span class="tx-11 tx-roboto tx-white-6">Karyawan</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-md">
            <div class="bg-danger rounded overflow-hidden">
                <div class="pd-10 d-flex align-items-center">
                    <i class="ion ion-person-stalker tx-30 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-5">Non Aktif
                        </p>
                        <p class="tx-18 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_employee_non_active}}</p>
                        <span class="tx-11 tx-roboto tx-white-6">Karyawan</span>
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
                        {{-- <h6 class="card-title"></h6> --}}
                        <div>
                            <form action="" method="get" class="d-flex align-item-center">
                                <div class="form-group mb-0 mr-1">
                                    <select name="status" class="form-control" >
                                        <option value="" selected>-- Status --</option>
                                        <option value="magang">Magang</option>
                                        <option value="tetap">Tetap</option>
                                        <option value="kontrak">Kontrak</option>
                                        <option value="harian">Harian</option>
                                    </select>
                                </div>
                                <div class="form-group mb-0 mr-1">
                                    <select name="type" class="form-control" >
                                        <option value="" selected>-- Tipe --</option>
                                        <option value="staff">Staff</option>
                                        <option value="non_staff">Non Staff</option>
                                    </select>
                                </div>
                                <div class="form-group mb-0 mr-1">
                                    <select name="employee_type" class="form-control" >
                                        <option value="" selected disabled>-- Jabatan --</option>

                                            @if ($jabatan)
                                            @foreach ($jabatan as $j)
                                            <option value="{{$j->id}}">{{$j->type}}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                </div>
                                <div class="form-group mb-0 mr-1">
                                    <select name="gender" class="form-control" >
                                        <option value="" selected>-- Jenis Kelamin --</option>
                                        <option value="L">Laki - Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                {{-- <div class="form-group mb-0 mr-1">
                                    <select name="shift" class="form-control" >
                                        <option value="" selected disabled>-- Shift --</option>

                                            @if ($shifts)
                                            @foreach ($shifts as $j)
                                            <option value="{{$j->id}}">{{$j->shift_name}}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                </div> --}}
                                <button type="submit" class="btn btn-outline-teal text-teal btn-sm ht-40">
                                    <span class="pd-x-5">Filter</span>
                                </button>
                                
                            </form>
                        </div>
                        <div>
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
                            <a href="{{$route_create}}" class="btn btn-teal btn-sm btn-with-icon">
                                <div class="ht-40">
                                    <span class="icon wd-40"><i class="fa fa-plus"></i></span>
                                    <span class="pd-x-15">Tambah Karyawan</span>
                                </div>
                            </a>
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
                                    <th class="">Pendidikan</th>
                                    <th class="">Email</th>
                                    <th class="">Status</th>
                                    <th class="">Tipe</th>
                                    <th class="">Jabatan</th>
                                    <th class="">Shift</th>
                                    <th class="">Tanggal Masuk</th>
                                    <th class="">Masa Kerja</th>
                                    <th class="">Tanggal Register</th>
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
                                        <img width="50"
                                            src="{{ asset('uploads/images/employee/'. $row->photo_profile) }}">
                                        @else
                                        <img width="50" src="{{ asset('images/default-ava.jpg') }}"> 
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
                                    <td>{{$row->education->education ?? '-'}}</td>
                                    <td>{{$row->email ?? '-'}}</td>
                                    <td class="text-capitalize">{{$row->status}}</td>
                                    <td>{{$row->type == 'staff' ? 'Staff' : 'Non Staff'}}</td>
                                    <td>{{$row->jabatan->type ?? "-"}}</td>
                                    <td>{{$row->shifft->shift_name ?? '-'}}</td>
                                    <td>{{ date('d-M-Y', strtotime($row->tanggal_masuk ?? '0000-00-00'))}}</td>
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
                                    <td>{{ date('d-M-Y', strtotime($row->registered_at ?? '0000-00-00'))}}</td>
                                    <td>{!!$row->is_active == 1 ? '<span
                                            class="badge badge-success">Aktif</span>':'<span
                                            class="badge badge-danger">Non Aktif</span>' !!}</td>
                                    <td>

                                        <a href="#"
                                            class="btn btn-{{$row->is_active == 1 ? 'danger':'success' }} btn-icon wd-35 ht-35"
                                            data-toggle="modal" data-target="#modaldemo{{$row->id}}">
                                            <div><i
                                                    class="fa {{$row->is_active == 1 ? 'fa-toggle-on':'fa-toggle-off' }} "></i>
                                            </div>
                                        </a>

                                        <a href="{{route('adm.employee.edit', $row->id)}}"
                                            class="btn btn-info btn-icon wd-35 ht-35 ">
                                            <div><i class="fa fa-edit"></i></div>
                                        </a>

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
    <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fa fa-upload tx-50  tx-teal lh-1 mg-t-20 d-inline-block"></i>
                <h4 class="tx-teal tx-semibold mg-b-20">Import Data Karyawan</h4>
                <form action="{{route('adm.employee.import')}}" method="POST" enctype="multipart/form-data">
                    <small class="mb-4">
                        Untuk dapat mengimport data karyawan, silakan ikuti format berikut : <br> <u><a href="{{asset('template-import-akun-karyawan.xlsx')}}" target="_blank" class="text-info">Download Format Excel</a></u> 
                    </small>
                    @csrf
                    <div class="forom-group mb-3">
                        <label for=""><small class="tx-info"> (Tipe: Excel) </small></label>
                        <input class="form-control" type="file" name="data" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    </div>
                    
                    {{-- <button type="button"
                        class="btn btn-light tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium mg-b-20"
                        data-dismiss="modal" aria-label="Close">Batal</button> --}}
                    <button type="submit"
                        class="btn btn-teal tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium mg-b-20">Import</button>
                </form>
            </div><!-- modal-body -->
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<!-- MODAL ALERT MESSAGE DELETE -->
@foreach ($data as $row)
<div id="modaldemo{{$row->id}}" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
                <i
                    class="fa fa-question-circle tx-100  {{$row->is_active == 1 ? 'tx-danger' : 'tx-success'}} lh-1 mg-t-20 d-inline-block"></i>
                <h4 class="{{$row->is_active == 1 ? 'tx-danger' : 'tx-success'}} tx-semibold mg-b-20">Yakin ingin
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
                        class="btn btn-light tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium mg-b-20"
                        data-dismiss="modal" aria-label="Close">Batal</button>
                    <button type="submit"
                        class="btn {{$row->is_active == 1 ? 'btn-danger' : 'btn-success'}} tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium mg-b-20">Ya,
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
