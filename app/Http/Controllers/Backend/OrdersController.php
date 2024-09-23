<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Jobs\PushNotification;
use App\Models\CoreUsers;
use App\Models\Coupon;
use App\Models\Files;
use App\Models\HistoryCouPon;
use App\Models\Notification;
use App\Models\Orders;
use App\Models\OrdersDetail;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductVariation;
use App\Models\Settings;
use App\Utils\Common as Utils;
use App\Utils\Export_Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class OrdersController extends BaseBackendController
{
    protected $_data = array(
        'title' => 'Quản lý đơn hàng',
        'subtitle' => 'Quản lý đơn hàng',
    );

    protected $_limits = [
        10, 30, 50, 100, 500, 1000, 5000, 10000
    ];

    public function __construct()
    {
        $settings = Settings::get_setting_member();

        foreach ($settings as $k => $v) {
            $this->_data[$k] = $v;
        }
        $this->_data['status'] = Orders::$status;
        $this->_data['_limits'] = $this->_limits;
        parent::__construct();
    }

    public function index(Request $request)
    {
        $filter = $params = array_merge(array(
            'order_code' => null,
            'fullname' => null,
            'email' => null,
            'phone' => null,
            'status' => null,
            'id_branchs' => Auth()->guard('backend')->user()->id_branchs ?? null,
            'working_date_from' => null,
            'working_date_to' => null,
            'limit' => config('constants.item_per_page_admin'),
        ), $request->all());

        $objModel = new Orders();

        $params['pagin_path'] = Utils::get_pagin_path($filter);



        $loggedInUser = Auth::user();
        $idBranchs = $loggedInUser->id_branchs;
//        if ($loggedInUser && $loggedInUser->id === 168) {
//            $data_list = $objModel->get_by_where($params);
//        } else {
//            $data_list = Orders::join('lck_orders_detail', 'lck_orders.id', '=', 'lck_orders_detail.order_id')
//                ->join('lck_product', 'lck_orders_detail.product_id', '=', 'lck_product.id')
//                ->where('lck_product.id_branchs', $idBranchs)
//                ->select('lck_orders.*')
//                ->paginate(10);
////        dd($data_list);
////        exit();
//        }

        $data_list = $objModel->get_by_where($params);




//        $data_list = $objModel->get_by_where($params);


        $start = ($data_list->currentPage() - 1) * $filter['limit'];

        $this->_data['data_list'] = $data_list;
        $this->_data['start'] = $start;
        $this->_data['filter'] = $filter;

        return view('backend.orders.index', $this->_data);
    }

    public function detail(Request $request, $id)
    {
        $data = Orders::get_detail($id);

        $order_detail = OrdersDetail::where('order_id', $id)->get();
        if (empty($data)) {
            $request->session()->flash('msg', ['danger', 'Dữ liệu không tồn tại!']);
            return redirect($this->_ref ? $this->_ref : Route('backend.orders.index'));
        }

        // lay danh sách product type
        $ProductTypeIds = [];
        $Totalpercent_discount = 0;
//        foreach ($order_detail as $_item) {
//            $ProductId = Product::find($_item->product_id);
//            $ProductType = ProductType::find($ProductId->id)->percent_discount ?? 0;  // láy giá tr % của nhóm hàng
//            $percent_discount = ($_item['total_price'] * $ProductType ) / 100;
//            $Totalpercent_discount += $percent_discount;
//        }
        //dd($Totalpercent_discount);
        if ($request->isMethod('POST')) {
            if (!in_array($data->status, [4, 5])) {
                \DB::beginTransaction();
                try {
                    $status = $request->get('status', $data->status);
                    $data->status = $status;
                    $data->save();

                    if ($status == 4) {
                        if (!empty($data->user_id)) {

                            if (!empty($data->referral_code)) {
                                $historyCoupon = new HistoryCouPon();
                                if (!empty($data->referral_code)) {
                                    // Kiểm tra mã giới thiệu

                                    $promotion_check = Coupon::checkCode([
                                        'code' => $data->referral_code,
                                        'user_id' => $data->user_id,
                                        'price' => $data->total_price,
                                        'totalpercent_discount' => $Totalpercent_discount,
                                    ]);
//                                    dd($promotion_check);
//                                    exit();

                                    if ($promotion_check['status'] === 'error') {
                                        return $this->throwError($promotion_check['message'], 400);
                                    } else {
                                        $referral_code = $promotion_check['message'];
                                    }
                                    if (!empty($promotion_check['data'])) {
                                        $historyCoupon->code = $promotion_check['data']['code'];
                                        $historyCoupon->user_id_use = $promotion_check['data']['user_id_use'];
                                        $historyCoupon->user_id_give = $promotion_check['data']['user_id_give'];
                                        $historyCoupon->point_use = $promotion_check['data']['point_use']; // Sử dụng cú pháp mảng
                                        $historyCoupon->point_give = $promotion_check['data']['point_give']; // Sử dụng cú pháp mảng
                                        $historyCoupon->username_give = $promotion_check['data']['username_give'];
                                        $historyCoupon->order_id = $data->id;
                                        $historyCoupon->save();


                                        $form_init['user_ids'] = [$historyCoupon->user_id_use, $historyCoupon->user_id_give];
                                        $arrayPoints = [$historyCoupon->point_use, $historyCoupon->point_give];
                                        $today = date('d-m-Y');


                                            $user_use = CoreUsers::find($historyCoupon->user_id_use);
                                            $user_use->point = $user_use->point + $historyCoupon->point_use;
                                            $user_use->save();

                                            $user_give = CoreUsers::find($historyCoupon->user_id_give);
                                            $user_give->point = $user_give->point + $historyCoupon->point_give;
                                            $user_give->save();


                                        foreach ($form_init['user_ids'] as $k => $user_id) {
                                            $form_init['title'] = 'Bạn được cộng điểm.';
                                            $form_init['content'] = 'Bạn nhận được ' . $arrayPoints[$k] . ' từ đơn hàng #' . $historyCoupon->order_id . '<br>Thời gian giao dịch'.$today.'<br>Địa điểm App Mua hàng ICT';
                                            $form_init['type'] = 1;
                                            $form_init['chanel'] = 2;
                                            $form_init['company_id'] = config('constants.company_id');
                                            $form_init['to_user_id'] = $user_id;
                                            $form_init['user_id_created'] = Auth()->guard('backend')->user()->id;
                                            $notification = Notification::create($form_init);
                                            $this->dispatch((new PushNotification($notification))->onQueue('push_notification'));
                                        }

                                    }
                                }


                            }

//                            $user = CoreUsers::find($data->user_id);
//                            // Tích điểm, tổng thanh toán đã mua, level up
//
//                            //Set thành viên
//                            $after_expense = $user->expense + $data->total_price;
//                            $user->expense = $after_expense;
//
//                            if ($after_expense >= $this->_data['MEMBER_SILVER']['setting_value'] && $after_expense < $this->_data['MEMBER_GOLD']['setting_value']) {
//                                $user->account_type = CoreUsers::ACCOUNT_TYPE_SILVER;
//
//                            } else if ($after_expense >= $this->_data['MEMBER_GOLD']['setting_value'] && $after_expense < $this->_data['MEMBER_DIAMOND']['setting_value']) {
//                                $user->account_type = CoreUsers::ACCOUNT_TYPE_GOLD;
//                            } else if ($after_expense >= $this->_data['MEMBER_DIAMOND']['setting_value'] && $after_expense < $this->_data['MEMBER_VIP']['setting_value']) {
//                                $user->account_type = CoreUsers::ACCOUNT_TYPE_DIAMOND;
//                            } else if ($after_expense > $this->_data['MEMBER_VIP']['setting_value']) {
//                                $user->account_type = CoreUsers::ACCOUNT_TYPE_VIP;
//                            } else {
//                                $user->account_type = CoreUsers::ACCOUNT_TYPE_NEW;
//                            }
//                            // Tích điểm
//                            $total_point = 0;
//
//                            if ($user->account_type == CoreUsers::ACCOUNT_TYPE_NEW) {
//                                $total_point = $data->total_price * 0.00001;
//                            } else if ($user->account_type == CoreUsers::ACCOUNT_TYPE_SILVER) {
//                                $total_point = $data->total_price * 0.00003;
//                            } else if ($user->account_type == CoreUsers::ACCOUNT_TYPE_GOLD) {
//                                $total_point = $data->total_price * 0.00005;
//                            } else if ($user->account_type == CoreUsers::ACCOUNT_TYPE_DIAMOND) {
//                                $total_point = $data->total_price * 0.00007;
//                            } else if ($user->account_type == CoreUsers::ACCOUNT_TYPE_VIP) {
//                                $total_point = $data->total_price * 0.0001;
//                            }
//                            $user->point += $total_point;
//                            $user->save();


                        }
                    }
                    //hoàn kho nếu hủy
                    if ($status == 5) {
                        foreach ($data->order_details as $v) {
                            if ($v->product_variation_id) {
                                ProductVariation::update_inventory([
                                    'id' => $v->product_variation_id,
                                    'product_id' => $v->product_id,
                                    'quantity' => $v->quantity,
                                ]);
                            } else {
                                Product::update_inventory([
                                    'product_id' => $v->product_id,
                                    'quantity' => $v->quantity,
                                ]);
                            }
                            Product::change_inventory([
                                'product_id' => $v->product_id,
                            ]);
                        }
                    }

                    \DB::commit();
                    $request->session()->flash('msg', ['info', 'Cập nhật trạng thái thành công!']);
                } catch (\Exception $e) {
                    \DB::rollBack();
                    \Log::error('status order ' . $e->getMessage());
                    $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui lòng thử lại' . $e->getMessage()]);
                }

                return redirect($this->_ref ? $this->_ref : Route('backend.orders.index'));
            }
        }

        $this->_data['subtitle'] = 'Chi tiết đơn hàng';
        $this->_data['data_item'] = $data;

        return view('backend.orders.detail', $this->_data);
    }

    public function delete(Request $request, $id)
    {
        try {
            if ($id == 0 && $request->ajax()) {
                $ids = $request->get('ids', []);
                if ($ids)
                    Orders::delete_by_type($ids);

                echo json_encode(['e' => 0, 'r' => 'success']);
                exit;
            } else {
                $data = Orders::get_detail($id);
                if (empty($data)) {
                    $request->session()->flash('msg', ['danger', 'Dữ liệu không tồn tại!']);
                } else {
                    $data->delete();
                    $request->session()->flash('msg', ['info', 'Đã xóa thành công!']);
                }
            }
        } catch (\Exception $e) {
            $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui lòng thử lại!']);
        }
        return redirect($this->_ref ? $this->_ref : Route('backend.orders.index'));
    }

    public function export(Request $request)
    {
//        if ($request->ids) {
//            $ids = !is_array($request->get('ids')) ? explode(',', $request->get('ids')) : $request->get('ids');
//            $orders = Orders::whereIn('id', $ids)->get();
//            $spreadsheet = new Spreadsheet();
//            $sheet = $spreadsheet->getActiveSheet();
//            $styleArray = array(
//                'font'      => array(
//                    'bold' => true,
//                    'size' => 16,
//                ),
//                'alignment' => array(
//                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
//                    'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
//                ),
//                'borders'   => array(
//                    'bottom' => array(
//                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
//                        'color'       => array('rgb' => '333333'),
//                    ),
//                ),
//            );
//            $styleName = array(
//                'font' => array(
//                    'bold' => true,
//                    'size' => 20,
//                ),
//            );
//            $today = date('d-m-Y');
//
//            $spreadsheet->getActiveSheet()->getStyle('C1:H1')->applyFromArray($styleArray)->getFont()->getColor()
//                ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
//            $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(16);
//            $spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(24);
//            $spreadsheet->getDefaultStyle()->getFont()->setSize(16);
//            $sheet->setCellValue('C1', 'Mã đơn hàng');
//            $sheet->setCellValue('D1', 'Họ&Tên');
//            $sheet->setCellValue('E1', 'SĐT');
//            $sheet->setCellValue('F1', 'Ngày đặt');
//            $sheet->setCellValue('G1', 'Số tiền');
//            $sheet->setCellValue('H1', 'Tình trạng');
//            $rows = 2;
//
//            foreach ($orders as $k => $v) {
//                $sheet->setCellValue('C' . $rows, $v->order_code);
//                $sheet->setCellValue('D' . $rows, $v->fullname);
//                $sheet->setCellValue('E' . $rows, $v->phone);
//                $sheet->setCellValue('F' . $rows, $v->created_at);
//                $sheet->setCellValue('G' . $rows, number_format($v->total_price) . 'VND');
//                $sheet->setCellValue('H' . $rows, \App\Models\Orders::$status[$v->status]);
//                $rows++;
//            }
//            $writer = new Xlsx($spreadsheet);
//            $filename = 'LỊCH SỬ ĐƠN HÀNG: ' . date('d-m-Y_H-i-s') . '.xlsx';
//            header('Content-Type: application/vnd.ms-excel');
//            header('Content-Disposition: attachment;filename="' . $filename . '"');
//            header('Cache-Control: max-age=0');
//            $writer->save('php://output');
//        }

        // Hoàn thành nhanh
        try {
            if ($request->type == 1) {
                if ($request->ids) {
                    $arrays = $request->ids;
                    foreach ($arrays as $array) {
                        $data = Orders::get_detail($array);
                        if ($data->status == 1 || $data->status == 2 || $data->status == 3) {
                            $data->status = 4;
                            $data->save();

                            if (!empty($data->user_id)) {
                                $Totalpercent_discount = 0;
                                if (!empty($data->referral_code)) {
                                    $historyCoupon = new HistoryCouPon();
                                    if (!empty($data->referral_code)) {
                                        // Kiểm tra mã giới thiệu

                                        $promotion_check = Coupon::checkCode([
                                            'code' => $data->referral_code,
                                            'user_id' => $data->user_id,
                                            'price' => $data->total_price,
                                            'totalpercent_discount' => $Totalpercent_discount,
                                        ]);

                                        if ($promotion_check['status'] === 'error') {
                                            return $this->throwError($promotion_check['message'], 400);
                                        } else {
                                            $referral_code = $promotion_check['message'];
                                        }
                                        if (!empty($promotion_check['data'])) {

                                            $historyCoupon->code = $promotion_check['data']['code'];
                                            $historyCoupon->user_id_use = $promotion_check['data']['user_id_use'];
                                            $historyCoupon->user_id_give = $promotion_check['data']['user_id_give'];
                                            $historyCoupon->point_use = $promotion_check['data']['point_use'];
                                            $historyCoupon->point_give = $promotion_check['data']['point_give'];
                                            $historyCoupon->username_give = $promotion_check['data']['username_give'];
                                            $historyCoupon->order_id = $data->id;
                                            $historyCoupon->save();

                                            $form_init['user_ids'] = [$historyCoupon->user_id_use, $historyCoupon->user_id_give];
                                            $arrayPoints = [$historyCoupon->point_use, $historyCoupon->point_give];


//                                            $user_use = CoreUsers::find($historyCoupon->user_id_use);
//                                            $user_use->point= $user_use->point+$historyCoupon->point_use;
//                                            $user_use->save();
//                                            $user_give = CoreUsers::find($historyCoupon->user_id_give);
//                                            $user_give->point = $user_give->point + $historyCoupon->point_give;
//                                            $user_give->save();


                                            $today = date('d-m-Y');
                                            $user_use = CoreUsers::find($historyCoupon->user_id_use);
                                            $user_use->point= $user_use->point+$historyCoupon->point_use;
                                            $user_use->save();
                                            $user_give = CoreUsers::find($historyCoupon->user_id_give);
                                            $user_give->point = $user_give->point + $historyCoupon->point_give;
                                            $user_give->save();


                                            foreach ($form_init['user_ids'] as $k => $user_id) {
                                                $form_init['title'] = 'Bạn được cộng điểm.';
                                                $form_init['content'] = 'Bạn nhận được ' . $arrayPoints[$k] . ' từ đơn hàng #' . $historyCoupon->order_id . '<br>Thời gian giao dịch'.$today.'<br>Địa điểm App Mua hàng ICT';
                                                $form_init['type'] = 1;
                                                $form_init['chanel'] = 2;
                                                $form_init['company_id'] = config('constants.company_id');
                                                $form_init['to_user_id'] = $user_id;
                                                $form_init['user_id_created'] = Auth()->guard('backend')->user()->id;
                                                $notification = Notification::create($form_init);

                                                $this->dispatch((new PushNotification($notification))->onQueue('push_notification'));
                                            }

                                            // gui thông bao cho nguoi dung ma
//                                            $form_init['title'] = 'Bạn được cộng điểm.';
//                                            $form_init['content'] = 'Bạn nhận được ' . $historyCoupon->point_use . ' từ đơn hàng #' . $historyCoupon->order_id . '<br>Thời gian giao dịch'.$today.'<br>Địa điểm App Mua hàng ICT';
//                                            $form_init['type'] = 1;
//                                            $form_init['chanel'] = 2;
//                                            $form_init['company_id'] = config('constants.company_id');
//                                            $form_init['to_user_id'] = $historyCoupon->user_id_use;
//                                            $form_init['user_id_created'] = 168;
//                                            $notification = Notification::create($form_init);
//
//                                            $this->dispatch((new PushNotification($notification))->onQueue('push_notification'));
//
//                                            // gui thong bao cho chu ma
//                                            $form_init1['title'] = 'Bạn được cộng điểm.';
//                                            $form_init1['content'] = 'Bạn nhận được ' . $historyCoupon->point_give. ' từ đơn hàng #' . $historyCoupon->order_id . '<br>Thời gian giao dịch'.$today.'<br>Địa điểm App Mua hàng ICT';
//                                            $form_init1['type'] = 1;
//                                            $form_init1['chanel'] = 2;
//                                            $form_init1['company_id'] = config('constants.company_id');
//                                            $form_init1['to_user_id'] = $historyCoupon->user_id_give;
//                                            $form_init1['user_id_created'] = 168;
//                                            $notification1 = Notification::create($form_init1);
//                                            $this->dispatch((new PushNotification($notification1))->onQueue('push_notification'));



                                        }
                                    }


                                }

//                                $user = CoreUsers::find($data->user_id);
                                // Tích điểm, tổng thanh toán đã mua, level up

                                //Set thành viên
//                                $after_expense = $user->expense + $data->total_price;
//                                $user->expense = $after_expense;
//
//                                if ($after_expense >= $this->_data['MEMBER_SILVER']['setting_value'] && $after_expense < $this->_data['MEMBER_GOLD']['setting_value']) {
//                                    $user->account_type = CoreUsers::ACCOUNT_TYPE_SILVER;
//
//                                } else if ($after_expense >= $this->_data['MEMBER_GOLD']['setting_value'] && $after_expense < $this->_data['MEMBER_DIAMOND']['setting_value']) {
//                                    $user->account_type = CoreUsers::ACCOUNT_TYPE_GOLD;
//                                } else if ($after_expense >= $this->_data['MEMBER_DIAMOND']['setting_value'] && $after_expense < $this->_data['MEMBER_VIP']['setting_value']) {
//                                    $user->account_type = CoreUsers::ACCOUNT_TYPE_DIAMOND;
//                                } else if ($after_expense > $this->_data['MEMBER_VIP']['setting_value']) {
//                                    $user->account_type = CoreUsers::ACCOUNT_TYPE_VIP;
//                                } else {
//                                    $user->account_type = CoreUsers::ACCOUNT_TYPE_NEW;
//                                }
                                // Tích điểm
//                                $total_point = 0;
//
//                                if ($user->account_type == CoreUsers::ACCOUNT_TYPE_NEW) {
//                                    $total_point = $data->total_price * 0.00001;
//                                } else if ($user->account_type == CoreUsers::ACCOUNT_TYPE_SILVER) {
//                                    $total_point = $data->total_price * 0.00003;
//                                } else if ($user->account_type == CoreUsers::ACCOUNT_TYPE_GOLD) {
//                                    $total_point = $data->total_price * 0.00005;
//                                } else if ($user->account_type == CoreUsers::ACCOUNT_TYPE_DIAMOND) {
//                                    $total_point = $data->total_price * 0.00007;
//                                } else if ($user->account_type == CoreUsers::ACCOUNT_TYPE_VIP) {
//                                    $total_point = $data->total_price * 0.0001;
//                                }
//                                $user->point += $total_point;
//                                $user->save();
                            }
                        }
                    }

                } else {
                    $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui chọn đơn cần duyệt!']);
                    return redirect()->back();
                }
            } elseif ($request->type == 2) {

                if ($request->ids) {
                    $arrayIds = $request->ids;

                    $this->_data['subtitle'] = 'Chi tiết đơn hàng';

                    $this->_data['arrayIds'] = $arrayIds;

                    return view('backend.orders.print', $this->_data);
                } else {
                    $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui chọn đơn cần in!']);
                    return redirect()->back();
                }

            }


            $request->session()->flash('msg', ['info', 'Duyệt thành công!']);
        } catch (\Exception $e) {
            $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui lòng thử lại!']);
        }
        return redirect()->back();

    }

    public function excelExport(Request $request)
    {

        $option = $request->get('option');
        $date_start = $request->get('date_start');
        $date_end = $request->get('date_end');

        $currentDateTime = Carbon::now();
        $fileName = 'Danh_sach_don_hang' . $currentDateTime->format('Ymd_His') . '.xlsx';
        $export = new Export_Order($date_start, $date_end);
        return Excel::download($export, $fileName);
        //return Excel::download(new Export_Order(), $fileName);
    }

    public function wherehouseExport(Request $request)
    {

        $option = $request->get('option');
        $date_start = $request->get('date_start');
        $date_end = $request->get('date_end');
        //$currentDate = Carbon::now();
        //$currentDate = $currentDate->format('Y-m-d H:i:s');

        //$data = Orders::where('status', 2);
        //$data = $data->where('lck_orders.created_at', $currentDate);
        // $data = $data->get();
        $currentDate = now(); // Sử dụng now() để lấy ngày và giờ hiện tại

        $data = Orders::where('status', 2);


        if ($option == 2) {
            $data = $data->whereBetween('lck_orders.created_at', [$date_start, $date_end])->get();;
        } else {
            $data = $data->whereDate('created_at', $currentDate->toDateString())
                ->get();
        }
        $productId = [];
        $productArray = [];
        foreach ($data as $item) {
            $orderDetails = OrdersDetail::where('order_id', $item['id'])->get();

            foreach ($orderDetails as $orderDetail) {
                $productArray [] = [
                    'id' => $orderDetail['product_id'],
                    'title' => $orderDetail['title'],
                    'specifications' => $orderDetail['specifications'],
                    'order_id' => $orderDetail['order_id'],
                    'quantity' => $orderDetail['quantity'],
                    'total_price' => $orderDetail['total_price'],
                ];
                $productId [] = $orderDetail['product_id'];
            }

        }

        $uniqueArray = array_unique($productId);
        $av = [];
        foreach ($uniqueArray as $itemAray) {

            $idToFind = $itemAray;
            $resultArray = array_filter($productArray, function ($item) use ($idToFind) {
                return $item['id'] == $idToFind;
            });
            if ($resultArray) {
                $av [] = $resultArray;
            }
        }


        // càn lay: teen sp nhưng odderdetail có chung product id

        $this->_data['data'] = $av;
        return view('backend.orders.wherehouse', $this->_data);


    }

    public function detailDelete(Request $request, $id)
    {
        try {
            $data = OrdersDetail::find($id);
            $order = Orders::find($data->order_id);
            if (!empty($order)) {
                $order->total_price = $order->total_price - ($data->quantity * $data->price);
                $order->save();
            }
            $data->delete();
            $request->session()->flash('msg', ['info', 'Đã xóa thành công!']);
        } catch (\Exception $e) {
            $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui lòng thử lại!']);
        }
        return redirect()->back();
    }

    public function detailadd(Request $request)
    {

        $param['order_id'] = $request->get('order_id');
        $param['product_id'] = $request->get('product_id');
        $param['quantity'] = $request->get('quantity');
        $param['price'] = $request->get('price');
        $param['total_price'] = $param['quantity'] * $param['price'];

        $param['title'] = Product::find($param['product_id'])->title ?? null;
        $param['thumbnail_path'] = Files::find(Product::find($param['product_id'])->thumbnail_id)->file_path ?? null;
        OrdersDetail::create($param);
        $order = Orders::find($param['order_id']);
        if ($order) {
            $order->total_price = $order->total_price + $param['total_price'];
            $order->save();
        }
        return \Response::json(['e' => 0, 'r' => 1]);
    }

    public function print(Request $request)
    {

        dd(1);
        $arrayIds = [187, 188];
        $data = Orders::get_detail($id);


        $this->_data['subtitle'] = 'Chi tiết đơn hàng';
        $this->_data['data_item'] = $data;
        $this->_data['arrayIds'] = $arrayIds;

        return view('backend.orders.print', $this->_data);
    }

    public function pay_debt(Request $request, $id) {
        $data_item = Orders::find($id);
//        dd($data_item1);
//        exit();
        $data_item->status_payment = 3; // Thay đổi trạng thái thành 3
        $data_item->status = 4; // Thay đổi trạng thái thành hoàn thành
        $data_item->update();

        return redirect()->route('backend.orders.index');
    }
}
