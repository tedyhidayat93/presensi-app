@extends('layouts.app_panel.app', $head)


@section('content')
<div class="section">
    <div class="section-header">
        <h1>Permohonan Izin Pegawai</h1>
    </div>


    <div class="row">
        <div class="col">
            <div class="card card-statistic-2">
                <div class="card-stats">
                  <div class="card-stats-title"></div>
                  <div class="card-stats-items">
                    <div class="card-stats-item">
                      <div class="card-stats-item-count text-primary">{{$total_all}}</div>
                      <div class="card-stats-item-label"> <i style="font-size: 10px;" class="fas fa-user"></i>&nbsp; Semua</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count text-warning">{{$total_menunggu}}</div>
                      <div class="card-stats-item-label"> <i style="font-size: 10px;" class="fas fa-user"></i>&nbsp; Menunggu Validasi</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count text-success">{{$total_disetujui}}</div>
                      <div class="card-stats-item-label"> <i style="font-size: 10px;" class="fas fa-user"></i>&nbsp; Disetujui</div>
                    </div>
                    <div class="card-stats-item">
                      <div class="card-stats-item-count text-danger">{{$total_ditolak}}</div>
                      <div class="card-stats-item-label"> <i style="font-size: 10px;" class="fas fa-user"></i>&nbsp; Ditolak</div>
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
                    <div class="card-body">
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
                                    <select name="jenis_izin_id" class="select2 form-control" >
                                        <option value="" selected disabled>-- Jenis Izin --</option>

                                            @if ($jenis_izin)
                                            @foreach ($jenis_izin as $j)
                                            <option value="{{$j->id}}">{{$j->type}}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                </div>
                                <div class="form-group mb-0 mr-1">
                                    <select name="created_by" class="select2 form-control" >
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
                                <button type="submit" class="btn btn-primary">
                                    <span class="">Filter</span>
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
                                        <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modaldemo{{$row->id}}">
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
   <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i
                    class="fa fa-question-circle text-100  {{$row->is_active == 1 ? 'text-danger' : 'text-success'}} lh-1 mg-t-20 d-inline-block"></i>
                <h4 class="{{$row->is_active == 1 ? 'text-danger' : 'text-success'}} font-weight-bold mg-b-20">Yakin Menyetujui Permohonan Izin ?
                </h4>
                <p class="mg-b-20 mg-x-20"><b>Alasan Izin : </b>  " {{$row->alasan ?? '-'}} "</p>
                <a href="{{route('adm.izin.acc', ['id' => $row->id, 'act' => 3])}}" class="btn btn-danger text-11 text-uppercase pd-y-12 pd-x-25 text-mont text-medium mg-b-20">Tolak</a>
                <a href="{{route('adm.izin.acc', ['id' => $row->id, 'act' => 2])}}" class="btn btn-success text-11 text-uppercase pd-y-12 pd-x-25 text-mont text-medium mg-b-20">Setujui</a>
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
