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
                        <div class="row mg-b-25">
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-control-label">Nama Lengkap</label>
                              <input class="form-control" type="text" name="full_name" value="{{old('full_name') ?? $edit->full_name}}" placeholder="Masukan Nama Lengkap">
                            </div>
                          </div><!-- col-4 -->
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-control-label">Email</label>
                              <input {{$edit->id != null ? 'disabled' : '' }} class="form-control" type="email" name="email" value="{{old('email') ?? $edit->email}}" placeholder="Masukan Email">
                            </div>
                          </div><!-- col-4 -->
                          <div class="col-lg-6">
                            <div class="form-group">
                              <label class="form-control-label">{{$edit != null ? 'New' : '' }} Password</label>
                              <input class="form-control" type="text" name="password" value="{{old('password')}}" placeholder="Enter {{$edit != null ? 'New' : '' }} Password">
                            </div>
                          </div><!-- col-4 -->
                          <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label">Status</label>
                                <select class="form-control" name="is_active" data-placeholder="Choose Icon">
                                    <option value="1" {{$edit->is_active == 1 ? 'selected':''}}>Aktif</option>
                                    <option value="0" {{$edit->is_active == 0 ? 'selected':''}}>Non Aktif</option>
                                </select>
                                @if($errors->has('icon'))
                                <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center" onclick="$(this).remove()">
                                    <small>{{ $errors->first('icon') }}</small>
                                    <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
                                </div>
                                @endif
                            </div>
                          </div><!-- col-4 -->
                          <div class="col-12 col-md-6">
                            <div class="form-group">
                              <label class="form-control-label">Foto Admin (Maksimal Ukuran: 5MB, Extensi: jpg-jpeg-gif-png.)</label>
                              <div class="input-group" id="elementfile">
                                <input type="file" class="form-control" name="foto" accept="image/*">
                                <div class="input-group-addon bg-info text-light" id="btn-removefile">
                                  <i class="fa fa-upload"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                        <div class="col-12 col-md-6">
                            @if ($update_id != null && $edit->photo_profile != null)
                            <input type="hidden" name="old_file" value="{{$edit->photo_profile}}">
                            <img class="" width="200" src="{{asset('uploads/images/admin/'.$edit->photo_profile)}}">
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


@push('active-users')
active
@endpush

@push('menuOpen-users')
style="display: block;"
@endpush

@push('showSub-users')
show-sub
@endpush

@push('styles')
@endpush
@push('scripts')
@endpush
