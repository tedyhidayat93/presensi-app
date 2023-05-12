@extends('layouts.app_panel.app', $head)


@section('content')
<div class="section">


    <form action="{{route('adm.lembur.update.detail')}}" method="POST">
        @csrf
        @method('PUT')
        <input class="form-control" type="hidden" name="jadwal_id" value="{{$edit->id}}" >
        <div class="card ">
            <div class="card-body ">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Nama Jadwal Lembur</label>
                            <input class="form-control" type="text" name="nama_lembur" value="{{old('nama_lembur') ?? $edit->nama_lembur}}" placeholder="Masukan Nama Jadwal Lembur">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="">Tanggal Lembur</label>
                            <input class="form-control" type="date" name="berlaku_lembur" value="{{date('Y-m-d', strtotime($edit->berlaku_lembur))}}">
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header">
                        <h6 class="text-center mb-0">List Personil Lembur</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="p-2" style="background-color: #f2f2f2; max-height: 600px; overflow:auto;">
                                    <table class="table table-hover">
                                        <tr>
                                            <th colspan="5" class="text-center">STAFF</th>
                                        </tr>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>Nama</th>
                                            <th>Tipe</th>
                                            <th>Jabatan</th>
                                            <th><span class="float-right"> #</span></th>
                                        </tr>
                                        @php
                                            $no=1;
                                        @endphp
                                        @foreach ($edit->listAnggota as $r)
                                        @if ($r->user->type == 'staff')
                                        <tr>
                                            <th>{{$no++}}.</th>
                                            <th>{{$r->user->full_name}}</th>
                                            <th>{{$r->user->type  == 'staff' ? 'STAFF' : 'NON STAFF'}}</th>
                                            <th>{{$r->user->jabatan->type ?? '-'}}</th>
                                            <td>
                                                <a href="{{route('adm.lembur.delete.personil', $r->id)}}" class="float-right btn btn-danger p-1"><i class="fa fa-trash"></i> Hapus</a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="p-2" style="background-color:  #f2f2f2; max-height: 600px; overflow:auto;">
                                    <table class="table table-hover">
                                        <tr>
                                            <th colspan="5" class="text-center">NON STAFF</th>
                                        </tr>
                                        <tr>
                                            <th width="50">No</th>
                                            <th>Nama</th>
                                            <th>Tipe</th>
                                            <th>Jabatan</th>
                                            <th><span class="float-right"> #</span></th>
                                        </tr>
                                        @php
                                            $no=1;
                                        @endphp
                                        @foreach ($edit->listAnggota as $r)
                                        @if ($r->user->type == 'non_staff')
                                        <tr>
                                            <th>{{$no++}}.</th>
                                            <th>{{$r->user->full_name}}</th>
                                            <th>{{$r->user->type  == 'staff' ? 'STAFF' : 'NON STAFF'}}</th>
                                            <th>{{$r->user->jabatan->type ?? '-'}}</th>
                                            <td>
                                                <a href="{{route('adm.lembur.delete.personil', $r->id)}}" class="float-right btn btn-danger p-1"><i class="fa fa-trash"></i> Hapus</a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12 col-md-6">
                        <div id="accordion" class="accordion" role="tablist" aria-multiselectable="true">
                            <div class="card" style="background-color: rgb(244, 244, 244);">
                                <div class="card-header" role="tab" id="headingOne">
                                <h6 class="mg-b-0">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#staff"
                                    aria-expanded="true" aria-controls="staff" class="collapsed text-center text-gray-800 transition">
                                    <i class="fa fa-user-plus"></i> Tambah Karyawan Staff
                                    </a>
                                </h6>
                                </div><!-- card-header -->
                            
                                <div id="staff" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="card-block pd-20" style="max-height: 400px; overflow:auto;">
                                        <table class="table table-hover">
                                            <tr>
                                                <th width="50">No</th>
                                                <th>Nama</th>
                                                <th>Jabatan</th>
                                                <th><span class="float-right"> #</span></th>
                                            </tr>
                                            @php
                                                $no=1;
                                            @endphp
                                            @foreach ($data as $r)
                                            @if ($r->type === 'staff')
                                            <tr>
                                                <th>{{$no++}}.</th>
                                                <th>{{$r->full_name}}</th>
                                                <th>{{$r->jabatan->type ?? '-'}}</th>
                                                <td>
                                                    <div class="form-group float-right">
                                                        <input type="checkbox" name="usrid[]" value="{{$r->id}}" class="form-control">
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        </table>
                                </div>
                                </div>
                            </div><!-- card -->
                            <!-- ADD MORE CARD HERE -->
                            </div><!-- accordion -->
                    </div>
                    <div class="col-12 col-md-6">
                        <div id="accordion" class="accordion" role="tablist" aria-multiselectable="true">
                            <div class="card" style="background-color: rgb(244, 244, 244);;">
                                <div class="card-header" role="tab" id="headingOne">
                                <h6 class="mg-b-0">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#non_staff"
                                    aria-expanded="true" aria-controls="non_staff" class="collapsed text-center text-gray-800 transition">
                                    <i class="fa fa-user-plus"></i> Tambah Karyawan Non Staff
                                    </a>
                                </h6>
                                </div><!-- card-header -->
                            
                                <div id="non_staff" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="card-block pd-20" style="max-height: 400px; overflow:auto;">
                                        <table class="table table-hover">
                                            <tr>
                                                <th width="50">No</th>
                                                <th>Nama</th>
                                                <th>Jabatan</th>
                                                <th><span class="float-right"> #</span></th>
                                            </tr>
                                            @php
                                                $no=1;
                                            @endphp
                                            @foreach ($data as $r)
                                            @if ($r->type === 'non_staff')
                                            <tr>
                                                <th>{{$no++}}.</th>
                                                <th>{{$r->full_name}}</th>
                                                <th>{{$r->jabatan->type ?? '-'}}</th>
                                                <td>
                                                    <div class="form-group float-right">
                                                        <input type="checkbox" name="usrid[]" value="{{$r->id}}" class="form-control">
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                        </table>
                                </div>
                                </div>
                            </div><!-- card -->
                            <!-- ADD MORE CARD HERE -->
                            </div><!-- accordion -->
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success float-right">Update Jadwal</button>
                <a href="{{route('adm.lembur')}}" class="btn btn-light float-right mr-2">Kembali</a>
            </div>
        </div>
    </form>

</div>


@endsection


@push('active-lembur')
active
@endpush

@push('menuOpen-lembur')
style="display: block;"
@endpush

@push('showSub-lembur')
show-sub
@endpush

@push('styles')
@endpush

@push('scripts')

@endpush
