@extends('layouts.app_panel.app', $head)

@section('content')
<div class="section">
    
    <div class="section-header d-md-flex justify-content-between align-items-center">
        <h1> {{$head['head_title_per_page'] ?? 'Title' }}</h1>
        <span class="float-right">{{$head['sub_title_per_page'] ?? 'Sub Title'}}</span>
    </div>

    <div class="row">

        @canany(['user-izin-create'])
        <div class="col-sm-12 col-lg-12">
            <form action="{{route('user.izin.send')}}" method="POST" enctype="multipart/form-data">
                <div class="card border">
                    <div class="card-header">
                        <h4 class="card-title text-primary"><i class="fas fa-file"></i> Form Permohonan</h4>
                    </div>
                    <div class="card-body overflow-hidden px-3 rounded">
                        @csrf
                        
                        <input type="hidden" name="usr" id="usr_in" value="{{auth()->user()->id}}">
                        <input type="hidden" name="latlong" id="latlong1" value="">

                        
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="" for="">Jenis Izin</label>
                                    <select class="form-control" name="type">
                                            @if ($jenis_izin)
                                            @foreach ($jenis_izin as $j)
                                            <option value="{{$j->id}}" {{old('type') == $j->id ? 'selected':''}}>
                                                {{$j->type}}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="" for="">Dokumen</label>
                                    <input type="file" class="form-control" name="dokumen" accept="application/pdf,image/*"/>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="">Alasan</label>
                            <textarea class="form-control" placeholder="Masukkan alasan izin ..."
                            name="alasan"
                            id="note_absen"
                            cols="5"
                            rows="4"></textarea>
                        </div>
                        
                        @canany(['user-izin-store'])
                        <button type="submit" class="tbl-absen-in btn-block btn mt-2 btn-primary">
                            <div class="ht-40 justify-content-center">
                                <span class="pd-x-15"><i class="fas fa-paper-plane"></i> Kirim Permohonan Izin</span>
                            </div>
                        </button>
                        @endcanany
                        
                    </div><!-- card -->
                </div>
            </form>
        </div><!-- col-3 -->
        @endcanany
        
        @canany(['user-izin-list'])
        <div class="col-sm-12 col-lg-12">
            <div class="card border">
                <div class="card-header">
                    <h4 class="card-title text-primary"><i class="fas fa-history"></i> Riwayat Permohonan</h4>
                </div>
                <div class="card-body overflow-auto table-responsive">
                    <table id="datatable1" class="table table-striped nowrap w-full">
                        <thead class="">
                            <tr>
                                <th class="wd-5p"><span class="">#</span></th>
                                <th class=""><span class="">Tanggal </span></th>
                                <th class=""><span class="">Jenis Izin </span></th>
                                <th class=""><span class="">Alasan </span></th>
                                <th class=""><span class="">Dokumen </span></th>
                                <th class=""><span class="">Status </span></th>
                                @canany(['user-izin-edit','user-izin-delete','user-izin-show'])
                                <th class=""><span class="">Aksi </span></th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            @endphp
                            @foreach ($data as $row)
                            <tr>
                                <td>{{$i++}}.</td>
                                <td>{{ date('d-M-Y | H:i', strtotime($row->created_at ?? '0000-00-00'))}}</td>
                                <td>{{$row->jenis->type ?? '-'}}</td>
                                <td>{{ $row->alasan ?? '-' }}  </td>
                                <td>
                                    @if ($row->dokumen !== null)
                                        <a href="{{ asset('uploads/izin/'. $row->dokumen ) }}" target="_blank">Buka Dokumen</a>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    @if($row->is_approve == 2)
                                    <span class="badge badge-success">Disetujui</span>
                                    @elseif($row->is_approve == 3)
                                    <span class="badge badge-danger">Ditolak</span>
                                    @elseif($row->is_approve == 1)
                                    <span class="badge badge-warning text-white">Menunggu</span>
                                    @endif
                                </td>
                                @canany(['user-izin-edit','user-izin-delete','user-izin-show'])
                                <td>
                                    @canany(['user-izin-show'])
                                    <a href="{{route('user.izin.detail', $row->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Detail</a>
                                    @endcanany
                                </td>
                                @endcanany

                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!-- card -->
        </div><!-- col-3 -->
        @endcanany

        
    </div><!-- row -->

</div><!-- login-wrapper -->
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


{{-- GET LOCATION ABSEN --}}
<script>
    let buttonMasuk = document.getElementById("get-location-masuk");
    let buttonPulang = document.getElementById("get-location-pulang");
    let field1 = document.getElementById("latlong1");
    let field2 = document.getElementById("latlong2");

    $(document).ready(function () {
        navigator.geolocation.getCurrentPosition((position) => {
            let lat = position.coords.latitude.toFixed(4);
            let long = position.coords.longitude.toFixed(4);
            var latlong = lat + ',' + long;
            field1.value = latlong;
            field2.value = latlong;
        });
    });

    buttonMasuk.addEventListener("click", () => {
        navigator.geolocation.getCurrentPosition((position) => {
            let lat = position.coords.latitude.toFixed(4);
            let long = position.coords.longitude.toFixed(4);
            var latlong = lat + ',' + long;
            field1.value = latlong;
            setTimeout(10000);
        });
    });

    buttonPulang.addEventListener("click", () => {
        navigator.geolocation.getCurrentPosition((position) => {
            let lat = position.coords.latitude.toFixed(4);
            let long = position.coords.longitude.toFixed(4);
            var latlong = lat + ',' + long;
            field2.value = latlong;
            setTimeout(10000);
        });
    });

</script>
@endpush
