@extends('layouts.app_panel.app', $head)


@section('content')
<div class="section">

    <div class="row">
        
        {{-- <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-header bg-white pd-b-10">
                    <h6>Form Shift Waktu</h6>
                </div>
                @include('pages.admin.shift.form')
            </div>
        </div> --}}
        
        <div class="col-lg-4">
            <div class="card shadow-base bd-0">
              <div class="card-header bg-teal pd-20">
                <h6 class="card-title text-uppercase text-15 mg-b-0 text-white"><b>{{$shift->shift_name}}</b></h6>
              </div><!-- card-header -->
              <table class="table table-responsive mg-b-0 text-12">
                <thead>
                  <tr class="text-10">
                    <th class="wd-10p pd-y-5">&nbsp;</th>
                    <th class="pd-y-5">Hari</th>
                    <th class="pd-y-5">IN</th>
                    <th class="pd-y-5">OUT</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="pd-l-20">
                     <i class="icon ion-clock text-20"></i>
                    </td>
                    <td>
                      <a href="" class="text-inverse text-14 text-medium d-block">Senin</a>
                    </td>
                    <td class="text-13">
                      <span class="square-8 bg-success mg-r-5 rounded-circle"></span> {{$shift->senin_in ?? 'LIBUR'}}
                    </td>
                    <td class="text-13">
                      <span class="square-8 bg-danger mg-r-5 rounded-circle"></span> {{$shift->senin_out ?? 'LIBUR'}}
                    </td>
                  </tr>
                  <tr>
                    <td class="pd-l-20">
                     <i class="icon ion-clock text-20"></i>
                    </td>
                    <td>
                      <a href="" class="text-inverse text-14 text-medium d-block">Selasa</a>
                    </td>
                    <td class="text-13">
                      <span class="square-8 bg-success mg-r-5 rounded-circle"></span> {{$shift->selasa_in ?? 'LIBUR'}}
                    </td>
                    <td class="text-13">
                      <span class="square-8 bg-danger mg-r-5 rounded-circle"></span> {{$shift->selasa_out ?? 'LIBUR'}}
                    </td>
                  </tr>
                  <tr>
                    <td class="pd-l-20">
                     <i class="icon ion-clock text-20"></i>
                    </td>
                    <td>
                      <a href="" class="text-inverse text-14 text-medium d-block">Rabu</a>
                    </td>
                    <td class="text-13">
                      <span class="square-8 bg-success mg-r-5 rounded-circle"></span> {{$shift->rabu_in ?? 'LIBUR'}}
                    </td>
                    <td class="text-13">
                      <span class="square-8 bg-danger mg-r-5 rounded-circle"></span> {{$shift->rabu_out ?? 'LIBUR'}}
                    </td>
                  </tr>
                  <tr>
                    <td class="pd-l-20">
                     <i class="icon ion-clock text-20"></i>
                    </td>
                    <td>
                      <a href="" class="text-inverse text-14 text-medium d-block">Kamis</a>
                    </td>
                    <td class="text-13">
                      <span class="square-8 bg-success mg-r-5 rounded-circle"></span> {{$shift->kamis_in ?? 'LIBUR'}}
                    </td>
                    <td class="text-13">
                      <span class="square-8 bg-danger mg-r-5 rounded-circle"></span> {{$shift->kamis_out ?? 'LIBUR'}}
                    </td>
                  </tr>
                  <tr>
                    <td class="pd-l-20">
                     <i class="icon ion-clock text-20"></i>
                    </td>
                    <td>
                      <a href="" class="text-inverse text-14 text-medium d-block">Jumat</a>
                    </td>
                    <td class="text-13">
                      <span class="square-8 bg-success mg-r-5 rounded-circle"></span> {{$shift->jumat_in ?? 'LIBUR'}}
                    </td>
                    <td class="text-13">
                      <span class="square-8 bg-danger mg-r-5 rounded-circle"></span> {{$shift->jumat_out ?? 'LIBUR'}}
                    </td>
                  </tr>
                  <tr>
                    <td class="pd-l-20">
                     <i class="icon ion-clock text-20"></i>
                    </td>
                    <td>
                      <a href="" class="text-inverse text-14 text-medium d-block">Sabtu</a>
                    </td>
                    <td class="text-13">
                      <span class="square-8 bg-success mg-r-5 rounded-circle"></span> {{$shift->sabtu_in ?? 'LIBUR'}}
                    </td>
                    <td class="text-13">
                      <span class="square-8 bg-danger mg-r-5 rounded-circle"></span> {{$shift->sabtu_out ?? 'LIBUR'}}
                    </td>
                  </tr>
                  <tr>
                    <td class="pd-l-20">
                     <i class="icon ion-clock text-20"></i>
                    </td>
                    <td>
                      <a href="" class="text-inverse text-14 text-medium d-block">Minggu</a>
                    </td>
                    <td class="text-13">
                      <span class="square-8 bg-success mg-r-5 rounded-circle"></span> {{$shift->minggu_in ?? 'LIBUR'}}
                    </td>
                    <td class="text-13">
                      <span class="square-8 bg-danger mg-r-5 rounded-circle"></span> {{$shift->minggu_out ?? 'LIBUR'}}
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="card-footer text-12 pd-y-15 bg-transparent">
                <a href="{{route('adm.shift')}}"><i class="fa fa-arrow-right mg-r-5"></i>Atur Shift Lainnya</a>
              </div><!-- card-footer -->
            </div><!-- card -->
          </div><!-- col-6 -->


        <div class="col-12 col-md-8">
            <div class="widget-2">
                <div class="card shadow-base overflow-hidden">
                    <div class="card-header bg-transparent pd-5 text-center">
                        <h6 class="card-title text-uppercase text-30 mg-b-0">List Karyawan {{$shift->shift_name}}</h6>
                        <a href="" class="btn btn-success text-11 text-uppercase pd-y-12 pd-x-25 text-mont text-medium" data-toggle="modal" data-target="#modalEmployee"><i class="icon ion-person-stalker text-15 mg-r-10"></i> Pilih Karyawan</a>
                    </div>
                    <div class="card-body pd-15 bd-color-gray-lighter">
                        <table id="datatable1" class="table display nowrap">
                            <thead class="">
                                <tr>
                                    <th class="wd-10p">#</th>
                                    <th class="">Nama Karyawan</th>
                                    <th class="">Jabatan</th>
                                    <th class="">Tanggal Register</th>
                                    <th class="">Shift</th>
                                    <th class="wd-10">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($users as $row) 
                                    <tr>
                                        <td>{{$i++}}.</td>
                                        <td>{{$row->user->full_name}}</td>
                                        <td>{{$row->user->jabatan->type}}</td>
                                        <td>{{ date('d-m-Y',  strtotime($row->user->registered_at))}}</td>
                                        <td>{{$shift->shift_name}}</td>
                                        <td>
                                            <a href="#" class="btn btn-danger btn-icon wd-35 ht-35" data-toggle="modal"
                                            data-target="#modaldemo{{$row->id}}">
                                            <div><i class="fa fa-trash"></i></div>
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

        @foreach ($users as $row)
        <div id="modaldemo{{$row->id}}" class="modal fade">
           <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            {{-- <span aria-hidden="true">&times;</span> --}}
                        </button>
                        <i class="fas fa-question-circle text-danger d-inline-block mb-4" style="font-size:40px;"></i>
                        <h4 class="text-danger font-weight-bold mg-b-20">Yakin ingin menghapus dari {{$shift->shift_name}} ?
                        </h4>
                        <p class="mg-b-20 mg-x-20">Karyawan <b> "{{$row->user->full_name}}" </b> akan dihapus dari shift ini.</p>
                        <form action="{{route('adm.delete.shift.user')}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="shift_id" value="{{$shift->id}}">
                            <input type="hidden" name="id" value="{{$row->id}}">
                            <button type="button" class="btn btn-light text-11 text-uppercase pd-y-12 pd-x-25 text-mont text-medium mg-b-20" data-dismiss="modal" aria-label="Close">Batal</button>
                            <button type="submit" class="btn btn-danger text-11 text-uppercase pd-y-12 pd-x-25 text-mont text-medium mg-b-20">Ya, Hapus</button>
                        </form>
                    </div><!-- modal-body -->
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- modal -->
        @endforeach  


    <form action="{{route('adm.store.shift.users')}}" method="POST">
        @csrf
        <input type="hidden" name="shift_id" value="{{$shift->id}}">
        <div id="modalEmployee" class="modal fade">
            <div class="modal-dialog modal-lg w-100" role="document">
              <div class="modal-content">
                <div class="modal-header pd-x-20">
                  <h6 class="text-14 mg-b-0 text-uppercase text-inverse text-bold">Pilih Karyawan</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body pd-20">
                    {{-- <table id="datatable4" class=" table display nowrap"> --}}
                    <table id="" class=" table display nowrap">
                        <thead class="">
                            <tr>
                                <th class="wd-10p">#</th>
                                <th class="">Nama Karyawan</th>
                                <th class="">Jabatan</th>
                                <th class="">Tanggal Register</th>
                                <th class="wd-5p">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach ($users_shift as $row) 
                                <tr>
                                    <td>{{$i++}}.</td>
                                    <td>{{$row->full_name}}</td>
                                    <td>{{$row->jabatan->type ?? '-'}}</td>
                                    <td>{{ date('d-m-Y', strtotime($row->registered_at))}}</td>
                                    <td>

                                        <label class="ckbox">
                                            <input type="checkbox" value="{{$row->id}}" name="user_id[]">
                                            <span>Pilih</span>
                                          </label>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- modal-body -->
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-size-xs" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-success text-size-xs">Jadwalkan</button>
                </div>
              </div>
            </div><!-- modal-dialog -->
          </div>
        </div>
    </form>

</div>


<!-- MODAL ALERT MESSAGE DELETE -->


@endsection


@push('active-shift')
active
@endpush

@push('menuOpen-shift')
style="display: block;"
@endpush

@push('showSub-shift')
show-sub
@endpush

@push('styles')
@endpush

@push('scripts')
<script>
    $('#datatable4').DataTable({
        responsive: false,
        bLengthChange: false,
        pageLength: 1000,
        language: {
                    searchPlaceholder: 'Cari Karyawan...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
    });
</script>
@endpush
