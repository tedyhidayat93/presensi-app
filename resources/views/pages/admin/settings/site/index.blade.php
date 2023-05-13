@extends('layouts.app_panel.app', $head)


@section('content')
<div class="section">
    <div class="section-header">
        <h1> {{$head['head_title_per_page'] ?? 'Title' }}</h1>
      </div>

    <div class="pd-10 bd rounded bg-light">
        <ul class="nav nav-pills flex-column flex-md-row" role="tablist">

            @can('admin-pengaturan-umum')
            <li class="nav-item"><a
                    class="nav-link {{session()->get('tab_active') == 'general' || empty(session()->get('tab_active')) ? 'active' : ''}}"
                    data-toggle="tab" href="#general" role="tab">UMUM</a></li>
            @endcan

            @can('admin-pengaturan-absensi')
            <li class="nav-item"><a class="nav-link {{session()->get('tab_active') == 'zonasi' ? 'active' : ''}}"
                    data-toggle="tab" href="#zonasi" role="tab">PRESENSI</a></li>
            @endcan
        </ul>
    </div>

    <div class="row mt-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show {{session()->get('tab_active') == 'general' || empty(session()->get('tab_active')) ? 'active' : ''}}"
                            id="general" role="tabpanel" aria-labelledby="general-tab">
                            <form action="{{$route_update}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input class="form-control" type="hidden" name="tab_val" value="general">
                                <input class="form-control" type="hidden" name="id" value="{{$edit->id}}">
                                <div class="row mg-b-25">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Nama Aplikasi <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="site_name"
                                                value="{{old('site_name') ?? $edit->site_name}}">
                                        </div>
                                    </div><!-- col-4 -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Copyright Footer</label>
                                            <input class="form-control" type="text" name="copyright_footer"
                                                value="{{old('copyright_footer') ?? $edit->copyright_footer}}">
                                        </div>
                                    </div><!-- col-4 -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Telepon <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="phone"
                                                value="{{old('phone') ?? $edit->phone}}">
                                        </div>
                                    </div><!-- col-6 -->
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Email <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="email"
                                                value="{{old('email') ?? $edit->email}}">
                                        </div>
                                    </div><!-- col-6 -->
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Alamat</label>
                                            <textarea class="form-control" rows="7"
                                                name="address">{{old('address') ?? $edit->address}}</textarea>
                                            @if($errors->has('address'))
                                            <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center"
                                                onclick="$(this).remove()">
                                                <small>{{ $errors->first('address') }}</small>
                                                <small aria-hidden="true" class="fa fa-times"
                                                    style="cursor:pointer;"></small>
                                            </div>
                                            @endif
                                        </div>
                                    </div><!-- col-12 -->
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Favico (Max Size: 5MB, Allowed Type:
                                                jpg-jpeg-gif-png)</label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" name="favico" accept="image/*">
                                                <div class="input-group-append">
                                                    <div class="input-group-text bg-info text-light">  
                                                        <i class="fa fa-upload"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($edit->favico != null)
                                        <input type="hidden" name="old_favico" value="{{$edit->favico}}">
                                        <img class="" width="100" src="{{asset('uploads/images/site/'.$edit->favico)}}"
                                            alt="Image">
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Logo (Max Size: 5MB, Allowed Type:
                                                jpg-jpeg-png)</label>
                                            <div class="input-group">
                                                <input type="file" class="form-control" name="logo" accept="image/*">
                                                <div class="input-group-append">
                                                    <div class="input-group-text bg-info text-light">  
                                                        <i class="fa fa-upload"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($edit->logo != null)
                                        <input type="hidden" name="old_logo" value="{{$edit->logo}}">
                                        <img class="" width="100" src="{{asset('uploads/images/site/'.$edit->logo)}}"
                                            alt="Image">
                                        @endif
                                    </div>
                                </div>

                                @can('admin-pengaturan-update')
                                <button type="submit" class="btn btn-info float-right">{{$button_value}}</button>
                                @endcan
                            </form>
                        </div>
                        <div class="tab-pane fade show {{session()->get('tab_active') == 'zonasi' ? 'active' : ''}}"
                            id="zonasi" role="tabpanel" aria-labelledby="zonasi-tab">
                            <form action="{{$route_update}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input class="form-control" type="hidden" name="tab_val" value="zonasi">
                                <input class="form-control" type="hidden" name="id" value="{{$edit->id}}">
                                {{-- <div class="row">
                                    <div class="col-12 col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label">Geolocation Absensi</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="input-group">
                                                        <span class="input-group-append bg-transparent">
                                                            <label class="rdiobox wd-16">
                                                                <input type="radio" name="is_using_radius" value="1"
                                                                    {{$edit->is_using_radius == 1 ? 'checked':''}}><span></span>
                                                            </label>
                                                        </span>
                                                        <input type="text" class="form-control" disabled value="Aktif">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="input-group">
                                                        <span class="input-group-append bg-transparent">
                                                            <label class="rdiobox wd-16">
                                                                <input type="radio" name="is_using_radius" value="0"
                                                                    {{$edit->is_using_radius == 0 ? 'checked':''}}><span></span>
                                                            </label>
                                                        </span>
                                                        <input type="text" class="form-control" disabled
                                                            value="Non-Aktif">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="row mb-4">
                                    <div class="col-12 col-md-4">
                                        <label class="form-control-label">Aktifkan batas toleransi keterlambatan presensi masuk harian ?</label>
                                        <div class="input-group">
                                            <span class="input-group-append bg-transparent">
                                                <label class="ckbox wd-16">
                                                    <input type="checkbox" name="is_tolerance" value="1"
                                                        {{$edit->is_attendace_daily_tolerance_limit == 1 ? 'checked="checked"':''}}><span></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="form-control-label"> Batas waktu toleransi keterlambatan</label>
                                        <div class="input-group">
                                            <input type="number" name="time_tolerance" class="form-control" value="{{old('time_tolerance') ?? $edit->time_minute_attendance_tolerance_limit_daily}}" >
                                            <div class="input-group-append bg-info text-light" >
                                              Menit
                                            </div>
                                          </div>
                                    </div>
                                </div> --}}
                                <div class="row mb-4">
                                    <div class="col-12 col-md-4">
                                        <label class="form-control-label">Aktifkan auto check-out presensi pulang harian ?</label>
                                        <div class="input-group">
                                            <span class="input-group-append bg-transparent">
                                                <label class="ckbox wd-16">
                                                    <input type="checkbox" name="is_auto_checkout_harian" value="1"
                                                        {{$edit->is_auto_checkout_attendance_daily == 1 ? 'checked="checked"':''}}><span></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <label class="form-control-label"> Menit waktu auto check-out presensi harian</label>
                                        <div class="input-group">
                                            <input type="number" name="time_auto_checkout" class="form-control" value="{{old('time_auto_checkout') ?? $edit->time_minute_auto_checkout_attendance_daily}}" >
                                            <div class="input-group-append">
                                                <div class="input-group-text bg-info text-light">  
                                                    MENIT
                                                </div>
                                            </div>
                                          </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label">Zona Waktu</label>
                                            <select class="form-control" name="timezone">

                                                @if ($timezones)
                                                @foreach ($timezones as $r)
                                                <option value="{{$r->timezone}}"
                                                    {{$edit->timezone == $r->timezone ? 'selected':''}}>
                                                    {{$r->timezone}} -- {{$r->kode}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @if($errors->has('icon'))
                                            <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center"
                                                onclick="$(this).remove()">
                                                <small>{{ $errors->first('icon') }}</small>
                                                <small aria-hidden="true" class="fa fa-times"
                                                    style="cursor:pointer;"></small>
                                            </div>
                                            @endif
                                        </div>
                                    </div><!-- col-4 -->

                                </div>
                                {{-- <div class="row">
                                    <div class="col-12 col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label">Parameter Mulai Jam Lembur</label>
                                            <input type="time" type="text" class="form-control" value="{{$edit->start_overtime}}">
                                        </div>
                                    </div><!-- col-4 -->

                                </div> --}}
                                @can('admin-pengaturan-update')
                                <button type="submit" class="btn btn-info float-right">{{$button_value}}</button>
                                @endcan
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('active-settings')
active
@endpush

@push('menuOpen-settings')
style="display: block;"
@endpush

@push('showSub-settings')
show-sub
@endpush


@push('styles')
<link href="{{asset('template/backend')}}/lib/medium-editor/medium-editor.css" rel="stylesheet">
<link href="{{asset('template/backend')}}/lib/medium-editor/default.css" rel="stylesheet">
<link href="{{asset('template/backend')}}/lib/summernote/summernote-bs4.css" rel="stylesheet">
@endpush
@push('scripts')
<script src="{{asset('template/backend')}}/lib/summernote/summernote-bs4.min.js"></script>
<script src="{{asset('template/backend')}}/lib/medium-editor/medium-editor.js"></script>
<script>
    $('#about, #visi, #misi').summernote({
        height: 200,
        toolbar: [
            // ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            // ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'hr']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview']],
            // ['help', ['help']]
        ]
    });

</script>
@endpush
