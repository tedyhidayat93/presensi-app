@extends('layouts.admin.app', $head)


@section('dynamic-content')
<div class="br-pagebody mg-t-5 pd-x-20 pd-b-200">

    <div class="row row-sm mb-3">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-dark rounded overflow-hidden">
                <div class="pd-10 d-flex align-items-center">
                    <i class="ion ion-bookmark tx-30 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Total Semua
                        </p>
                        <p class="tx-18 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_all}}</p>
                        <span class="tx-11 tx-roboto tx-white-6">Izin</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-warning rounded overflow-hidden">
                <div class="pd-10 d-flex align-items-center">
                    <i class="ion ion-bookmark tx-30 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Menunggu Validasi
                        </p>
                        <p class="tx-18 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_menunggu}}</p>
                        <span class="tx-11 tx-roboto tx-white-6">Izin</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-success rounded overflow-hidden">
                <div class="pd-10 d-flex align-items-center">
                    <i class="ion ion-bookmark tx-30 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Disetujui
                        </p>
                        <p class="tx-18 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_disetujui}}</p>
                        <span class="tx-11 tx-roboto tx-white-6">Izin</span>
                    </div>
                </div>
            </div>
        </div><!-- col-3 -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-danger rounded overflow-hidden">
                <div class="pd-10 d-flex align-items-center">
                    <i class="ion ion-bookmark tx-30 lh-0 tx-white op-7"></i>
                    <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-medium tx-uppercase tx-white-8 mg-b-10">Ditolak
                        </p>
                        <p class="tx-18 tx-white tx-lato tx-bold mg-b-2 lh-1">{{$total_ditolak}}</p>
                        <span class="tx-11 tx-roboto tx-white-6">Izin</span>
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
                        <div>
                            <form action="" method="get" class="d-block d-md-flex align-item-center">
                                <div class="form-group mb-0 mr-1">
                                    <select name="status" class="form-control" >
                                        <option value="" selected>-- Status --</option>
                                        <option value="1">Menunggu</option>
                                        <option value="2">Disetujui</option>
                                        <option value="3">Ditolak</option>
                                    </select>
                                </div>
                                <div class="form-group mb-0 mr-1">
                                    <select name="jenis_izin_id" class="selecttu form-control" >
                                        <option value="" selected disabled>-- Jenis Izin --</option>

                                            @if ($jenis_izin)
                                            @foreach ($jenis_izin as $j)
                                            <option value="{{$j->id}}">{{$j->type}}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                </div>
                                <div class="form-group mb-0 mr-1">
                                    <select name="created_by" class="selecttu form-control" >
                                        <option value="" selected disabled>-- Karyawan --</option>
                                        @if ($users)
                                        @foreach ($users as $j)
                                        <option value="{{$j->id}}">{{$j->full_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group mb-0 mr-1">
                                    <input type="text" placeholder="Dari Tanggal" onfocus="(this.type='date')" name="from" class="form-control" id="">
                                </div>
                                <div class="form-group mb-0 mr-1">
                                    <input type="text" placeholder="Sampai Tanggal" onfocus="(this.type='date')" name="to" class="form-control" id="">
                                </div>
                                <button type="submit" class="btn btn-outline-teal text-teal btn-sm ht-40">
                                    <span class="pd-x-5">Filter</span>
                                </button>
                                
                            </form>
                        </div>
                    </div><!-- card-header -->
                    <div class="card-body pd-15 bd-color-gray-lighter table-responsive overflow-auto">
                        @if (request()->query('status') || request()->query('jenis_izin_id') || request()->query('created_by') || request()->query('from') || request()->query('to') )
                        <p class="mb-0">
                            <b>Filter By : </b>
                            
                            @if (request()->query('status') == '3')
                                Ditolak
                            @elseif (request()->query('status') == '2')
                                Disetujui
                            @elseif (request()->query('status') == '1')
                                Menunggu
                            @endif

                            @if (request()->query('jenis_izin_id'))
                                {{$nama_jenis_izin}}, 
                            @endif
                            
                            @if (request()->query('created_by'))
                                {{$nama_user}},  
                            @endif


                            

                            <a href="{{route('adm.izin')}}" class="ml-2 text-danger"><small>&times; Reset Filter</small> </a>
                        </p>
                        @if (request()->query('from') != '' || request()->query('to') != '') 
                        <p class="mt-1">
                            <small> <b> {{date('d/m/Y', strtotime(request()->query('from')))}}</b> sampai <b> {{date('d/m/Y', strtotime(request()->query('to')))}}</b> </small>
                        </p>
                        @endif
                        @endif
                        <table id="datatable1" class="table display nowrap">
                            <thead class="">
                                <tr>
                                    <th class="wd-5p">#</th>
                                    <th class="">Foto</th>
                                    <th class="">Nama Lengkap</th>
                                    <th class="">Jenis Izin</th>
                                    <th class="">Alasan</th>
                                    <th class="">Dokumen</th>
                                    <th class="">Tanggal</th>
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
                                            src="{{ asset('uploads/images/employee/'. $row->user->photo_profile) }}">
                                        @else
                                        <img width="50" src="{{ asset('images/default-ava.jpg') }}"> 
                                        @endif
                                    </td>
                                    <td>{{$row->user->full_name ?? '-'}}</td>
                                    <td>{{$row->jenis->type ?? '-'}}</td>
                                    <td>{{Str::limit($row->alasan, 35, '...') ?? '-'}} <a href="{{route('adm.izin.detail', $row->id)}}"><small> (selengkapnya) </small></a> </td>
                                    <td>
                                        @if ($row->dokumen !== null)
                                            <a href="{{ asset('uploads/izin/'. $row->dokumen ) }}" target="_blank">Buka Dokumen</a>
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>{{ date('d-M-Y | H:i', strtotime($row->created_at ?? '0000-00-00'))}}</td>
                                    <td>
                                        @if($row->is_approve == 2)
                                        <span class="badge badge-success">Disetujui</span>
                                        @elseif($row->is_approve == 3)
                                        <span class="badge badge-danger">Ditolak</span>
                                        @elseif($row->is_approve == 1)
                                        <span class="badge badge-warning text-white">Belum Di Acc</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->is_approve == 1)
                                        <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modaldemo{{$row->id}}">
                                            <div><i class="fa fa-check }} "></i></div>
                                        </a>
                                        @endif
                                        <a href="{{route('adm.izin.detail', $row->id)}}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
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


<!-- MODAL ALERT MESSAGE DELETE -->
@foreach ($data as $row)
<div id="modaldemo{{$row->id}}" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i
                    class="fa fa-question-circle tx-100  {{$row->is_active == 1 ? 'tx-danger' : 'tx-success'}} lh-1 mg-t-20 d-inline-block"></i>
                <h4 class="{{$row->is_active == 1 ? 'tx-danger' : 'tx-success'}} tx-semibold mg-b-20">Yakin Menyetujui Permohonan Izin ?
                </h4>
                <p class="mg-b-20 mg-x-20"><b>Alasan Izin : </b>  " {{$row->alasan ?? '-'}} "</p>
                <a href="{{route('adm.izin.acc', ['id' => $row->id, 'act' => 3])}}" class="btn btn-danger tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium mg-b-20">Tolak</a>
                <a href="{{route('adm.izin.acc', ['id' => $row->id, 'act' => 2])}}" class="btn btn-success tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium mg-b-20">Setujui</a>
            </div><!-- modal-body -->
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
@endforeach

@endsection


@push('active-izin')
active
@endpush

@push('menuOpen-izin')
style="display: block;"
@endpush

@push('showSub-izin')
show-sub
@endpush

@push('styles')
@endpush

@push('scripts')
@endpush
