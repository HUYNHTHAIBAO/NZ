<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\Orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DebtController extends BaseBackendController
{
    //

    protected $_data = array(
        'title'    => 'Danh sách Công nợ',
        'subtitle' => 'Danh sách Công nợ',
    );


//    public function index() {
//            $loggedInUser = Auth::user();
//            $idBranchs = $loggedInUser->id_branchs;
//            $this->_data['data'] = Orders::where('id_branchs', $idBranchs)
//                ->where('status_payment', 1)
//                ->select('*', 'user_id', DB::raw('count(*) as orders_count'), DB::raw('sum(total_price) as total_debt'))
//                ->groupBy('user_id')
//                ->get();
//            return view('backend.debt.index', $this->_data);
//    }

    public function index() {
        $loggedInUser = Auth::user();
        if ($loggedInUser && $loggedInUser->id === 168) {
            $this->_data['data'] = Orders::where('status_payment', 1)
                ->select('*', 'user_id', DB::raw('count(*) as orders_count'), DB::raw('sum(total_price) as total_debt'))
                ->groupBy('user_id')
                ->get();
        } else {
            $idBranchs = $loggedInUser->id_branchs;
            $this->_data['data'] = Orders::where('id_branchs', $idBranchs)
                ->where('status_payment', 1)
                ->select('*', 'user_id', DB::raw('count(*) as orders_count'), DB::raw('sum(total_price) as total_debt'))
                ->groupBy('user_id')
                ->get();
        }
        return view('backend.debt.index', $this->_data);
    }
    public function detail($id) {
        $loggedInUser = Auth::user();

        if ($loggedInUser && $loggedInUser->id === 168) {
            $this->_data['data'] = Orders::join('lck_orders_detail', 'lck_orders.id', '=', 'lck_orders_detail.order_id')
                ->where('lck_orders.user_id', $id)
                ->where('lck_orders.status_payment', 1)
                ->select('lck_orders.*', 'lck_orders_detail.title')
                ->get();
        } else {
            $idBranchs = $loggedInUser->id_branchs;
            $this->_data['data'] = Orders::join('lck_orders_detail', 'lck_orders.id', '=', 'lck_orders_detail.order_id')
                ->where('lck_orders.id_branchs', $idBranchs)
                ->where('lck_orders.user_id', $id)
                ->where('lck_orders.status_payment', 1)
                ->select('lck_orders.*', 'lck_orders_detail.title')
                ->get();
        }

        return view('backend.debt.detail', $this->_data);
    }
}

