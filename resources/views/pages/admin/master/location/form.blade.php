<form action="{{$route}}" method="POST">
    @csrf
    {{ $method ?? method_field('PUT') }}
    <div class="card-body bg-gray-100 pd-0">
        <div id="mapid" style="width:100%; height:345px;"></div>
    </div>
    <div class="card-body">
        <input class="form-control" type="hidden" name="id" value="{{$edit->id}}">


        <div class="row">
            <div class="col-12 col-md-12">
                <div class="form-group">
                    <label class="form-control-label">Nama Lokasi <span class="tx-danger">*</span></label>
                    <input class="form-control" type="text" name="name" placeholder="Masukkan Nama Lokasi"
                        value="{{old('name') ?? $edit->name}}" autocomplete="off">
                    @if($errors->has('name'))
                    <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center"
                        onclick="$(this).remove()">
                        <small>{{ $errors->first('name') }}</small>
                        <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <label class="form-control-label">Radius</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="radius" min="0" value="{{ $edit->radius ?? 0}}" name="radius" placeholder="0">
                    <span class="input-group-addon">Meter</i></span>
                </div>
                @if($errors->has('radius'))
                <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center"
                    onclick="$(this).remove()">
                    <small>{{ $errors->first('radius') }}</small>
                    <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
                </div>
                @endif
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label class="form-control-label">Latitude</label>
                    <input class="form-control" type="text" id="lat" name="lat_loc" placeholder="-"
                        value="{{old('lat_loc') ?? $edit->lat_loc}}" autocomplete="off" readonly>
                    @if($errors->has('lat_loc'))
                    <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center"
                        onclick="$(this).remove()">
                        <small>{{ $errors->first('lat_loc') }}</small>
                        <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label class="form-control-label">Longitude</label>
                    <input class="form-control" type="text" id="long" name="long_loc" placeholder="-"
                        value="{{old('long_loc') ?? $edit->long_loc}}" autocomplete="off" readonly>
                    @if($errors->has('long_loc'))
                    <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center"
                        onclick="$(this).remove()">
                        <small>{{ $errors->first('long_loc') }}</small>
                        <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <a href="{{route('adm.location')}}" class="btn btn-light">Batal</a>
        &nbsp;&nbsp;&nbsp;
        <button type="submit" class="btn btn-info">{{$button_value}}</button>
    </div>
</form>
