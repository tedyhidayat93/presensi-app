<form action="{{$route}}" method="POST">
    @csrf
    {{ $method ?? method_field('PUT') }}
    
    <div class="card-body">
        <div class="row mg-b-10">
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h6>Catatan : </h6>
                    <ul>
                        <li>Jika ingin mengeset <b> libur </b>, kosongkan saja di salah satu bagian form waktu <b> IN & OUT </b> nya yang ingin diliburkan.</li>
                    </ul>
                </div>
            </div>
        </div>
        <input class="form-control" type="hidden" name="id" value="{{$edit->id}}">
        <div class="form-group">
            <label class="form-control-label">Nama Shift <span class="text-danger">*</span></label>
            <input class="form-control" type="text" name="shift_name" placeholder="Masukkan Nama Shift"
                value="{{old('shift_name') ?? $edit->shift_name}}" autocomplete="off">
            @if($errors->has('shift_name'))
            <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center" onclick="$(this).remove()">
                <small>{{ $errors->first('shift_name') }}</small>
                <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
            </div>
            @endif
        </div>

        <div class="row mg-t-10">
            <div class="col-12">
                <label for="">Senin</label>
            </div>
            <div class="col-12 col-md d-flex align-items-center">
                <div class="form-group d-flex align-items-center">
                    <input type="radio" value="masuk" name="is_libur_senin"  {{$edit->senin_in != null && $edit->senin_out != null ? 'checked="checked"' : ''}} class="form-control">
                    <label class="text-success mt-2 ml-1">Masuk</label>
                </div>
                <div class="form-group d-flex align-items-center ml-3">
                    <input type="radio" value="libur" name="is_libur_senin"  {{$edit->senin_in == null && $edit->senin_out == null ? 'checked="checked"' : ''}} class="form-control">
                    <label class="text-danger mt-2 ml-1">Libur</label>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-append">IN</span>
                    <input type="time" name="senin_in" value="{{old('senin_in') ?? $edit->senin_in}}" {{$edit->senin_in == null && $edit->senin_out == null ? 'disabled="disabled"' : ''}} class="form-control">
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-append">OUT</span>
                    <input type="time" name="senin_out" value="{{old('senin_out') ?? $edit->senin_out}}" {{$edit->senin_in == null && $edit->senin_out == null ? 'disabled="disabled"' : ''}} class="form-control">
                </div>
            </div>
        </div>
        <div class="row mg-t-10">
            <div class="col-12">
                <label for="">Selasa</label>
            </div>
            <div class="col-12 col-md d-flex align-items-center">
                <div class="form-group d-flex align-items-center">
                    <input type="radio" value="masuk" name="is_libur_selasa" {{$edit->selasa_in != null && $edit->selasa_out != null ? 'checked="checked"' : ''}} class="form-control">
                    <label class="text-success mt-2 ml-1">Masuk</label>
                </div>
                <div class="form-group d-flex align-items-center ml-3">
                    <input type="radio" value="libur" name="is_libur_selasa" {{$edit->selasa_in == null && $edit->selasa_out == null ? 'checked="checked"' : ''}} class="form-control">
                    <label class="text-danger mt-2 ml-1">Libur</label>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-append">IN</span>
                    <input type="time" name="selasa_in" value="{{old('selasa_in') ?? $edit->selasa_in}}" {{$edit->selasa_in == null && $edit->selasa_out == null ? 'disabled="disabled"' : ''}} class="form-control">
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-append">OUT</span>
                    <input type="time" name="selasa_out" value="{{old('selasa_out') ?? $edit->selasa_out}}" {{$edit->selasa_in == null && $edit->selasa_out == null ? 'disabled="disabled"' : ''}} class="form-control">
                </div>
            </div>
        </div>
        <div class="row mg-t-10">
            <div class="col-12">
                <label for="">Rabu</label>
            </div>
            <div class="col-12 col-md d-flex align-items-center">
                <div class="form-group d-flex align-items-center">
                    <input type="radio" value="masuk" name="is_libur_rabu" {{$edit->rabu_in != null && $edit->rabu_out != null ? 'checked="checked"' : ''}} class="form-control">
                    <label class="text-success mt-2 ml-1">Masuk</label>
                </div>
                <div class="form-group d-flex align-items-center ml-3">
                    <input type="radio" value="libur" name="is_libur_rabu" {{$edit->rabu_in == null && $edit->rabu_out == null ? 'checked="checked"' : ''}} class="form-control">
                    <label class="text-danger mt-2 ml-1">Libur</label>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-append">IN</span>
                    <input type="time" name="rabu_in" value="{{old('rabu_in') ?? $edit->rabu_in}}" {{$edit->rabu_in == null && $edit->rabu_out == null ? 'disabled="disabled"' : ''}} class="form-control">
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-append">OUT</span>
                    <input type="time" name="rabu_out" value="{{old('rabu_out') ?? $edit->rabu_out}}" {{$edit->rabu_in == null && $edit->rabu_out == null ? 'disabled="disabled"' : ''}} class="form-control">
                </div>
            </div>
        </div>
        <div class="row mg-t-10">
            <div class="col-12">
                <label for="">Kamis</label>
            </div>
            <div class="col-12 col-md d-flex align-items-center">
                <div class="form-group d-flex align-items-center">
                    <input type="radio" value="masuk" name="is_libur_kamis"  {{$edit->kamis_in != null && $edit->kamis_out != null ? 'checked="checked"' : ''}} class="form-control">
                    <label class="text-success mt-2 ml-1">Masuk</label>
                </div>
                <div class="form-group d-flex align-items-center ml-3">
                    <input type="radio" value="libur" name="is_libur_kamis"  {{$edit->kamis_in == null && $edit->kamis_out == null ? 'checked="checked"' : ''}} class="form-control">
                    <label class="text-danger mt-2 ml-1">Libur</label>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-append">IN</span>
                    <input type="time" name="kamis_in" value="{{old('kamis_in') ?? $edit->kamis_in}}" {{$edit->kamis_in == null && $edit->kamis_out == null ? 'disabled="disabled"' : ''}} class="form-control">
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-append">OUT</span>
                    <input type="time" name="kamis_out" value="{{old('kamis_out') ?? $edit->kamis_out}}" {{$edit->kamis_in == null && $edit->kamis_out == null ? 'disabled="disabled"' : ''}} class="form-control">
                </div>
            </div>
        </div>
        <div class="row mg-t-10">
            <div class="col-12">
                <label for="">Jumat</label>
            </div>
            <div class="col-12 col-md d-flex align-items-center">
                <div class="form-group d-flex align-items-center">
                    <input type="radio" value="masuk" name="is_libur_jumat"  {{$edit->jumat_in != null && $edit->jumat_out != null ? 'checked="checked"' : ''}} class="form-control">
                    <label class="text-success mt-2 ml-1">Masuk</label>
                </div>
                <div class="form-group d-flex align-items-center ml-3">
                    <input type="radio" value="libur" name="is_libur_jumat"  {{$edit->jumat_in == null && $edit->jumat_out == null ? 'checked="checked"' : ''}} class="form-control">
                    <label class="text-danger mt-2 ml-1">Libur</label>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-append">IN</span>
                    <input type="time" name="jumat_in" value="{{old('jumat_in') ?? $edit->jumat_in}}" {{$edit->jumat_in == null && $edit->jumat_out == null ? 'disabled="disabled"' : ''}} class="form-control">
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-append">OUT</span>
                    <input type="time" name="jumat_out" value="{{old('jumat_out') ?? $edit->jumat_out}}" {{$edit->jumat_in == null && $edit->jumat_out == null ? 'disabled="disabled"' : ''}} class="form-control">
                </div>
            </div>
        </div>
        <div class="row mg-t-10">
            <div class="col-12">
                <label for="">Sabtu</label>
            </div>
            <div class="col-12 col-md d-flex align-items-center">
                <div class="form-group d-flex align-items-center">
                    <input type="radio" value="masuk" name="is_libur_sabtu"  {{$edit->sabtu_in != null && $edit->sabtu_out != null ? 'checked="checked"' : ''}} class="form-control">
                    <label class="text-success mt-2 ml-1">Masuk</label>
                </div>
                <div class="form-group d-flex align-items-center ml-3">
                    <input type="radio" value="libur" name="is_libur_sabtu"  {{$edit->sabtu_in == null && $edit->sabtu_out == null ? 'checked="checked"' : ''}} class="form-control">
                    <label class="text-danger mt-2 ml-1">Libur</label>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-append">IN</span>
                    <input type="time" name="sabtu_in" value="{{old('sabtu_in') ?? $edit->sabtu_in}}" {{$edit->sabtu_in == null && $edit->sabtu_out == null ? 'disabled="disabled"' : ''}} class="form-control">
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-append">OUT</span>
                    <input type="time" name="sabtu_out" value="{{old('sabtu_out') ?? $edit->sabtu_out}}" {{$edit->sabtu_in == null && $edit->sabtu_out == null ? 'disabled="disabled"' : ''}} class="form-control">
                </div>
            </div>
        </div>
        <div class="row mg-t-10">
            <div class="col-12">
                <label for="">Minggu</label>
            </div>
            <div class="col-12 col-md d-flex align-items-center">
                <div class="form-group d-flex align-items-center">
                    <input type="radio" value="masuk" name="is_libur_minggu" {{$edit->minggu_in != null && $edit->minggu_out != null ? 'checked="checked"' : ''}} class="form-control">
                    <label class="text-success mt-2 ml-1">Masuk</label>
                </div>
                <div class="form-group d-flex align-items-center ml-3">
                    <input type="radio" value="libur" name="is_libur_minggu" {{$edit->minggu_in == null && $edit->minggu_out == null ? 'checked="checked"' : ''}} class="form-control">
                    <label class="text-danger mt-2 ml-1">Libur</label>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-append">IN</span>
                    <input type="time" name="minggu_in" value="{{old('minggu_in') ?? $edit->minggu_in}}" {{$edit->minggu_in == null && $edit->minggu_out == null ? 'disabled="disabled"' : ''}} class="form-control">
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-append">OUT</span>
                    <input type="time" name="minggu_out" value="{{old('minggu_out') ?? $edit->minggu_out}}" {{$edit->minggu_in == null && $edit->minggu_out == null ? 'disabled="disabled"' : ''}} class="form-control">
                </div>
            </div>
        </div>

    </div>
    @if ($edit->id != null)
    <div class="card-footer d-flex justify-content-end">
        <a href="{{route('adm.shift')}}" class="btn btn-light">Batal</a>
        &nbsp;&nbsp;&nbsp;
        <button type="submit" class="btn btn-info">{{$button_value}}</button>
    </div>
    @endif
</form>
