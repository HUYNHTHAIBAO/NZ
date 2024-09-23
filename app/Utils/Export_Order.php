<?php

namespace App\Utils;
use App\Models\Orders;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;


class Export_Order implements FromView {
    use Exportable;
    private $date_start;
    private $date_end;

    public function __construct($date_start = null, $date_end = null)
    {
        $this->date_start = $date_start;
        $this->date_end = $date_end;
    }

    public function view(): View
    {
        $query = Orders::get();

        if ($this->date_start && $this->date_end) {
            $query->whereBetween('lck_orders.created_at', [$this->date_start, $this->date_end]);
        }
        $this->data['data'] = $query;
        return view('backend.orders.export', $this->data);
    }
}


//class Export_Order  implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
//{
//    private $date_start;
//    private $date_end;
//
//    public function __construct($date_start = null, $date_end = null)
//    {
//        $this->date_start = $date_start;
//        $this->date_end = $date_end;
//    }
//
//
//    public function collection()
//    {
//        $query = Orders::select(
//            'lck_orders.id',
//            'lck_orders.fullname',
//            'lck_orders.phone',
//            'lck_orders.address',
//            'lck_orders.total_price',
//            DB::raw('CASE
//            WHEN lck_orders.status = 1 THEN "Mới đặt"
//            WHEN lck_orders.status = 2 THEN "Đã xác nhận"
//            WHEN lck_orders.status = 3 THEN "Đang giao"
//            WHEN lck_orders.status = 4 THEN "Hoàn thành"
//            WHEN lck_orders.status = 5 THEN "Hủy"
//            ELSE "Không xác định"
//            END AS status_name')
//        );
//
//        if ($this->date_start && $this->date_end) {
//            $query->whereBetween('lck_orders.created_at', [$this->date_start, $this->date_end]);
//        }
//        return $query->get();
//    }
//
//    public function headings(): array
//    {
//        return [
//            'Mã hóa đơn',
//            'Tên khách hàng',
//            'Số điện thoại',
//            'Địa chỉ',
//            'Tổng tiền',
//            'Trạng thái',
//        ];
//    }
//
//    public function map($row): array
//    {
//
//        return [
//            $row->id,
//            $row->fullname,
//            $row->phone,
//            $row->address,
//            $row->total_price,
//            $row->status_name  , // Trạng thái đã được ánh xạ
//        ];
//    }
//
//
//    public function styles(Worksheet $sheet)
//    {
//        $styleHeading = [
//            'font' => [
//                'bold' => true,
//                'color' => ['argb' => 'FFFFFF'],
//            ],
//            'fill' => [
//                'fillType' => Fill::FILL_SOLID,
//                'startColor' => [
//                    'argb' => '0070C0',
//                ],
//            ],
//            'borders' => [
//                'allBorders' => [
//                    'borderStyle' => Border::BORDER_THIN,
//                    'color' => ['argb' => '000000'],
//                ],
//            ],
//        ];
//
//        $sheet->getStyle('A1:F1')->applyFromArray($styleHeading);
//
//    }
//
//}
