<form action="{{$route}}" method="POST">
    @csrf
    {{ $method ?? method_field('PUT') }}
    <div class="card-body">
        <input class="form-control" type="hidden" name="id" value="{{$edit->id}}">
        <div class="form-group">
            <label class="form-control-label">Nama Jenjang <span class="text-danger">*</span></label>
            <input class="form-control" type="text" name="education" placeholder="Masukan nama jenjang pendidikan"
                value="{{old('education') ?? $edit->education}}" autocomplete="off">
            @if($errors->has('education'))
            <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center" onclick="$(this).remove()">
                <small>{{ $errors->first('education') }}</small>
                <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
            </div>
            @endif
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        @canany(['admin-pendidikan-edit','admin-pendidikan-create'])
        <a href="{{route('adm.master.jenis_lembur')}}" class="btn btn-light">Batal</a>
        &nbsp;&nbsp;&nbsp;
        <button type="submit" class="btn btn-info">{{$button_value}}</button>
        @endcanany
    </div>
</form>
