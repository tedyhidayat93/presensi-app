@extends('layouts.admin.app', $head)


@section('dynamic-content')
<div class="br-pagebody mg-t-5 pd-x-20 pd-b-200">

<div id="accordion" class="accordion" role="tablist" aria-multiselectable="true">
    <div class="card">
        <div class="card-header" role="tab" id="headingTwo">
          <h6 class="mg-b-0">
            <a class="collapsed tx-gray-100 bg-dark transition d-flex align-items-center justify-content-between" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <span>
                    Form Jadwal Lembur
                </span>
                <button class="btn btn-light p-1"><i class="fa fa-plus"></i> Buat Jadwal</button>
            </a>
          </h6>
        </div>
        <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
          <div class="card-block pd-20">
              <form action="{{route('adm.lembur.update')}}" method="POST">
                  @csrf
                  <div class="card p-3 border-0">
                      <div class="card-body p-0 border-0">
                          <div class="row">
                              <div class="col-12 col-md-6">
                                  <div class="form-group">
                                      <label for="">Nama Jadwal Lembur</label>
                                      <input class="form-control" type="text" name="nama_lembur" value="{{old('nama_lembur')}}" placeholder="Masukan Nama Jadwal Lembur">
                                  </div>
                              </div>
                              <div class="col-12 col-md-6">
                                  <div class="form-group">
                                      <label for="">Tanggal Lembur</label>
                                      <input class="form-control" type="date" name="berlaku_lembur" value="{{Carbon\Carbon::now()->toDateString()}}">
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                            <div class="col-12 col-md-6">
                                <div id="accordion" class="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="card" style="background-color: rgb(244, 244, 244);">
                                        <div class="card-header" role="tab" id="headingOne">
                                        <h6 class="mg-b-0">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#staff"
                                            aria-expanded="true" aria-controls="staff" class="tx-center tx-gray-800 transition">
                                            Karyawan Staff
                                            </a>
                                        </h6>
                                        </div><!-- card-header -->
                                    
                                        <div id="staff" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
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
                                            aria-expanded="true" aria-controls="non_staff" class="tx-center tx-gray-800 transition">
                                            Karyawan Non Staff
                                            </a>
                                        </h6>
                                        </div><!-- card-header -->
                                    
                                        <div id="non_staff" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
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
                      <div class="card-footer p-3 pt-2 border-0">
                          <button type="submit" class="btn btn-primary float-right">Buat Jadwal Lembur</button>
                      </div>
                  </div>
              </form>
          </div>
        </div>
      </div>
  
</div>

<div class="card mt-3">
    <div class="card-body">
        <table id="datatable1" class="table display nowrap">
            <thead class="">
                <tr>
                    <th class="wd-5p">#</th>
                    <th class="">Nama Jadwal Lembur</th>
                    <th class="">Untuk Tanggal</th>
                    <th class="">Jumlah Personil</th>
                    <th class="wd-10p">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i =1;
                @endphp
                @foreach ($data_lembur as $row)
                <tr>
                    <td>{{$i++}}.</td>
                    <td>{{$row->nama_lembur ?? '-'}}</td>
                    <td>{{ date('d F Y', strtotime($row->berlaku_lembur ?? '0000-00-00'))}}</td>
                    <td>{{ count($row->listAnggota) ?? 0}} Orang</td>
                    <td>
                        <a href="#" class="btn btn-danger " data-toggle="modal" data-target="#modaldemo{{$row->id}}">
                            <i class="fa fa-trash"></i> 
                        </a>
                        <a href="{{route('adm.lembur.edit', $row->id)}}" class="btn btn-info">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</div>

<!-- MODAL ALERT MESSAGE DELETE -->
@foreach ($data_lembur as $row)
<div id="modaldemo{{$row->id}}" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body tx-center pd-y-20 pd-x-20">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
                <i class="fa fa-question-circle tx-100  {{$row->is_active == 1 ? 'tx-danger' : 'tx-success'}} lh-1 mg-t-20 d-inline-block"></i>
                <h4 class="{{$row->is_active == 1 ? 'tx-danger' : 'tx-success'}} tx-semibold mg-b-20">Yakin ingin menghapus jadawal lembur ?
                </h4>
                <p class="mg-b-20 mg-x-20">Jadwal lembur <b> "{{$row->nama_lembur}}" </b> akan  dihapus.</p>
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
<script type="text/javascript">
    $(document).ready(function() {

      $('.delete-form').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $(this).data('route'),
            data: {
              '_method': 'delete'
            },
            success: function (response, textStatus, xhr) {
              alert(response)
            //   window.location='/posts'
            }
        });
      })
    });
  </script>
@endpush
