@extends('layouts.admin.app', $head)


@section('dynamic-content')
<div class="br-pagebody mg-t-5 pd-x-20 pd-b-200">

    <div class="row">
        <div class="col">
            <div class="widget-2">
                <div class="card shadow-base overflow-hidden">
                    <div class="card-header">
                        <h6 class="card-title"></h6>
                        <div>
                            <a href="{{$route_create}}"
                                class="btn btn-teal btn-sm btn-with-icon">
                                <div class="ht-40">
                                    <span class="icon wd-40"><i class="fa fa-plus"></i></span>
                                    <span class="pd-x-15">Tambah User Admin</span>
                                </div>
                            </a>
                        </div>
                    </div><!-- card-header -->
                    <div class="card-body pd-15 bd-color-gray-lighter">
                        <table id="datatable1" class="table display nowrap">
                            <thead class="">
                                <tr>
                                    <th class="wd-5p">#</th>
                                    <th class="">Foto</th>
                                    <th class="">Nama Lengkap</th>
                                    <th class="">Username</th>
                                    <th class="">Email</th>
                                    <th class="">Tanggal Register</th>
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
                                            <img width="50" src="{{ asset('uploads/images/admin/'. $row->photo_profile) }}"> 
                                            @else
                                            <img width="50" src="{{ asset('images/default-ava.jpg') }}"> 
                                            @endif 
                                        </td>
                                        <td>{{$row->full_name}}</td>
                                        <td>{{$row->username}}</td>
                                        <td>{{$row->email}}</td>
                                        <td>{{ date('d F Y', strtotime($row->registered_at))}}</td>
                                        <td>{!!$row->is_active == 1 ? '<span class="badge badge-success">Aktif</span>':'<span class="badge badge-danger">Non Aktif</span>' !!}</td>
                                        <td>

                                            <a href="#" class="btn btn-{{$row->is_active == 1 ? 'danger':'success' }} btn-icon wd-35 ht-35" data-toggle="modal"
                                            data-target="#modaldemo{{$row->id}}">
                                                <div><i class="fa {{$row->is_active == 1 ? 'fa-toggle-on':'fa-toggle-off' }} "></i></div>
                                            </a>
                                            
                                            <a href="{{route('adm.users.edit', $row->id)}}" class="btn btn-info btn-icon wd-35 ht-35 ">
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


<!-- MODAL ALERT MESSAGE DELETE -->
@foreach ($data as $row)
<div id="modaldemo{{$row->id}}" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
                <i class="fa fa-question-circle tx-100  {{$row->is_active == 1 ? 'tx-danger' : 'tx-success'}} lh-1 mg-t-20 d-inline-block"></i>
                <h4 class="{{$row->is_active == 1 ? 'tx-danger' : 'tx-success'}} tx-semibold mg-b-20">Yakin ingin {{$row->is_active == 1 ? 'me-nonaktifkan' : 'meng-aktifkan'}} User ?
                </h4>
                <p class="mg-b-20 mg-x-20">User <b> "{{$row->full_name}}" </b> akan  {{$row->is_active == 1 ? 'non-aktif' : 'aktif'}}.</p>
                <form action="{{$route_delete}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{$row->id}}">
                    <input type="hidden" name="is_active" value="{{$row->is_active == 1 ? 0 : 1}}">
                    <button type="button" class="btn btn-light tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium mg-b-20" data-dismiss="modal" aria-label="Close">Batal</button>
                    <button type="submit" class="btn {{$row->is_active == 1 ? 'btn-danger' : 'btn-success'}} tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium mg-b-20">Ya, {{$row->is_active == 1 ? 'Non-Aktifkan' : 'Aktifkan'}}</button>
                </form>
            </div><!-- modal-body -->
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
@endforeach

@endsection


@push('active-users')
active
@endpush

@push('menuOpen-users')
style="display: block;"
@endpush

@push('showSub-users')
show-sub
@endpush

@push('styles')
@endpush

@push('scripts')
@endpush
