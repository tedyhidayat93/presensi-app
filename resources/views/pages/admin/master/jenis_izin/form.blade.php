<form action="{{$route}}" method="POST">
    @csrf
    {{ $method ?? method_field('PUT') }}
    <div class="card-body">
        <input class="form-control" type="hidden" name="id" value="{{$edit->id}}">
        <div class="form-group">
            <label class="form-control-label">Jenis Izin <span class="text-danger">*</span></label>
            <input class="form-control" type="text" name="type" placeholder="Masukkan Jenis Izin"
                value="{{old('type') ?? $edit->type}}" autocomplete="off">
            @if($errors->has('type'))
            <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center" onclick="$(this).remove()">
                <small>{{ $errors->first('type') }}</small>
                <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
            </div>
            @endif
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <a href="{{route('adm.master.jenis_izin')}}" class="btn btn-light">Batal</a>
        &nbsp;&nbsp;&nbsp;
        <button type="submit" class="btn btn-info">{{$button_value}}</button>
    </div>
</form>
