<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class AttendanceExport implements FromView, ShouldAutoSize, WithEvents, WithStyles
{
    use Exportable;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;

    }
    
    public function view(): View
    {
        return view('pages.admin.exports.bundle-laporan-karaywan', [
            'type'                      => $this->data[0]['tipe_pegawai'],
            'jenis_presensi'            => $this->data[0]['jenis_presensi'],
            'start'                     => $this->data[0]['start'],
            'end'                       => $this->data[0]['end'],
            'data'                      => $this->data[0]['data'],
            'list_user'                 => $this->data[0]['list_user'],
            'users'                     => $this->data[0]['users'],
            'detail_presensi'           => $this->data[0]['detail_presensi'],
            'jenis_lembur'              => $this->data[0]['jenis_lembur'],
            'list_total_jenis_lembur'   => $this->data[0]['list_total_jenis_lembur'],
            'total_working_days'        => $this->data[0]['total_working_days']
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
             // Styling an entire ROW.
            8    => [
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
            9 => [
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
            'B' => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            'C:ZZ' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            'A'    => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            'A1'    => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ],
            ],
            'A2'    => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ],
            ]
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
                    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A2_PAPER);
            },
        ];
    }
}
