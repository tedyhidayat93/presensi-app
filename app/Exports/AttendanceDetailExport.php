<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;



class AttendanceDetailExport implements FromView, WithColumnWidths, WithEvents, WithStyles,ShouldAutoSize
{
    use Exportable;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;

    }
    
    public function view(): View
    {
        // return $this->data;
        return view('pages.admin.exports.detail-laporan-karaywan', [
            'from_date' => $this->data[0]['from_date'],
            'to_date' => $this->data[0]['to_date'],
            
            'total_working_days' => $this->data[0]['total_working_days'],
            'total_days' => $this->data[0]['total_days'],
            'user' => $this->data[0]['user'],
            'jenis_lembur' => $this->data[0]['jenis_lembur'],
            'total_hari_hadir' => $this->data[0]['total_hari_hadir'],
            'total_alfa' => $this->data[0]['total_alfa'],
            'total_telat' => $this->data[0]['total_telat'],
            'total_izin' => $this->data[0]['total_izin'],
            'total_hari_lembur' => $this->data[0]['total_hari_lembur'],
            'total_jam_telat' => $this->data[0]['total_jam_telat'],
            'total_jam_lembur' => $this->data[0]['total_jam_lembur'],
            'total_jam_kerja' => $this->data[0]['total_jam_kerja'],
            'dates' => $this->data[0]['dates']
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 50,
            // 'B' => 45,            
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
             // Styling an entire ROW.
            34    => [
                'font' => [
                    'size' => 13,
                    'bold' => true,
                    'color' => ['rgb' => '000'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            35    => [
                'font' => [
                    'size' => 13,
                    'bold' => true,
                    'color' => ['rgb' => '000'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            'B:AZ'    => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                ],
            ],
        ];
    }



    public function registerEvents(): array {
        
        return [
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
