<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\CoreUsers;
use App\Models\Orders;
use App\Models\Post;
use App\Models\PostExpert;
use App\Models\Product;
use App\Models\ProductContactInfo;
use App\Models\ProductNote;
use App\Models\ThienMinh\District;
use App\Models\ThienMinh\Lands;
use App\Models\ThienMinh\Notes;
use App\Models\ThienMinh\Ward;
use App\ReportsHourly;

class DashboardController extends BaseBackendController
{
    protected $_data = [
        'title' => 'Dashboard',
    ];

    public function merge()
    {
        exit;
    }

    public function mergeNote()
    {
        exit;
    }

    public function test()
    {
        $d1 = District::all()->toArray();

        foreach ($d1 as $v) {
            $d2 = \App\Models\Location\District::find($v['district_id'])->toArray();
//            echo $v['district_id'];
//            echo ' - ';
//            echo $v['name'];
//            echo ' - ';
//            echo isset($d2['name']) ? $d2['name'] : '<strong>Thiếu</strong>';
//            echo '<br>';

            $ward1 = Ward::where('district_id', $v['district_id'])->get()->toArray();
            $_ward2 = \App\Models\Location\Ward::where('district_id', $v['district_id'])->get()->toArray();

            $ward2 = [];
            foreach ($_ward2 as $w2) {
                $ward2[$w2['id']] = $w2;
            }
            echo '-------------------------------------------<br>';

            foreach ($ward1 as $w1) {
                echo $w1['ward_id'];
                echo ' - ';
                echo $w1['name'];
                echo ' - ';
                echo isset($ward2[$w1['ward_id']]['name']) ? $ward2[$w1['ward_id']]['name'] : '<strong style="color:red;">Thiếu</strong>';
                echo '<br>';
            }
        }
    }

    public function index()
    {

//        $p = \App\Models\Admin\Product::get_by_where_join();
//        echo "<pre>";
//        print_r($p->toArray());
//        exit;

        $user = Auth()->guard('backend')->user();
//        $this->_data['count_products'] = Product::where('company_id',config('constants.company_id'))->count();
        $this->_data['count_expert'] = CoreUsers::where('company_id',config('constants.company_id'))->where('account_type', 2)->count();
        $this->_data['count_order'] = Orders::where('company_id',config('constants.company_id'))->count();
        $this->_data['count_users'] = CoreUsers::where('company_id',config('constants.company_id'))->where('account_type', 0)->count();
        $this->_data['count_posts'] = Post::where('company_id',config('constants.company_id'))->count();
        $this->_data['count_posts_expert'] = PostExpert::where('company_id',config('constants.company_id'))->count();
        $this->_data['order_new'] = Orders::with('user')->where('company_id',config('constants.company_id'))->orderBy('created_at', 'DESC')->limit(4)->get();
        $this->_data['products_new'] = Product::with('thumbnail')->where('company_id',config('constants.company_id'))->orderBy('created_at', 'DESC')->limit(4)->get();
        $this->_data['users_new'] = CoreUsers::orderBy('created_at', 'DESC')->where('company_id',config('constants.company_id'))->limit(4)->get();
        $report_month = [];

        for ($i = 1; $i <= date('m'); $i++) {
            $stat = Orders::selectRaw('sum(total_price) as total_amount_month')
                ->where('company_id', config('constants.company_id'))
                ->where('status', 4)
                ->whereRaw("MONTH(created_at) = {$i}")
                ->first();

            $total_amount = $stat->total_amount_month;

            $report_month[] = [
                'period'       => $i . '/' . date('Y'),
                'total_amount' => (int)$total_amount,
                'shipping_fee' => 0,
            ];
        }
        $this->_data['report_month'] = $report_month;
        return view('backend.index', $this->_data);
    }

    private function _getAddress($params)
    {
        if (empty($params['province_id'])
            || empty($params['district_id'])
            || empty($params['ward_id'])
            || empty($params['street_id'])
            || empty($params['apartment_number']))
            return null;

        $province = \App\Models\Location\Province::findOrFail($params['province_id']);
        $district = \App\Models\Location\District::findOrFail($params['district_id']);
        $ward = \App\Models\Location\Ward::findOrFail($params['ward_id']);
        $street = \App\Models\Location\Street::findOrFail($params['street_id']);
        $address = $params['apartment_number'] . ' ' . $street->name . ', ' . $ward->name . ', ' . $district->name . ', ' . $province->name;
        return $address;
    }
}
