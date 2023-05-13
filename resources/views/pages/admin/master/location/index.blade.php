@extends('layouts.app_panel.app', $head)


@section('content')
<div class="section">
    <div class="section-header">
        <h1> {{$head['head_title_per_page'] ?? 'Title' }}</h1>
    </div>
    <div class="row">
        
        <div class="col-12 col-md-5">
            <div class="card">
                @include('pages.admin.master.location.form')
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
                                    <th class="">Nama Lokasi</th>
                                    <th class="">Koordinat</th>
                                    <th class="">Radius</th>
                                    <th class="">Status</th>
                                    <th class="wd-5p">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($data as $row) 
                                    <tr>
                                        <td>{{$i++}}.</td>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->radius}} Meter</td>
                                        <td>{{$row->lat_loc .', '.$row->long_loc}}</td>
                                        <td>
                                            <a href="#" class="btn btn-{{$row->is_active == 0 ? 'secondary':'success' }} btn-icon wd-35 ht-35" data-toggle="modal"
                                                data-target="#modalStatus{{$row->id}}">
                                                    <div><i class="fa {{$row->is_active == 1 ? 'fa-toggle-on':'fa-toggle-off' }} "></i></div>
                                                </a>
                                        </td>
                                        <td>

                                            <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#modaldemo{{$row->id}}">
                                                <div><i class="fa fa-trash"></i></div>
                                            </a>
                                            
                                            <a href="{{route('adm.location.edit', $row->id)}}" class="btn btn-info btn-sm ">
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
<div id="modalStatus{{$row->id}}" class="modal fade">
   <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
                <i class="fa fa-question-circle text-100 text-info lh-1 mg-t-20 d-inline-block"></i>
                <h4 class="text-info font-weight-bold mg-b-20">Yakin ingin {{$row->is_active == 0 ? 'mengaktifkan':'non aktifkan' }} Zona ini ?
                </h4>
                <p class="mg-b-20 mg-x-20">Zona <b> "{{$row->name}}" </b> akan aktif.</p>
                <form action="{{route('adm.location.status')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$row->id}}">
                    <input type="hidden" name="is_active" value="{{$row->is_active}}">
                    <button type="button" class="btn btn-light text-11 text-uppercase pd-y-12 pd-x-25 text-mont text-medium mg-b-20" data-dismiss="modal" aria-label="Close">Batal</button>
                    <button type="submit" class="btn btn-info text-11 text-uppercase pd-y-12 pd-x-25 text-mont text-medium mg-b-20">Ya, {{$row->is_active == 0 ? 'Aktifkan':'Non Aktifkan' }}</button>
                </form>
            </div><!-- modal-body -->
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
@endforeach
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
                <h4 class="text-danger font-weight-bold mg-b-20">Yakin ingin menghapus Zona ?
                </h4>
                <p class="mg-b-20 mg-x-20">Zona <b> "{{$row->name}}" </b> akan dihapus dari database.</p>
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


@push('active-lokasi')
active
@endpush

@push('menuOpen-lokasi')
style="display: block;"
@endpush

@push('showSub-lokasi')
show-sub
@endpush

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
crossorigin=""/>
@endpush

@push('scripts')
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
<script>
    $(document).ready(function() {

        var radius = $('#radius');
        var latLoc = $('#lat');
        var longLoc = $('#long');
        var marker;
        var map;
        var latlng;
        var circle;
        
        navigator.geolocation.getCurrentPosition((position) => {
            let lat = parseFloat(position.coords.latitude.toFixed(4)) ;
            let long = parseFloat(position.coords.longitude.toFixed(4));
            // let lat = position.coords.latitude.toFixed(4);
            // let long =position.coords.longitude.toFixed(2);
            
            // var map = L.map('mapid').setView([lat, long], 18);
            var map = L.map('mapid').setView([-6.331146, 107.002307], 16);

            
            var marker = L.marker([-6.331146, 107.002307]).addTo(map);
            map.on('click', function(e){
                if (marker) { // check
                    map.removeLayer(marker); // remove
                }
                if (circle) { // check
                    map.removeLayer(circle);
                }
                marker = new L.Marker(e.latlng).addTo(map); // set
                var latlng = map.mouseEventToLatLng(e.originalEvent);
                latLoc.val(latlng.lat.toFixed(4))
                longLoc.val(latlng.lng.toFixed(4))

            });
            

            map.on('locationfound', function(ev){
                if (!marker) {
                    marker = L.marker(ev.latlng);
                } else {
                    marker.setLatLng(ev.latlng);
                }
            })
    
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

        });


        
    })

</script>
@endpush
