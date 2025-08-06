<?php

namespace App\Exports;

use App\Models\Proposal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\Color;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ProposalExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents, WithColumnWidths

{
    private $rowNumber = 0;
    private $totalRows = 0;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
        $this->totalRows = $data->count();
    }

    // public function collection()
    // {
    //     $data = Proposal::with(['tipologi', 'tipeProses', 'namaPic'])->get();
    //     $this->totalRows = $data->count(); // untuk menentukan jumlah baris nanti
    //     return $data;
    // }

    public function collection()
    {
        return $this->data;
    }

    public function map($item): array
    {
        $this->rowNumber++;

        // Ambil subproses dari tipeProses
        $subprosesList = $item->tipeProses?->subProses ?? collect();

        $berkasOutput = $subprosesList->map(function ($subproses) use ($item) {
            $checked = $subproses->checklistForProposal($item->id)?->is_checked ?? false;
            return $subproses->nama_sub . ' ' . ($checked ? '✓' : '✗');
        })->implode("  "); // Spasi ganda antar item

        return [
            $this->rowNumber,
            $item->judul,
            $item->instansi_pengajuan,
            $item->lokasi,
            $item->tanggal_disposisi ? Carbon::parse($item->tanggal_disposisi)->format('d-M-y') : '',
            $item->nominal_pengajuan,
            $item->barang_pengajuan,
            $item->tipologi->kode ?? '-',
            $item->status,
            $item->nominal_disetujui,
            $item->barang_disetujui,
            $item->namaPic->nama ?? '-',
            $item->tipeProses->nama ?? '-',
            $berkasOutput,  // kolom ke-17: Berkas
            $item->keterangan,
            $item->overdue ? Carbon::parse($item->overdue)->format('d-M-y') : '',
            $item->progress !== null ? $item->progress . '%' : '0%',
        ];
    }


    public function headings(): array
    {
        return [
            'No',
            'Judul',
            'Instansi',
            'Lokasi',
            'Tanggal',
            'Nominal Pengajuan',
            'Barang Pengajuan',
            'Tipologi',
            'Status',
            'Nominal Disetujui',
            'Barang Disetujui',
            'PIC',
            'Proses',
            'Berkas', // heading baru
            'Keterangan',
            'Overdue',
            'Progress (%)',
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $totalRows = $this->totalRows + 1; // +1 untuk header
                $sheet = $event->sheet->getDelegate();
                $sheet->freezePane('C2');

                // Format angka jadi Rupiah (kolom F dan J)
                $sheet->getStyle("F2:F{$totalRows}")
                    ->getNumberFormat()
                    ->setFormatCode('"Rp" #,##0');

                $sheet->getStyle("J2:J{$totalRows}")
                    ->getNumberFormat()
                    ->setFormatCode('"Rp" #,##0');

                for ($row = 2; $row <= $totalRows; $row++) {
                    // Dropdown untuk kolom Status (kolom ke-9 / I)
                    $statusValidation = $sheet->getCell("I{$row}")->getDataValidation();
                    $statusValidation->setType(DataValidation::TYPE_LIST);
                    // $statusValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $statusValidation->setAllowBlank(true);
                    $statusValidation->setShowDropDown(true);
                    $statusValidation->setFormula1('"Pending,Disetujui,Ditolak"');

                    // Dropdown untuk kolom Tipologi (kolom ke-8 / H)
                    $tipologiValidation = $sheet->getCell("H{$row}")->getDataValidation();
                    $tipologiValidation->setType(DataValidation::TYPE_LIST);
                    // $tipologiValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $tipologiValidation->setAllowBlank(true);
                    $tipologiValidation->setShowDropDown(true);
                    $tipologiValidation->setFormula1('"CRTY,EMPW,CABD,INFRST,KLBS"');

                    // Dropdown untuk kolom Tipologi (kolom ke-8 / H)
                    $tipologiValidation = $sheet->getCell("L{$row}")->getDataValidation();
                    $tipologiValidation->setType(DataValidation::TYPE_LIST);
                    // $tipologiValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $tipologiValidation->setAllowBlank(true);
                    $tipologiValidation->setShowDropDown(true);
                    $tipologiValidation->setFormula1('"Ibnu,Dita,Wiji,Javas,Alief, Nanda"');
                    // Dropdown untuk kolom Tipologi (kolom ke-8 / H)

                    $tipologiValidation = $sheet->getCell("M{$row}")->getDataValidation();
                    $tipologiValidation->setType(DataValidation::TYPE_LIST);
                    // $tipologiValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $tipologiValidation->setAllowBlank(true);
                    $tipologiValidation->setShowDropDown(true);
                    $tipologiValidation->setFormula1('"Pembayaran Langsung,NPO,PO"');
                }
            }
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,    // No
            'B' => 35,   // Judul
            'C' => 30,   // Instansi
            // 'C' => 25,   // Instansi
            'F' => 15,   // Instansi
            'G' => 15,   // Instansi
            'J' => 15,   // Instansi
            'K' => 15,   // Instansi
            'L' => 7,   // Instansi
            'D' => 20,   // Instansi
            'N' => 15,   // Kolom Berkas (misalnya)
            'Q' => 5,   // Kolom Berkas (misalnya)
            // tambahkan sesuai kebutuhan
        ];
    }


    public function styles(Worksheet $sheet)
    {
        $totalDataRows = $this->totalRows + 1; // +1 untuk heading
        $range = 'A1:Q' . $totalDataRows;

        // Style untuk heading saja
        $sheet->getStyle('A1:Q1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], // teks putih
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '78C841'], // hijau
            ],
        ]);

        // Style border untuk seluruh data termasuk heading
        $sheet->getStyle($range)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'], // border hitam
                ],
            ],
        ]);
    }
}
