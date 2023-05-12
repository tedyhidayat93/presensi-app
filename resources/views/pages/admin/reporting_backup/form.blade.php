<div class="card-body" style="background-color: #fafafa;">
    <form action="" method="GET" id="filter_form">
        <div class="row">
            
            <div class="col-12 col-md">
                <div class="form-group mb-0 mr-1">
                    <label class="form-control-label">Tipe Pegawai</label>
                    <select name="type" class="form-control" >
                        <option value="all" {{ request()->query('type') == 'all' ? 'selected' : ''}}>Staff & Non Staff</option>
                        <option value="staff" {{ request()->query('type') == 'staff' ? 'selected' : ''}}>Hanya Staff</option>
                        <option value="non_staff" {{ request()->query('type') == 'non_staff' ? 'selected' : ''}}>Hanya Non Staff</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md">
                <div class="form-group mb-0 mr-1">
                    <label class="form-control-label">Jenis Presensi <span class="tx-danger">*</span></label>
                    <select name="jenis_presensi" class="form-control" >
                        <option {{ request()->query('jenis_presensi') == '' ? 'selected' : ''}} value="">-- Pilih Jenis Presensi --</option>
                        <option {{ request()->query('jenis_presensi') == 'all' ? 'absen_harian' : ''}} value="absen_harian">Presensi Harian</option>
                        <option {{ request()->query('jenis_presensi') == 'all' ? 'absen_lembur' : ''}} value="absen_lembur">Presensi Lembur</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md">
                <div class="form-group">
                    <label class="form-control-label">Dari Tanggal <span class="tx-danger">*</span></label>
                    <input class="form-control" type="date" name="from" value="{{old('from') ?? request()->query('from')}}" autocomplete="off">
                    @if($errors->has('type'))
                    <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center" onclick="$(this).remove()">
                        <small>{{ $errors->first('type') }}</small>
                        <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-12 col-md">
                <div class="form-group">
                    <label class="form-control-label">Sampai Tanggal <span class="tx-danger">*</span></label>
                    <input class="form-control" type="date" name="to"
                    value="{{old('to') ?? request()->query('to')}}" autocomplete="off">
                    @if($errors->has('type'))
                    <div class="text-danger mg-t-10 d-flex justify-content-between align-items-center" onclick="$(this).remove()">
                        <small>{{ $errors->first('type') }}</small>
                        <small aria-hidden="true" class="fa fa-times" style="cursor:pointer;"></small>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-12 col-md">
                <label class="form-control-label">&nbsp;</label>
                <br>
                <button class="btn btn-teal btn-block" type="submit"><i class="fa fa-eye"></i> Tampilkan Laporan</button>
            </div>
        </div>
    </form>
</div>
