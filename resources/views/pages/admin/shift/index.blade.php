@extends('layouts.app_panel.app', $head)


@section('content')
<div class="section">
    <div class="section-header">
        <h1>Waktu Kerja</h1>
      </div>
    <div class="row">
        
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header bg-white pd-b-10">
                    <h6>Form Jam Kerja</h6>
                </div>
                @include('pages.admin.shift.form')
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="widget-2">
                <div class="card shadow-base overflow-hidden">
                    <div class="card-header pd-15 bd-color-gray-lighter">
                        <h6>Data Jam</h6>
                    </div>
                    <div class="card-body pd-15 bd-color-gray-lighter">
                        <table id="datatable1" class="table display nowrap">
                            <thead class="">
                                <tr>
                                    <th class="wd-10p">#</th>
                                    <th class="">Nama Jam Kerja</th>
                                    <th class="">Jam</th>
                                    {{-- <th class="">Jumlah Karyawan</th> --}}
                                    <th class="wd-5p">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($data as $row) 
                                    <tr>
                                        <td>{{$i++}}.</td>
                                        <td>{{$row->shift_name}}</td>
                                        <td>
                                            <span class="text-info mg-b-10"> Senin </span> <br>
                                            @if ($row->senin_in == null && $row->senin_out == null)
                                                <span class="badge badge-danger"><b>LIBUR</b></span><br>
                                            @else
                                                IN <b> {{ $row->senin_in ?? 'libur'}} -- OUT {{$row->senin_out ?? 'libur'}} </b> <br>
                                            @endif

                                            <span class="text-info mg-b-10"> Selasa </span> <br>
                                            @if ($row->selasa_in == null && $row->selasa_out == null)
                                                <span class="badge badge-danger"><b>LIBUR</b></span><br>
                                            @else
                                                IN <b> {{ $row->selasa_in ?? 'libur'}} -- OUT {{$row->selasa_out ?? 'libur'}} </b> <br>
                                            @endif

                                            <span class="text-info mg-b-10"> Rabu </span> <br>
                                            @if ($row->rabu_in == null && $row->rabu_out == null)
                                                <span class="badge badge-danger"><b>LIBUR</b></span><br>
                                            @else
                                                IN <b> {{ $row->rabu_in ?? 'libur'}} -- OUT {{$row->rabu_out ?? 'libur'}} </b> <br>
                                            @endif

                                            <span class="text-info mg-b-10"> Kamis </span> <br>
                                            @if ($row->kamis_in == null && $row->kamis_out == null)
                                                <span class="badge badge-danger"><b>LIBUR</b></span><br>
                                            @else
                                                IN <b> {{ $row->kamis_in ?? 'libur'}} -- OUT {{$row->kamis_out ?? 'libur'}} </b> <br>
                                            @endif

                                            <span class="text-info mg-b-10"> Jumat </span> <br>
                                            @if ($row->jumat_in == null && $row->jumat_out == null)
                                                <span class="badge badge-danger"><b>LIBUR</b></span><br>
                                            @else
                                                IN <b> {{ $row->jumat_in ?? 'libur'}} -- OUT {{$row->jumat_out ?? 'libur'}} </b> <br>
                                            @endif

                                            <span class="text-info mg-b-10"> Sabtu </span> <br>
                                            @if ($row->sabtu_in == null && $row->sabtu_out == null)
                                                <span class="badge badge-danger"><b>LIBUR</b></span><br>
                                            @else
                                                IN <b> {{ $row->sabtu_in ?? 'libur'}} -- OUT {{$row->sabtu_out ?? 'libur'}} </b> <br>
                                            @endif

                                            <span class="text-info mg-b-10"> Minggu </span> <br>
                                            @if ($row->minggu_in == null && $row->minggu_out == null)
                                                <span class="badge badge-danger"><b>LIBUR</b></span><br>
                                            @else
                                                IN <b> {{ $row->minggu_in ?? 'libur'}} -- OUT {{$row->minggu_out ?? 'libur'}} </b> <br>
                                            @endif

                                        </td>
                                        {{-- <td> <span class="text-18 font-weight-bold"> {{ count( $row->karyawan ) }} </span> Karyawan</td> --}}
                                        <td>

                                            {{-- <a href="{{route('adm.setting.shift', $row->id)}}" class="btn btn-dark btn-icon wd-35 ht-35 ">
                                                <div><i class="icon ion-person-stalker"></i></div>
                                            </a> --}}

                                            {{-- <a href="#" class="btn btn-danger btn-icon wd-35 ht-35" data-toggle="modal"
                                                data-target="#modaldemo{{$row->id}}">
                                                <div><i class="fa fa-trash"></i></div>
                                            </a> --}}
                                            
                                            <a href="{{route('adm.edit.shift', $row->id)}}" class="btn btn-info btn-icon wd-35 ht-35 ">
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
                <i class="fas fa-question-circle text-danger d-inline-block mb-4" style="font-size:40px;"></i>
                <h4 class="text-danger font-weight-bold mg-b-20">Yakin ingin menghapus data ?
                </h4>
                <p class="mg-b-20 mg-x-20">Data <b> "{{$row->type}}" </b> akan dihapus dari database.</p>
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
    $(document).ready(function() {
        var senin_in = $('input[name=senin_in]');
        var senin_out = $('input[name=senin_out]');
        var selasa_in = $('input[name=selasa_in]');
        var selasa_out = $('input[name=selasa_out]');
        var rabu_in = $('input[name=rabu_in]');
        var rabu_out = $('input[name=rabu_out]');
        var kamis_in = $('input[name=kamis_in]');
        var kamis_out = $('input[name=kamis_out]');
        var jumat_in = $('input[name=jumat_in]');
        var jumat_out = $('input[name=jumat_out]');
        var sabtu_in = $('input[name=sabtu_in]');
        var sabtu_out = $('input[name=sabtu_out]');
        var minggu_in = $('input[name=minggu_in]');
        var minggu_out = $('input[name=minggu_out]');
        
        var is_libur_senin = $('input[name=is_libur_senin]');
        var is_libur_selasa = $('input[name=is_libur_selasa]');
        var is_libur_rabu = $('input[name=is_libur_rabu]');
        var is_libur_kamis = $('input[name=is_libur_kamis]');
        var is_libur_jumat = $('input[name=is_libur_jumat]');
        var is_libur_sabtu = $('input[name=is_libur_sabtu]');
        var is_libur_minggu = $('input[name=is_libur_minggu]');


        
        // senin_in.prop('disabled', true);
        // senin_out.prop('disabled', true);
        // selasa_in.prop('disabled', true);
        // selasa_out.prop('disabled', true);
        // rabu_in.prop('disabled', true);
        // rabu_out.prop('disabled', true);
        // kamis_in.prop('disabled', true);
        // kamis_out.prop('disabled', true);
        // jumat_in.prop('disabled', true);
        // jumat_out.prop('disabled', true);
        // sabtu_in.prop('disabled', true);
        // sabtu_out.prop('disabled', true);
        // minggu_in.prop('disabled', true);
        // minggu_out.prop('disabled', true);
        
        
        is_libur_senin.change(function(){
            senin_in.val('');
            senin_out.val('');
            senin_in.removeAttr('disabled');
            senin_out.removeAttr('disabled');
            if(is_libur_senin.filter(':checked').val() == 'masuk') 
            {
                senin_in.prop('disabled', false);
                senin_out.prop('disabled', false);
            } 
            else
            {
                senin_in.prop('disabled', true);
                senin_out.prop('disabled', true);
            }
        });

        is_libur_selasa.change(function(){
            selasa_in.val('');
            selasa_out.val('');
            selasa_in.removeAttr('disabled');
            selasa_out.removeAttr('disabled');
            if(is_libur_selasa.filter(':checked').val() == 'masuk') 
            {
                selasa_in.prop('disabled', false);
                selasa_out.prop('disabled', false);
            } 
            else
            {
                selasa_in.prop('disabled', true);
                selasa_out.prop('disabled', true);
            }
        });
        
        is_libur_rabu.change(function(){
            rabu_in.val('');
            rabu_out.val('');
            rabu_in.removeAttr('disabled');
            rabu_out.removeAttr('disabled');
            if(is_libur_rabu.filter(':checked').val() == 'masuk') 
            {
                rabu_in.prop('disabled', false);
                rabu_out.prop('disabled', false);
            } 
            else
            {
                rabu_in.prop('disabled', true);
                rabu_out.prop('disabled', true);
            }
        });
        
        is_libur_kamis.change(function(){
            kamis_in.val('');
            kamis_out.val('');
            kamis_in.removeAttr('disabled');
            kamis_out.removeAttr('disabled');
            if(is_libur_kamis.filter(':checked').val() == 'masuk') 
            {
                kamis_in.prop('disabled', false);
                kamis_out.prop('disabled', false);
            } 
            else
            {
                kamis_in.prop('disabled', true);
                kamis_out.prop('disabled', true);
            }
        });
        
        is_libur_jumat.change(function(){
            jumat_in.val('');
            jumat_out.val('');
            jumat_in.removeAttr('disabled');
            jumat_out.removeAttr('disabled');
            if(is_libur_jumat.filter(':checked').val() == 'masuk') 
            {
                jumat_in.prop('disabled', false);
                jumat_out.prop('disabled', false);
            } 
            else
            {
                jumat_in.prop('disabled', true);
                jumat_out.prop('disabled', true);
            }
        });
        
        is_libur_sabtu.change(function(){
            sabtu_in.val('');
            sabtu_out.val('');
            sabtu_in.removeAttr('disabled');
            sabtu_out.removeAttr('disabled');
            if(is_libur_sabtu.filter(':checked').val() == 'masuk') 
            {
                sabtu_in.prop('disabled', false);
                sabtu_out.prop('disabled', false);
            } 
            else
            {
                sabtu_in.prop('disabled', true);
                sabtu_out.prop('disabled', true);
            }
        });
        
        is_libur_minggu.change(function(){
            minggu_in.val('');
            minggu_out.val('');
            minggu_in.removeAttr('disabled');
            minggu_out.removeAttr('disabled');
            if(is_libur_minggu.filter(':checked').val() == 'masuk') 
            {
                minggu_in.prop('disabled', false);
                minggu_out.prop('disabled', false);
            } 
            else
            {
                minggu_in.prop('disabled', true);
                minggu_out.prop('disabled', true);
            }
        });
    });
</script>
@endpush
