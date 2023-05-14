<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;

class UsersExport implements FromQuery, WithMapping, WithCustomStartCell, ShouldAutoSize, WithColumnWidths, WithStyles, WithEvents, WithColumnFormatting
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
        
        if( $this->from != null && $this->to != null) {
            $data = $data->whereDate('created_at', '>=', $this->from)->whereDate('created_at', '<=', $this->to);
        }

        if( $this->status != null) {
            $data = $data->where('status', $this->status);
        }

        if( $this->tipe != null) {
            $data = $data->where('type', $this->tipe);
        }

        $data = $data->where(['role' => 'user'])->orderBy('full_name', 'ASC');
        return $data;
    }

    
    public function map($user): array
    {

        $tanggal_keluar = '-';
        $startDate = Carbon::parse($user->tanggal_masuk);
        if($user->is_active == 1) {
            $is_active = 'Aktif';
            $endDate = Carbon::now();
        } else {
            $is_active = 'Non Aktif';
            $tanggal_keluar = date('d/m/Y', strtotime($user->tanggal_keluar));
            $endDate = Carbon::parse($user->tanggal_keluar);
        }
        $duration = $endDate->diff($startDate);
        $masa_kerja =  $duration->format('%y tahun %m bulan');
        
        return [
            $user->full_name,
            $user->gender,
            $user->nik,
            $user->email,
            $user->phone,
            $user->address,
            $user->education->education ?? '-',
            $user->nip,
            $user->status,
            $user->type == 'staff' ? 'Staff' : 'Non Staff',
            $user->jabatan->type ?? '-',
            date('d/m/Y', strtotime($user->tanggal_masuk)),
            $tanggal_keluar,
            $masa_kerja,
            // date('d/m/Y', strtotime($user->registered_at))
        ];
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('F')->setWidth(40, 'pt');
        return [
             // Styling an entire ROW.
            'A2:N2'    => [
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
                    'color' => ['rgb' => 'ffca42']
                ],
            ],
            '1'    => [
                'font' => [
                    'size' => 15,
                    'bold' => true,
                    'color' => ['rgb' => '000'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
               
            ]
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
        ];
    }
    
    public function registerEvents(): array {
        
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                $sheet->mergeCells('A1:N1');
                
                
                $sheet->setCellValue('A1', "DATA KARYAWAN PT. MAGGIOLLINI INDONESIA PER TANGGAL : " . date('d-F-Y'));

                // $sheet->mergeCells('C1:D1');
                $sheet->setCellValue('A2', "Nama");
                $sheet->setCellValue('B2', "Jenis Kelamin");
                $sheet->setCellValue('C2', "No. KTP");
                $sheet->setCellValue('D2', "email");
                $sheet->setCellValue('E2', "No. Telp");
                $sheet->setCellValue('F2', "Alamat");
                $sheet->setCellValue('G2', "Pendidikan Terakhir");
                $sheet->setCellValue('H2', "NIP");
                $sheet->setCellValue('I2', "Status");
                $sheet->setCellValue('J2', "Tipe");
                $sheet->setCellValue('K2', "Jabatan");
                $sheet->setCellValue('L2', "Tanggal Masuk");
                $sheet->setCellValue('M2', "Tanggal Keluar");
                $sheet->setCellValue('N2', "Masa Kerja");
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
        ];
    }

}
