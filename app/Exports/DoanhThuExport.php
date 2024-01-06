<?php

namespace App\Exports;

use App\Models\DoanhThu;
use App\Models\DonHang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DoanhThuExport implements FromCollection, WithHeadings, WithEvents, WithMapping, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'Tháng',
            'Doanh thu',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:B1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
                $event->sheet->getStyle('A1:B13')->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ]
                ]);
                $event->sheet->getStyle('B2:B13')->getNumberFormat()
                    ->setFormatCode('#,##0 [$VNĐ]');
                // $event->sheet->getCell('B14')->getCalculatedValue();
            },
        ];
    }
    public function prepareRows($rows)
    {
        $sum = 0;
        foreach ($rows as $row) $sum += $row->doanhthu;
        $rows[] = [
            'is_summary' => true,
            'sum_column_1' => $sum
        ];
        return $rows;
    }

    public function map($row): array
    {
        if (isset($row['is_summary']) && $row['is_summary'] === true) {
            //Return a summary row
            return [
                'Tổng tiền:',
                $row['sum_column_1']
            ];
        } else {
            //Return a normal data row
            return [
                $row->thang,
                $row->doanhthu
            ];
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($year)
    {
        $this->year = $year;
    }

    public function collection()
    {
        $doanhThuTungThang = DonHang::join('chi_tiet_don_hangs', 'chi_tiet_don_hangs.don_hang_id', '=', 'don_hangs.ma_don_hang')
            ->where('don_hangs.trang_thai_don_hang', '=', 3)
            ->whereYear('don_hangs.ngay_tao', '=', $this->year)
            ->select(DB::raw("MONTH(don_hangs.ngay_tao) thang"), DB::raw('sum(chi_tiet_don_hangs.gia_giam * chi_tiet_don_hangs.so_luong) doanhthu'))
            ->groupBy('thang')
            ->get();
        // foreach ($doanhThuTungThang as $tp) {
        //     $tp->doanhthu = number_format($tp->doanhthu, 0, ',', '.');
        // }
        return $doanhThuTungThang;
    }
}
