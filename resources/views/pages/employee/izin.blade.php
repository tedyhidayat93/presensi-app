@extends('layouts.public.app', $head)

@section('dynamic-content')
<div class="br-pagebody mg-t-5 pd-x-20  pd-b-200">
    
    <div class="card shadow-base bd-0">
        <div class="card-body pd-x-10 pd-b-10 pd-t-0">
            
            <div class="row no-gutters mt-4">

                <div class="col-sm-12 col-lg-3">
                    <form action="{{route('user.izin.send')}}" method="POST" enctype="multipart/form-data">
                        <div class="card">
                            <div class="card-body overflow-hidden px-3 bg-dark rounded">
                                @csrf
                                
                                <input type="hidden" name="usr" id="usr_in" value="{{auth()->user()->id}}">
                                <input type="hidden" name="latlong" id="latlong1" value="">

                                
                                <div class="form-group">
                                    <label class="tx-white" for="">Jenis Izin</label>
                                    <select class="form-control" name="type">
                                            @if ($jenis_izin)
                                            @foreach ($jenis_izin as $j)
                                            <option value="{{$j->id}}" {{old('type') == $j->id ? 'selected':''}}>
                                                {{$j->type}}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="tx-white" for="">Dokumen</label>
                                    <input type="file" class="form-control" name="dokumen" />
                                </div>

                                <div class="form-group">
                                    <label class="tx-white">Alasan</label>
                                    <textarea class="form-control" placeholder="Isi alasan ..."
                                    name="alasan"
                                    id="note_absen"
                                    cols="5"
                                    rows="4"></textarea>
                                </div>
                                
                                <button type="submit" class="tbl-absen-in btn-block btn btn-md mt-2 btn-success btn-with-icon">
                                    <div class="ht-40 justify-content-center">
                                        <span class="pd-x-15">Kirim Izin</span>
                                    </div>
                                </button>
                                
                            </div><!-- card -->
                        </div>
                    </form>
                </div><!-- col-3 -->

                <div class="col-sm-12 col-lg-9 ">
                    <div class="card card-body rounded-0 bd-lg-l-0 border-0 overflow-auto">


                            <div class="d-block d-md-flex justify-content-between tx-12">

                                <table class="table table-valign-middle mg-b-0 nowrap">
                                    <tbody>
                                        <tr>
                                            <td class=" bg-light" width="100">
                                                <div class="w-100 h-100 overflow-hidden d-flex align-items-center justify-content-center rounded">
                                                    
                                                    @if (auth()->user()->photo_profile)
                                                    <img class="w-100 h-100 rounded img-fluid" src="{{ asset('uploads/images/employee/'. auth()->user()->photo_profile) }}">
                                                    @else
                                                    <img class="w-100 h-100 rounded img-fluid" src="{{ asset('images/default-ava.jpg') }}"> 
                                                    @endif
                                                </div>
                                            </td>
                                            <td colspan="2">
                                                <h4 class="tx-teal tx-20 mg-b-0">{{auth()->user()->full_name}}</h4>
                                                <span class="tx-12"><b>Jabatan : </b> {{auth()->user()->jabatan->type ?? '-'}}</span>
                                            </td>
                                            <td>
                                                <span class="tx-12">Terdaftar Sejak</span>
                                                <h4 class="tx-inverse tx-14 mg-b-0">{{ date('d-M-Y', strtotime(auth()->user()->registered_at))}}</h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="tx-12">Shift</span>
                                                <h4 class="tx-inverse tx-14 mg-b-0">{{auth()->user()->shifft->shift_name}}</h4>
                                            </td>
                                            <td>
                                                <span class="tx-12">Email</span>
                                                <h4 class="tx-inverse tx-14 mg-b-0">{{auth()->user()->email}}</h4>
                                            </td>
                                            <td>
                                                <span class="tx-12">NIP</span>
                                                <h4 class="tx-inverse tx-14 mg-b-0">{{auth()->user()->nip}}</h4>
                                            </td>
                                            <td>
                                                <span class="tx-12">NIK</span>
                                                <h4 class="tx-inverse tx-14 mg-b-0">{{auth()->user()->nik}}</h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <hr>
                            <table id="datatable1" class="table display nowrap">
                                <thead class="thead-teal">
                                    <tr>
                                        <th class="wd-5p"><span class="tx-white font-weight-bold">#</span></th>
                                        <th class=""><span class="tx-white font-weight-bold">Tanggal </span></th>
                                        <th class=""><span class="tx-white font-weight-bold">Jenis Izin </span></th>
                                        <th class=""><span class="tx-white font-weight-bold">Alasan </span></th>
                                        <th class=""><span class="tx-white font-weight-bold">Dokumen </span></th>
                                        <th class=""><span class="tx-white font-weight-bold">Status </span></th>
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
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div><!-- card -->
                </div><!-- col-3 -->

                
            </div><!-- row -->
        
        </div><!-- card-body -->
      
    </div><!-- card -->
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
