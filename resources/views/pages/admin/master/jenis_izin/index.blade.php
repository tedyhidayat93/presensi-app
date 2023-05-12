@extends('layouts.admin.app', $head)


@section('dynamic-content')
<div class="br-pagebody mg-t-5 pd-x-20 pd-b-200">

    <div class="row">
        
        <div class="col-12 col-md-5">
            <div class="card">
                @include('pages.admin.master.jenis_izin.form')
            </div>
        </div>
        <div class="col-12 col-md-7">
            <div class="widget-2">
                <div class="card shadow-base overflow-hidden">
                    <div class="card-body pd-15 bd-color-gray-lighter">
                        <table id="datatable1" class="table display nowrap">
                            <thead class="">
                                <tr>
                                    <th class="wd-10p">#</th>
                                    <th class="">Jenis Izin</th>
                                    <th class="wd-5p">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($data as $row) 
                                    <tr>
                                        <td>{{$i++}}.</td>
                                        <td>{{$row->type}}</td>
                                        <td>

                                            <a href="#" class="btn btn-danger btn-icon wd-35 ht-35" data-toggle="modal"
                                                data-target="#modaldemo{{$row->id}}">
                                                <div><i class="fa fa-trash"></i></div>
                                            </a>
                                            
                                            <a href="{{route('adm.master.edit.jenis_izin', $row->id)}}" class="btn btn-info btn-icon wd-35 ht-35 ">
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
                <i class="fa fa-question-circle tx-100 tx-danger lh-1 mg-t-20 d-inline-block"></i>
                <h4 class="tx-danger tx-semibold mg-b-20">Yakin ingin menghapus data ?
                </h4>
                <p class="mg-b-20 mg-x-20">Data <b> "{{$row->type}}" </b> akan dihapus dari database.</p>
                <form action="{{$route_delete}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{$row->id}}">
                    <button type="button" class="btn btn-light tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium mg-b-20" data-dismiss="modal" aria-label="Close">Batal</button>
                    <button type="submit" class="btn btn-danger tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium mg-b-20">Ya, Hapus</button>
                </form>
            </div><!-- modal-body -->
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
@endforeach


@endsection


@push('active-jenisIzin')
active
@endpush

@push('menuOpen-jenisIzin')
style="display: block;"
@endpush

@push('showSub-jenisIzin')
show-sub
@endpush

@push('styles')
@endpush

@push('scripts')
@endpush
