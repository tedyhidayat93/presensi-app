@extends('layouts.admin.app', $head)


@section('dynamic-content')
<div class="br-pagebody mg-t-5 pd-x-20 pd-b-100">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{$route}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{ $method ?? method_field('PUT') }}
                    <input class="form-control" type="hidden" name="id" value="{{$edit->id}}">
                    <div class="card-body">
                        <div class="row mg-b-10">
                            <div class="col-12">
                                <div class="alert alert-info" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h6>Catatan : </h6>
                                    <ul>
                                        <li>Tanda <b> <span class="text-danger">*</span></b> wajid diisi</li>
                                        <li>Jika password tidak diiisi maka password tersimpan default menjadi <b>
                                                "123456789" </b></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mg-b-25">
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Nama Lengkap Karyawan <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="full_name"
                                        value="{{old('full_name') ?? $edit->full_name}}"
                                        placeholder="Masukkan Nama Lengkap">
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">NIP</label>
                                    {{-- <input {{$edit->id != null ? 'disabled' : '' }} class="form-control" type="text" --}}
                                    <input class="form-control" type="text"
                                        name="nip" value="{{old('nip') ?? $edit->nip}}"
                                        placeholder="Masukkan NIP, NIP tidak boleh sama...">
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">NIK <span class="text-danger">*</span></label>
                                    {{-- <input {{$edit->id != null ? 'disabled' : '' }} class="form-control" type="text" --}}
                                    <input class="form-control" type="text"
                                        name="nik" value="{{old('nik') ?? $edit->nik}}"
                                        placeholder="Masukkan NIK, NIK tidak boleh sama...">
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Email</label>
                                    <input {{$edit->id != null ? 'disabled' : '' }} class="form-control" type="email"
                                        name="email" value="{{old('email') ?? $edit->email}}"
                                        placeholder="Masukkan Email">
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Tipe</label>
                                    <select class="form-control" name="type">
                                        <option value="staff" {{$edit->type == 'staff' ? 'selected':''}}>STAFF</option>
                                        <option value="non_staff" {{$edit->type == 'non_staff' ? 'selected':''}}>NON STAFF</option>
                                    </select>
                                    @if($errors->has('type'))
                                    <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center"
                                        onclick="$(this).remove()">
                                        <small>{{ $errors->first('type') }}</small>
                                        <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
                                    </div>
                                    @endif
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Jabatan</label>
                                    <select class="form-control" name="jabatan">
                                        <option value="" {{$edit->employee_type == null ? 'selected':''}}>-- Pilih
                                            Jabatan --</option>

                                            @if ($jabatan)
                                            @foreach ($jabatan as $j)
                                            <option value="{{$j->id}}" {{$edit->employee_type == $j->id ? 'selected':''}}>
                                                {{$j->type}}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                    @if($errors->has('jabatan'))
                                    <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center"
                                        onclick="$(this).remove()">
                                        <small>{{ $errors->first('jabatan') }}</small>
                                        <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
                                    </div>
                                    @endif
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Jenis Kelamin</label>
                                    <select class="form-control" name="gender"
                                        data-placeholder="Status Aktif/Nonaktif">
                                        <option value="L" {{$edit->gender == 'L' ? 'selected':''}}>Laki - Laki</option>
                                        <option value="P" {{$edit->gender == 'P' ? 'selected':''}}>Perempuan</option>
                                    </select>
                                    @if($errors->has('gender'))
                                    <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center"
                                        onclick="$(this).remove()">
                                        <small>{{ $errors->first('gender') }}</small>
                                        <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
                                    </div>
                                    @endif
                                </div>
                            </div><!-- col-4 -->
                            {{-- <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Agama</label>
                                    <select class="form-control" name="religion"
                                        data-placeholder="Status Aktif/Nonaktif">
                                        <option value="L" {{$edit->religion == 'L' ? 'selected':''}}>Laki - Laki</option>
                                        <option value="P" {{$edit->religion == 'P' ? 'selected':''}}>Perempuan</option>
                                    </select>
                                    @if($errors->has('religion'))
                                    <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center"
                                        onclick="$(this).remove()">
                                        <small>{{ $errors->first('religion') }}</small>
                                        <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
                                    </div>
                                    @endif
                                </div>
                            </div><!-- col-4 --> --}}
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Status Aktif/Nonaktif</label>
                                    <select class="form-control" name="is_active"
                                        data-placeholder="Status Aktif/Nonaktif">
                                        <option value="1" {{$edit->is_active == 1 ? 'selected':''}}>Aktif</option>
                                        <option value="0" {{$edit->is_active == 0 ? 'selected':''}}>Non Aktif</option>
                                    </select>
                                    @if($errors->has('is_active'))
                                    <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center"
                                        onclick="$(this).remove()">
                                        <small>{{ $errors->first('is_active') }}</small>
                                        <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
                                    </div>
                                    @endif
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Password {{$edit != null ? 'Baru' : '' }} </label>
                                    <input class="form-control" type="text" name="password" value="{{old('password')}}"
                                        placeholder="Masukkan Password {{$edit != null ? 'Baru' : '' }} ">
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Shift</label>
                                    <select class="form-control" name="shift">
                                        <option value="" {{$edit->employee_type == null ? 'selected':''}}>-- Pilih
                                            Shift --</option>

                                            @if ($shifts)
                                            @foreach ($shifts as $s)
                                            <option value="{{$s->id}}" {{$edit->shift === $s->id ? 'selected':''}}>
                                                {{$s->shift_name}}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                    @if($errors->has('shift'))
                                    <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center"
                                        onclick="$(this).remove()">
                                        <small>{{ $errors->first('shift') }}</small>
                                        <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
                                    </div>
                                    @endif
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                  <label class="form-control-label">Foto Karyawan (Maksimal: 5MB, Extensi: jpg-jpeg-gif-png.)</label>
                                  <div class="input-group" id="elementfile">
                                    <input type="file" class="form-control" name="foto" accept="image/*">
                                    <div class="input-group-addon bg-info text-light" id="btn-removefile">
                                      <i class="fa fa-upload"></i>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <div class="col-12 col-md-4">
                                @if ($update_id != null && $edit->photo_profile != null)
                                <input type="hidden" name="old_file" value="{{$edit->photo_profile}}">
                                <img class="" width="200" src="{{asset('uploads/images/employee/'.$edit->photo_profile)}}">
                                @endif
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{$route_back}}" class="btn btn-light">Kembali</a>
                        &nbsp;&nbsp;&nbsp;
                        <button type="submit" class="btn btn-info">{{$button_value}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
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
@endpush
