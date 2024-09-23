<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseFrontendController;

use App\Models\Orders;
use Illuminate\Http\Request;

class OrderController extends BaseFrontendController
{
    protected $_data = [];

    public function tracking(Request $request)
    {
        $phone = $request->get('phone');
        $order_code = $request->get('order_code');

        $data = null;
        if ($phone && $order_code) {
            $data = Orders::get_detail_tracking($order_code, $phone);
        }

        $this->_data['order'] = $data;
        $this->_data['title'] = 'Tra cứu đơn hàng';
        $this->_data['menu_active'] = 'products';

        $breadcrumbs[] = array(
            'link' => 'javascript:;',
            'name' => 'Tra cứu đơn hàng'
        );

        $this->_data['breadcrumbs'] = $breadcrumbs;

        return view('frontend.order.tracking', $this->_data);
    }
}
