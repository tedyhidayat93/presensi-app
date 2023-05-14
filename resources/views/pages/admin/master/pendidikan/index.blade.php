@extends('layouts.app_panel.app', $head)


@section('content')
<div class="section">
    <div class="section-header">
        <h1> {{$head['head_title_per_page'] ?? 'Title' }}</h1>
    </div>
    <div class="row">
        
        <div class="col-12 col-md-5">
            <div class="card">
                @include('pages.admin.master.pendidikan.form')
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
                                    <th class="">Nama Jenjang</th>
                                    <th class="wd-5p">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($data as $row) 
                                    <tr>
                                        <td>{{$i++}}.</td>
                                        <td>{{$row->education}}</td>
                                        <td>

                                            <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#modaldemo{{$row->id}}">
                                                <div><i class="fa fa-trash"></i></div>
                                            </a>
                                            
                                            <a href="{{route('adm.master.edit.pendidikan', $row->id)}}" class="btn btn-info btn-sm ">
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
                <i class="fas fa-question-circle text-danger d-inline-block mb-4" style="font-size:35px;"></i>
                <h4 class="text-danger font-weight-bold mg-b-20">Yakin ingin menghapus data ?
                </h4>
                <p class="mg-b-20 mg-x-20">Data <b> "{{$row->education}}" </b> akan dihapus dari database.</p>
                <form action="{{$route_delete}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="{{$row->id}}">
                    <button type="button" class="btn btn-light text-11 text-uppercase pd-y-12 pd-x-25 text-mont text-medium mg-b-20" data-dismiss="modal" aria-label="Close">Batal</button>
                    <button type="submit" class="btn btn-danger text-11 text-uppercase pd-y-12 pd-x-25 text-mont text-medium mg-b-20">Ya, Hapus</button>
                </form>
            </div><!-- modal-body -->
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
@endforeach


@endsection


@push('active-masterPendidikan')
active
@endpush

@push('menuOpen-masterPendidikan')
style="display: block;"
@endpush

@push('showSub-masterPendidikan')
show-sub
@endpush

@push('styles')
@endpush

@push('scripts')
@endpush
