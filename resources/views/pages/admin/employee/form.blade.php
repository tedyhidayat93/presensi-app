@extends('layouts.app_panel.app', $head)


@section('content')
<div class="section">
    <div class="section-header">
        <h1> {{$head['head_title_per_page'] ?? 'Title' }}</h1>
    </div>
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
                                <div class="alert alert-info alert-dismissible" role="alert">
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
                            <div class="col-12">
                                <h6 class="text-info">Informasi Data Diri</h6>
                                <hr>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-control-label">Nama Lengkap Karyawan <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="full_name"
                                        value="{{old('full_name') ?? $edit->full_name}}"
                                        placeholder="Masukkan Nama Lengkap">
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label">NIK <span class="text-danger">*</span></label>
                                    {{-- <input {{$edit->id != null ? 'disabled' : '' }} class="form-control" type="text" --}}
                                    <input class="form-control" type="text"
                                        name="nik" value="{{old('nik') ?? $edit->nik}}"
                                        placeholder="Masukkan NIK, NIK tidak boleh sama...">
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-12 col-md-3">
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
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label">Nomor Telepon </label>
                                    <input class="form-control" type="number" name="phone"
                                        value="{{old('phone') ?? $edit->phone}}"
                                        placeholder="Masukkan Nomor Telepon">
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-12 col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label">Pendidikan Terakhir</label>
                                    <select class="form-control select2" name="last_education">
                                        <option value="" {{$edit->employee_type == null ? 'selected':''}}>-- Pilih Pendidikan --</option>

                                            @if ($educations)
                                            @foreach ($educations as $j)
                                            <option value="{{$j->id}}" {{$edit->last_education == $j->id ? 'selected':''}}>
                                                {{$j->education}}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                    @if($errors->has('last_education'))
                                    <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center"
                                        onclick="$(this).remove()">
                                        <small>{{ $errors->first('last_education') }}</small>
                                        <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
                                    </div>
                                    @endif
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-control-label">Alamat KTP</label>
                                    <textarea name="address" class="form-control" id="" cols="3" rows="4">{{old('address') ?? $edit->address}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12">
                                <h6 class="text-info">Informasi Kepegawaian</h6>
                                <hr>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Tanggal Masuk</label>
                                    <input class="form-control" type="date" name="tanggal_masuk" value="{{ date('Y-m-d') ?? $edit->tanggal_masuk}}">
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Email <small class="text-info">(Email tidak boleh sama dengan yang lain)</small></label>
                                    <input class="form-control" type="email"
                                        name="email" value="{{old('email') ?? $edit->email}}"
                                        placeholder="Masukkan Email, email tidak boleh sama">
                                        <input type="hidden" name="old_email" value="{{$edit->email}}">
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
                                    <label class="form-control-label">Status</label>
                                    <select class="form-control" name="status" data-placeholder="Status Aktif/Nonaktif">
                                        <option value="magang" {{$edit->status == 'magang' ? 'selected':''}}>Magang</option>
                                        <option value="tetap" {{$edit->status == 'tetap' ? 'selected':''}}>Tetap</option>
                                        <option value="kontrak" {{$edit->status == 'kontrak' ? 'selected':''}}>Kontrak</option>
                                        <option value="harian" {{$edit->status == 'harian' ? 'selected':''}}>Harian</option>
                                    </select>
                                    @if($errors->has('status'))
                                    <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center"
                                        onclick="$(this).remove()">
                                        <small>{{ $errors->first('status') }}</small>
                                        <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
                                    </div>
                                    @endif
                                </div>
                            </div><!-- col-4 -->
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Tipe</label>
                                    <select class="form-control" name="type">
                                        <option value="staff" {{$edit->type == 'staff' ? 'selected':''}}>Staff</option>
                                        <option value="non_staff" {{$edit->type == 'non_staff' ? 'selected':''}}>Non Staff</option>
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
                                    <select class="form-control select2" name="jabatan">
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
                                    <label class="form-control-label">Shift <span class="text-danger">*</span></label>
                                    <select class="form-control" name="shift">
                                        {{-- <option value="" {{$edit->employee_type == null ? 'selected':''}}>-- Pilih Shift --</option> --}}

                                            @if ($shifts)
                                            @foreach ($shifts as $s)
                                            <option value="{{$s->id}}" {{$edit->shift == (string)$s->id ? 'selected':''}}>{{$s->shift_name}}</option>
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
                        </div>    
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="text-info">Informasi Akun</h6>
                                <hr>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Password </label>
                                    <input class="form-control" type="text" name="password" value="{{old('password')}}"
                                        placeholder="Masukkan Password ">
                                        <small class="text-info">{{$edit->full_name != null ? '':'Jika tidak diisi maka password default nya ( 123456789 ) '}}</small>

                                </div>
                            </div><!-- col-4 -->
                            <div class="col-12 col-md-4">
                                <div class="form-group">
                                  <label class="form-control-label">Foto (Maksimal: 5MB, Extensi: jpg-jpeg-png.)</label>
                                  <div class="input-group" id="elementfile">
                                    <input type="file" class="form-control" name="foto" accept="image/*">
                                    <div class="input-group-append" id="btn-removefile">
                                      <div class="input-group-text bg-info text-light">
                                        <i class="fa fa-upload"></i>
                                      </div>
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

                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="text-info">Hak Akses Presensi</h6>
                                <hr>
                            </div>

                             
                            <div class="col-12 col-lg-4">
                                
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-control-label">Izinkan karyawan absen via website ?</label>
                                            <div class="input-group">
                                                <span class="input-group-append bg-transparent">
                                                    <label class="ckbox wd-16">
                                                        <input type="checkbox" name="is_web" value="1"
                                                            {{$edit->is_web == 1 ? 'checked="checked"':''}}><span></span>
                                                    </label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <label class="form-control-label">Izinkan karyawan absen via mobile ?</label>
                                            <div class="input-group">
                                                <span class="input-group-append bg-transparent">
                                                    <label class="ckbox wd-16">
                                                        <input type="checkbox" name="is_mobile" value="0"
                                                            {{$edit->is_mobile == 1 ? 'checked="checked"':''}}><span></span>
                                                    </label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                                
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{$route_back}}" class="btn btn-light">Kembali</a>
                        &nbsp;&nbsp;&nbsp;
                        @canany(['admin-karyawan-store','admin-karyawan-update'])
                        <button type="submit" class="btn btn-info">{{$button_value}}</button>
                        @endcanany
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection


@push('active-employee')
active
@endpush

@push('menuOpen-employee')
style="display: block;"
@endpush

@push('showSub-employee')
show-sub
@endpush

@push('styles')
@endpush
@push('scripts')
@endpush
