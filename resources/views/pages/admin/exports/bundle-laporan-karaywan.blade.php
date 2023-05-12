
<table>
    <thead>
        <tr>
            <th colspan="3" style="font-size: 20pt; font-weight:bold;">LAPORAN KEHADIRAN KARYAWAN</th>
        </tr>
        <tr>
            <th colspan="3">PT. MAGGIOLLINI INDONESIA</th>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right; color:gray;">Generate By System: <i> E-Kehadiran https://absensi.maggioapps.com </i></td>
        </tr>
        <tr>
            <th style="color:#000000;">Jenis</th>
            <th style="color:#00008e;">
                @if (request()->query('jenis_presensi') == 'absen_biasa')
                Presensi Harian
                @elseif (request()->query('jenis_presensi') == 'absen_lembur')
                Presensi Lembur
                @endif
            </th>
        </tr>
        <tr>
            <th style="color:#000000;">Periode</th>
            <th style="color:#008000;">
                {{ date('d-m-Y', strtotime($start)); }} 
                sampai
                {{ date('d-m-Y', strtotime($end)); }}
            </th>
        </tr>
        <tr>
            <th style="color:#000000;">Hari Kerja</th>
            <th>
                {{$total_working_days}} Hari (Tanpa Hari Minggu)
            </th>
        </tr>
        <tr>
            <th>Tipe Pegawai</th>
            <th>
                @if (request()->query('type') == 'all')
                Staff dan Non Staff
                @elseif (request()->query('type') == 'staff')
                Staff
                @elseif (request()->query('type') == 'non_staff')
                Non Staff
                @endif
            </th>
        </tr>
        <tr></tr>
    </thead>

    <thead>
        
        <tr>
            <th>No</th>
            <th >Nama Karyawan </th>
            @if (request()->query('jenis_presensi') == 'absen_biasa')
                <th style="background: #00A2FF; color:#0c0c0c;">Hadir</th>
                <th style="background: #00A2FF; color:#0c0c0c;">Tidak <br> Hadir </th>
                <th style="background: #00A2FF; color:#0c0c0c;">Izin </th>
                <th style="background: #00A2FF; color:#0c0c0c;">Telat </th>
                <th style="background: #00A2FF; color:#0c0c0c;">Total <br> Jam Kerja</th>
                <th style="background: #00A2FF; color:#0c0c0c;">Total <br> Jam Telat</th>
            @elseif (request()->query('jenis_presensi') == 'absen_lembur')
                <th style="background: #0077FF; color:#1a1a1a;">Total <br> Jam Lembur</th>
                @foreach ($jenis_lembur as $lembur)
                    <th style="background: #00A2FF; color:#0c0c0c;">{{$lembur->type}}</th>
                @endforeach
            @elseif (request()->query('jenis_presensi') == 'absen_biasa_lembur')
                <th style="background: #00A2FF; color:#0c0c0c;">Hadir Harian</th>
                <th style="background: #00A2FF; color:#0c0c0c;">Tidak Hadir <br> Harian </th>
                <th style="background: #00A2FF; color:#0c0c0c;">Izin </th>
                <th style="background: #00A2FF; color:#0c0c0c;">Telat Harian</th>
                <th style="background: #00A2FF; color:#0c0c0c;">Total <br> Jam Kerja Harian</th>
                <th style="background: #00A2FF; color:#0c0c0c;">Total <br> Jam Telat Harian</th>
                <th style="background: #00A2FF; color:#1a1a1a;">Total <br> Jam Lembur</th>
                @foreach ($jenis_lembur as $lembur)
                    <th style="background: #00A2FF; color:#0c0c0c;">{{$lembur->type}}</th>
                @endforeach
            @endif

            @php
                $tanggal = clone $start;
                while ($tanggal->lte($end)) {
                    
                    if ($tanggal->isWeekday() || $tanggal->dayOfWeek === \Carbon\Carbon::SATURDAY) {
                        $total_working_days++;
                    }
                    $libur_cek = \App\Helpers\General::tanggalMerahOnline($tanggal->format('Ymd'));

                    if ($libur_cek['libur'] == true && $libur_cek['ket'] == null) {
                        $tr = 'style="background: #FF2F00; color:white;"';
                        $libur_keterangan = 'Libur';
                    }
                    elseif ($libur_cek['libur'] == true && $libur_cek['ket'] != null) 
                    {
                        $tr = 'style="background: #FF9900; color:white;"';
                        $libur_keterangan = $libur_cek['ket'];
                    }
                    elseif ($libur_cek['libur'] == false && $libur_cek['ket'] == null)
                    {
                        $tr = 'style="background: #00FF2A; color:black;"';
                        $libur_keterangan = 'Hari Kerja';
                    }

                    echo "<th ".$tr."><span title='".$libur_keterangan."'>".$tanggal->format('d M Y')."</span></th>";
                    // echo "<th class='".$tr."'><span class='trigger' title='".$libur_keterangan."'>".$tanggal->format('d M Y')."</span><div class='pop-up'>".$libur_keterangan."</div></th>";
                    $tanggal->addDay();
                }
            @endphp
            
        </tr>
    </thead>
    <tbody>
        @php
            $i=1;
        @endphp
        @foreach ($list_user as $row) 
            <tr>
            <td>{{$i++}}.</td>
            <td class="d-flex flex-column">
                <span class="text-dark font-weight-bold mb-1"> {{$row['full_name']}} </span>
            </td>
            
            @if (request()->query('jenis_presensi') == 'absen_biasa')
                <td>{{$row['kalkulasi']['total_hari_hadir']}}</td>
                <td>{{$row['kalkulasi']['total_hari_alfa']}}</td>
                <td>{{$row['kalkulasi']['total_izin']}}</td>
                <td>{{$row['kalkulasi']['total_telat']}}</td>
                <td>{{$row['kalkulasi']['total_jam_kerja']}}</td>
                <td>{{$row['kalkulasi']['total_jam_terlambat']}}</td>
            @elseif (request()->query('jenis_presensi') == 'absen_lembur')
                <td>{{$row['kalkulasi']['total_jam_lembur']}}</td>
                @foreach ($jenis_lembur as $lembur)
                    <td>{{$row['kalkulasi']['total_jenis_lembur'][$row['usr_id']][$lembur->slug]['total']}}</td>
                @endforeach
            @elseif (request()->query('jenis_presensi') == 'absen_biasa_lembur')
                <td>{{$row['kalkulasi']['total_hari_hadir']}}</td>
                <td>{{$row['kalkulasi']['total_hari_alfa']}}</td>
                <td>{{$row['kalkulasi']['total_izin']}}</td>
                <td>{{$row['kalkulasi']['total_telat']}}</td>
                <td>{{$row['kalkulasi']['total_jam_kerja']}}</td>
                <td>{{$row['kalkulasi']['total_jam_terlambat']}}</td>
                <td>{{$row['kalkulasi']['total_jam_lembur']}}</td>
                @foreach ($jenis_lembur as $lembur)
                    <td>{{$row['kalkulasi']['total_jenis_lembur'][$row['usr_id']][$lembur->slug]['total']}}</td>
                @endforeach
            @endif
            

                @for ($hari = 1; $hari <= $end->diffInDays($start) + 1; $hari++)
                <td style="{{ $detail_presensi[$row['usr_id']][$hari]['td_color'] }}">
                    <small>
                        @if( $detail_presensi[$row['usr_id']][$hari]['hari'] == 'Sun' && $detail_presensi[$row['usr_id']][$hari]['jam'] == null)
                            libur
                        @else 
                            @if ($detail_presensi[$row['usr_id']][$hari]['jam'] != null)
                                @foreach ($detail_presensi[$row['usr_id']][$hari]['jam'] as $key => $val)
                                    @if ($val['izin'] != null)
                                        <span>
                                            <b style="color:#2063FF;">IZIN</b>
                                            <br> 
                                            <span style="color:#002680;"> {{ $val['izin'] }}</span>
                                            <br>
                                        </span>
                                    @else
                                            <span {!! $val['late'] != null ? 'style="color: red;"' : '' !!}>
                                                @if ($val['jenis_lembur'] != null)
                                                    <b> <span> {{ $val['jenis_lembur'] }} </span></b>
                                                    <br>
                                                @else
                                                    @if (request()->query('jenis_presensi') == 'absen_biasa_lembur')
                                                    <b> <span> Presensi Harian</span> </b>
                                                    <br>
                                                    @endif
                                                @endif
                                                <b> IN: </b> <span style="{!! $val['late'] != null ? 'color: red;' : 'color: red;' !!}"> {{ $val['in'] }}</span>
                                                <br>
                                                <b> OUT: </b> <span>  {{ $val['out'] }}</span> 
                                                <br>
                                                <br>
                                            </span>
                                    @endif
                                @endforeach
                            @else
                                Tidak Hadir
                            @endif
                        @endif
                    </small>
                </td>
            @endfor
            </tr> 
            @endforeach
    </tbody>
</table>
