<table>
    <thead>
        <tr>
            <th colspan="9" style="font-weight:bold; font-size: 20pt;"> Detail Riwayat Presensi Per Karyawan</th>
        </tr>
        <tr>
            <td colspan="9" style="text-align: right; color:gray;">Generate By System: <i> E-Kehadiran https://absensi.maggioapps.com </i></td>
        </tr>
    </thead>
</table>

{{-- Informasi Karyawan --}}
<table>
    <tbody>
        <tr>
            <th style="font-weight:bold;">Nama Lengkap</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">
                {{$user->full_name ?? '-'}}
            </td>
        </tr>
        <tr>
            <th style="font-weight:bold;">Jenis Kelamin</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">
                @php
                $gender = '-';
                if($user->gender == 'L') {
                $gender = 'Laki - Laki';
                }else {
                $gender = 'Perempuan';
                }
                @endphp
                {{$gender}}
            </td>
        </tr>
        <tr>
            <th style="font-weight:bold;">Email</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">{{$user->email ?? '-'}}
            </td>
        </tr>
        <tr>
            <th style="font-weight:bold;">NIK</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">{{$user->nik ?? '-'}}
            </td>
        </tr>
        <tr>
            <th style="font-weight:bold;">NIP</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">{{$user->nip ?? '-'}}
            </td>
        </tr>
        <tr>
            <th style="font-weight:bold;">Tipe</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">{{$user->type == 'staff' ? 'Staff' : 'Non Staff'}}
            </td>
        </tr>
        <tr>
            <th style="font-weight:bold;">Status</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">{{$user->status}}
            </td>
        </tr>
        <tr>
            <th style="font-weight:bold;">Jabatan</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">{{$user->jabatan->type ?? "-"}}
            </td>
        </tr>
        <tr>
            <th style="font-weight:bold;">Pendidikan</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">{{$user->education->education ?? "-"}}
            </td>
        </tr>
        <tr>
            <th style="font-weight:bold;">Tanggal Masuk</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">{{date('d-M-Y', strtotime($user->tanggal_masuk ?? '0000-00-00'))}}
            </td>
        </tr>
        <tr>
            <th style="font-weight:bold;">Masa Kerja</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">
                @php
                $startDate = \Carbon\Carbon::parse($user->tanggal_masuk);
                if($user->is_active == 1) {
                $endDate = \Carbon\Carbon::now();
                } else {
                $endDate = \Carbon\Carbon::parse($user->tanggal_keluar);
                }
                $duration = $endDate->diff($startDate);
                echo $duration->format('%y tahun %m bulan')
                @endphp
            </td>
        </tr>
    </tbody>
</table>

{{-- informasi Rentang tanggal dan hari kerja --}}
<table>
    <tbody>
        <tr>
            <th style="font-weight:bold; font-size: 16pt;" colspan="2">Informasi Periode Cetak</th>
        </tr>
        <tr>
            <th style="font-weight:bold;">Periode</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">
                <b class="text-info">
                    {{ $from_date }}
                </b>
                &nbsp;
                -
                &nbsp;
                <b class="text-info">
                    {{ $to_date }}
                </b>
            </td>
        </tr>
        <tr>
            <th style="font-weight:bold;">Jumlah Hari</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">{{$total_days}} Hari</td>
        </tr>
        <tr>
            <th style="font-weight:bold;">Hari Kerja</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">{{$total_working_days}} Hari</td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="font-weight:bold; font-size: 16pt;" colspan="2">Kalkulasi Total Kehadiran</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th style="font-weight:bold;">Hadir</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">{{$total_hari_hadir}}</td>
        </tr>
        <tr>
            <th style="font-weight:bold;">Lembur</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">{{$total_hari_lembur}}</td>
        </tr>
        <tr>
            <th style="font-weight:bold;">Izin</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">{{$total_izin}}</td>
        </tr>
        <tr>
            <th style="font-weight:bold;">Terlambat</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">{{$total_telat}}</td>
        </tr>
        <tr>
            <th style="font-weight:bold;">Tidak Hadir</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">{{$total_alfa}}</td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="font-weight:bold; font-size: 16pt;" colspan="2">Kalkulasi Jam Kehadiran</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th style="font-weight:bold;">Total Jam Presensi Harian</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">{{$total_jam_kerja}}</td>
        </tr>
        <tr>
            <th style="font-weight:bold;">Total Jam Keterlambatan Presensi Harian</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">{{$total_jam_telat}}</td>
        </tr>
        <tr>
            <th style="font-weight:bold;">Total Seluruh Jam Kerja Lemburan</th>
            <td style="text-align: left; padding-left: 10px; color: blue" colspan="8">{{$total_jam_lembur}}</td>
        </tr>
    </tbody>
</table>

{{-- riwayat detail presensi --}}
<table>
    <thead>
        <tr>
            <th style="font-weight:bold; font-size: 16pt;" colspan="9">Detail Riwayat Presensi</th>
        </tr>
        <tr>
            <th style="text-align: center; font-size: 12pt; font-weight:bold;" rowspan="2">Hari Tanggal</th>
            <th style="text-align: center; font-size: 12pt; font-weight:bold;" colspan="2">Presensi Harian</th>
            @foreach ($jenis_lembur as $lembur)
                <th style="text-align: center; font-size: 12pt; font-weight:bold;"  colspan="2">{{$lembur->type}}</th>
            @endforeach
        </tr>
        <tr>
            <th style="font-weight:bold;">IN</th>
            <th style="font-weight:bold;">OUT</th>
            @foreach ($jenis_lembur as $lembur)
                <th style="font-weight:bold;">IN</th>
                <th style="font-weight:bold;">OUT</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

        @foreach ($dates as $date)

        @if ($date['libur'] == true && $date['ket'] == null)
        @php
        $tr = 'text-align:center; background:red; color:white;';
        $libur_keterangan = '';
        @endphp
        @elseif ($date['libur'] == true && $date['ket'] != null)
        @php
        $tr = 'text-align:center; background:orange; color:black;';
        $libur_keterangan = $date['ket'];
        @endphp
        @elseif ($date['libur'] == false && $date['ket'] == null)
        @php
        $tr = 'text-align:center; background:transparent; color:black;';
        $libur_keterangan = null;
        @endphp
        @endif
        <tr>
            <td style="{!!$tr!!}">
                <b>{{$date['date']}}</b>
                <br>
                {{$libur_keterangan}}
            </td>
            <td style="text-align: center; {!!$date['presensi']['harian']['late'] != null ? 'color: red;' : ''!!}">
                <span style="">
                    {{$date['presensi']['harian']['in']}}
                    <br>
                    {{$date['presensi']['harian']['late'] != null ? 'Telat: '.\Carbon\Carbon::createFromTimestampUTC($date['presensi']['harian']['late'])->format('H:i:s') : ''}}
                </span>
            </td>
            <td style="text-align: center;">
                {{$date['presensi']['harian']['out']}}
                <br>
                @if ($date['presensi']['harian']['is_auto_checkout_daily'] != 0)
                <span style="color: orange;">
                    Auto Checkout System
                </span>
                @endif
            </td>
            @foreach ($jenis_lembur as $lembur)
                <td style="text-align: center;">
                    @if (!empty($date['presensi']['lembur'][$lembur->slug]))
                        @foreach ($date['presensi']['lembur'][$lembur->slug] as $key => $item)
                            {{$item['in'] }}
                            <br>
                        @endforeach
                    @endif
                </td>
                <td style="text-align: center;">
                    @if (!empty($date['presensi']['lembur'][$lembur->slug]))
                        @foreach ($date['presensi']['lembur'][$lembur->slug] as $key => $item)
                            {{$item['out'] }}
                            <small>
                                @if ($item['date_out'] != $date['ymd'])
                                &nbsp; {{ date('d-M-Y', strtotime($item['date_out'])) }}
                                @endif
                            </small>
                            <br>
                        @endforeach
                    @endif
                </td>
            @endforeach
        </tr>
        @endforeach

    </tbody>
</table>

