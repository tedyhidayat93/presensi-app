<?php

namespace App\Exports;

use App\Models\InOut;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;

class AttendanceExport implements FromQuery, WithMapping, WithCustomStartCell, ShouldAutoSize, WithColumnWidths, WithStyles, WithEvents, WithColumnFormatting
{
    use Exportable;

    private $from;
    private $to;
    private $status;
    private $tipe;
    
    public function fromDate($from)
    {
        $this->from = $from ?? null;
        return $this;
    }
    public function toDate($to)
    {
        $this->to = $to ?? null;
        return $this;
    }
    public function status($status)
    {
        $this->status = $status ?? null;
        return $this;
    }
    public function tipe($tipe)
    {
        $this->tipe = $tipe ?? null;
        return $this;
    }

    public function query()
    {
        // $query = User::where(['is_active' => 1, 'role' => 'user'])->orderBy('full_name', 'ASC')->get();    
        // return view('pages.admin.exports.users', [
            //     'users' => $query
            // ]);
            
        $data = User::query();    
        
        // if( $this->from != null && $this->to != null) {
        //     $data = $data->whereDate('created_at', '>=', $this->from)->whereDate('created_at', '<=', $this->to);
        // }

        if( $this->status != null && $this->status != 'all') {
            $data = $data->where('status', $this->status);
        }

        if( $this->tipe != null && $this->tipe != 'all') {
            $data = $data->where('type', $this->tipe);
        }

        $data = $data->where(['role' => 'user'])->orderBy('full_name', 'ASC');
        return $data;
    }

    
    public function map($usr): array
    {

        // $tanggal_keluar = '-';
        // $startDate = Carbon::parse($user->tanggal_masuk);
        // if($user->is_active == 1) {
        //     $is_active = 'Aktif';
        //     $endDate = Carbon::now();
        // } else {
        //     $is_active = 'Non Aktif';
        //     $tanggal_keluar = date('d/m/Y', strtotime($user->tanggal_keluar));
        //     $endDate = Carbon::parse($user->tanggal_keluar);
        // }
        // $duration = $endDate->diff($startDate);
        // $masa_kerja =  $duration->format('%y tahun %m bulan');
        
        // return [
        //     $user->full_name,
        //     $user->gender,
        //     $user->nik,
        //     $user->email,
        //     $user->phone,
        //     $user->address,
        //     $user->education->education ?? '-',
        //     $user->nip,
        //     $user->status,
        //     $user->type == 'staff' ? 'Staff' : 'Non Staff',
        //     $user->jabatan->type ?? '-',
        //     date('d/m/Y', strtotime($user->tanggal_masuk)),
        //     $tanggal_keluar,
        //     $masa_kerja,
        //     // date('d/m/Y', strtotime($user->registered_at))
        // ];


        // total hari kerja
        $start = new Carbon($this->from); 
        $end = new Carbon($this->to);
        $total_working_days = 0;
        for ($date = $start; $date->lte($end); $date->addDay()) {
            if ($date->isWeekday() || $date->dayOfWeek === Carbon::SATURDAY) {
                $total_working_days++;
            }
        }

        // parsing jenis kelamin
        $gender = '-';
        if($usr->gender == 'L') {
            $gender = 'Laki-Laki';
        }elseif($usr->gender == 'P') {
            $gender = 'Perempuan';
        }else {
            $gender = 'Undefine';
        }

        // parsing foto
        if ($usr->photo_profile != null) 
        {
            $foto = asset('uploads/images/employee/'. $usr->photo_profile);
        }
        else
        {
            $foto = asset('images/default-ava.jpg');
        }

       $total_hari_hadir = 0;
       $total_izin = 0;
       $total_hari_lembur = 0;
       $total_hari_tidak_hadir = 0;

        
        // total absen harian
        $total_hari_hadir = InOut::where('is_active', 1)->where('employee_id', $usr->id);
        if($this->from != null && $this->to != null) {
            $total_hari_hadir = $total_hari_hadir->whereDate('date', '>=', $this->from);
            $total_hari_hadir = $total_hari_hadir->whereDate('date', '<=', $this->to);
        }
        $total_hari_hadir = $total_hari_hadir->where('type', 'absen_biasa')->count();
                
        // total absen lembur
        $total_hari_lembur = InOut::where('is_active', 1)->where('employee_id', $usr->id);
        if($this->from != null && $this->to != null) {
            $total_hari_lembur = $total_hari_lembur->whereDate('date', '>=', $this->from);
            $total_hari_lembur = $total_hari_lembur->whereDate('date', '<=', $this->to);
        }
        $total_hari_lembur = $total_hari_lembur->where('type', 'absen_lembur')->count();
     
        // total absen izin 
        $total_izin = InOut::where('is_active', 1)->where('employee_id', $usr->id);
        if($this->from != null && $this->to != null) {
            $total_izin = $total_izin->whereDate('date', '>=', $this->from);
            $total_izin = $total_izin->whereDate('date', '<=', $this->to);
        }
        $total_izin = $total_izin->where('type', 'absen_izin')->count();

        // Total Jam Kerja 
        $total_jam_kerja = InOut::where('is_active', 1)->where('employee_id', $usr->id);
        if($this->from != null && $this->to != null) {
            $total_jam_kerja = $total_jam_kerja->whereDate('date', '>=', $this->from);
            $total_jam_kerja = $total_jam_kerja->whereDate('date', '<=', $this->to);
        }
        $total_jam_kerja = $total_jam_kerja->where('type', 'absen_biasa');
        $total_jam_kerja = $total_jam_kerja->sum('total_work');
        $total_jam_kerja = \App\Helpers\General::convertSecondToStringTime($total_jam_kerja);
        
        // Total Jam Lembur
        $total_jam_lembur = InOut::where('is_active', 1)->where('employee_id', $usr->id);
        if($this->from != null && $this->to != null) {
            $total_jam_lembur = $total_jam_lembur->whereDate('date', '>=', $this->from);
            $total_jam_lembur = $total_jam_lembur->whereDate('date', '<=', $this->to);
        }
        $total_jam_lembur = $total_jam_lembur->where('type', 'absen_lembur');
        $total_jam_lembur = $total_jam_lembur->sum('overtime');
        $total_jam_lembur = \App\Helpers\General::convertSecondToStringTime($total_jam_lembur);
        
        // Total Jam Telat
        $total_jam_telat = InOut::where('is_active', 1)->where('employee_id', $usr->id);
        if($this->from != null && $this->to != null) {
            $total_jam_telat = $total_jam_telat->whereDate('date', '>=', $this->from);
            $total_jam_telat = $total_jam_telat->whereDate('date', '<=', $this->to);
        }
        $total_jam_telat = $total_jam_telat->where('type', 'absen_biasa');
        $total_jam_telat = $total_jam_telat->sum('late');
        $total_jam_telat = \App\Helpers\General::convertSecondToStringTime($total_jam_telat);

        // Total tidak hadir (ALFA)
        $total_hari_tidak_hadir = (int)$total_working_days - (int)$total_hari_hadir;


        $list_user[] = [
            'full_name' => $usr->full_name,
            'gender' => $gender,
            'nik' => $usr->nik ?? null,
            'nip' => $usr->nip ?? null,
            'status' => $usr->status == 'tetap' ? 'Tetap' : 'Kontrak',
            'type' => $usr->type == 'staff' ? 'STAFF' : 'NON STAFF',
            'jabatan' => $usr->jabatan->type ?? '-',
            // 'foto' => $foto,
            // 'data_absen' => [
            //     ]
            'total_hari_hadir' => $total_hari_hadir,
            'total_jam_kerja' => $total_jam_kerja,
            'total_jam_terlambat' => $total_jam_telat,
            'total_hari_lembur' => $total_hari_lembur,
            'total_jam_lembur' => $total_jam_lembur,
            'total_izin' => $total_izin,
            'total_hari_alfa' => $total_hari_tidak_hadir,
        ];


        return $list_user;
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('F')->setWidth(40, 'pt');
        return [
             // Styling an entire ROW.
            'A2:G2'    => [
                'font' => [
                    'size' => 11,
                    'bold' => true,
                    'color' => ['rgb' => 'fff'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => 'ffcd69']
                ],
            ],
            'A3:G3'    => [
                'font' => [
                    'size' => 10,
                    'bold' => true,
                    'color' => ['rgb' => '000'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => 'ffe5b0']
                ],
            ],
            '1'    => [
                'font' => [
                    'size' => 13,
                    'bold' => true,
                    'color' => ['rgb' => '000'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
               
            ],
            'H:N'=> [
                'font' => [
                    'size' => 10,
                    'bold' => false,
                    'color' => ['rgb' => '000'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
               
            ],
            'H2:N2'    => [
                'font' => [
                    'size' => 11,
                    'bold' => true,
                    'color' => ['rgb' => 'fff'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => 'd1ffb8']
                ],
            ],
            'H3:N3'    => [
                'font' => [
                    'size' => 10,
                    'bold' => true,
                    'color' => ['rgb' => '000'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => 'f0ffe8']
                ],
            ],
        ];
    }
    public function columnWidths(): array
    {
        return [
            'F' => 100,            
        ];
    }

    public function columnFormats(): array
    {
        return [
            // 'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'C' => '#',
            // 'H:N' => '0',
        ];
    }
    
    public function registerEvents(): array {
        
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                $sheet->mergeCells('A1:N1');
                $sheet->mergeCells('A2:G2');
                $sheet->mergeCells('H2:N2');
                
                
                $sheet->setCellValue('A1', "REKAP DATA KEHADIRAN KARYAWAN PT. MAGGIOLLINI INDONESIA PER : " . date('d-F-Y', strtotime($this->from)) . " s/d " . date('d-F-Y', strtotime($this->to)) );
                
                $sheet->setCellValue('A2', "Data Karyawan");
                $sheet->setCellValue('H2', "Rekapitulasi Absensi");

                // $sheet->mergeCells('C1:D1');
                $sheet->setCellValue('A3', "Nama");
                $sheet->setCellValue('B3', "Jenis Kelamin");
                $sheet->setCellValue('C3', "No. KTP");
                $sheet->setCellValue('D3', "NIP");
                $sheet->setCellValue('E3', "Status");
                $sheet->setCellValue('F3', "Tipe");
                $sheet->setCellValue('G3', "Jabatan");
                $sheet->setCellValue('H3', "Total Hadir");
                $sheet->setCellValue('I3', "Total Jam Kerja");
                $sheet->setCellValue('J3', "Total Terlambat");
                $sheet->setCellValue('K3', "Total Lembur");
                $sheet->setCellValue('L3', "Total Jam Lembur");
                $sheet->setCellValue('M3', "Total Izin");
                $sheet->setCellValue('N3', "Total Tidak Hadir");
                // $sheet->setCellValue('O2', "Tanggal Didaftarkan");

                $sheet->getDelegate()->getRowDimension('1')->setRowHeight(20);
                $sheet->getDelegate()->getRowDimension('2')->setRowHeight(30);

                // $sheet->getStyle('C')
                // ->getAlignment()
                // ->setWrapText(false);

                // $sheet->getColumnDimension('F')
                // ->getAlignment()
                // ->setWrapText(true);
                
                $styleArray = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];
                
                $cellRange = 'A1:N1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
            },
            BeforeSheet::class => function (BeforeSheet $event) {
                $event->sheet
                    ->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet
                    ->getPageSetup()
                    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A3);
            },
        ];
    }

}
