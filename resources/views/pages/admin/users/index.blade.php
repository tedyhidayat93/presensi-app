@extends('layouts.app_panel.app', $head)


@section('content')
<div class="section">
    <div class="section-header">
        <h1> {{$head['head_title_per_page'] ?? 'Title' }}</h1>
    </div>
    <div class="row">
        <div class="col">
            <div class="widget-2">
                <div class="card shadow-base overflow-hidden">
                    <div class="card-body d-md-flex justify-content-lg-between">
                        <h6 class="card-title">List Data</h6>
                        <div class="float-right">
                            <a href="{{$route_create}}"
                                class="btn btn-primary btn-sm">
                                <div class="ht-40">
                                    <span class="icon wd-40"><i class="fa fa-plus"></i></span>
                                    <span class="pd-x-15">Tambah Admin</span>
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
                                            <img width="35" src="{{ asset('uploads/images/admin/'. $row->photo_profile) }}"> 
                                            @else
                                            <img width="35" class="rounded-circle" src="{{ asset('images/default-ava.jpg') }}"> 
                                            @endif 
                                        </td>
                                        <td>{{$row->full_name}}</td>
                                        <td>{{$row->username}}</td>
                                        <td>{{$row->email}}</td>
                                        <td>{{ date('d F Y', strtotime($row->registered_at))}}</td>
                                        <td>{!!$row->is_active == 1 ? '<span class="badge badge-success">Aktif</span>':'<span class="badge badge-danger">Non Aktif</span>' !!}</td>
                                        <td>

                                            <a href="#" class="btn btn-{{$row->is_active == 1 ? 'danger':'success' }} btn-sm" data-toggle="modal"
                                            data-target="#modaldemo{{$row->id}}">
                                                <div><i class="fa {{$row->is_active == 1 ? 'fa-toggle-on':'fa-toggle-off' }} "></i></div>
                                            </a>
                                            
                                            <a href="{{route('adm.users.edit', $row->id)}}" class="btn btn-info btn-sm ">
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
   <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
                <i class="fa fa-question-circle  {{$row->is_active == 1 ? 'text-danger' : 'text-success'}} d-inline-block mb-4" style="font-size: 35px;"></i>
                <h4 class="{{$row->is_active == 1 ? 'text-danger' : 'text-success'}} font-weight-bold ">Yakin ingin {{$row->is_active == 1 ? 'me-nonaktifkan' : 'meng-aktifkan'}} User ?
                </h4>
                <p class="">User <b> "{{$row->full_name}}" </b> akan  {{$row->is_active == 1 ? 'non-aktif' : 'aktif'}}.</p>
                <form action="{{$route_delete}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{$row->id}}">
                    <input type="hidden" name="is_active" value="{{$row->is_active == 1 ? 0 : 1}}">
                    <button type="button" class="btn btn-light text-11 text-uppercase pd-y-12 pd-x-25 text-mont text-medium " data-dismiss="modal" aria-label="Close">Batal</button>
                    <button type="submit" class="btn {{$row->is_active == 1 ? 'btn-danger' : 'btn-success'}} text-11 text-uppercase pd-y-12 pd-x-25 text-mont text-medium ">Ya, {{$row->is_active == 1 ? 'Non-Aktifkan' : 'Aktifkan'}}</button>
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
