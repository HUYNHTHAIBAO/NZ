<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseFrontendController;
use App\Mail\Contact;
use App\PostCategory;
use App\Posts;
use App\Utils\Common;
use Illuminate\Http\Request;

class PagesController extends BaseFrontendController
{
    protected $_data = [];

    public function about(Request $request)
    {
        return view('frontend.pages.aboutNew', $this->_data);
    }

    public function becom(Request $request)
    {


        return view('frontend.pages.becom', $this->_data);
    }

    public function marketplace(Request $request)
    {

        return view('frontend.pages.marketplace', $this->_data);
    }
    public function introDetail(Request $request)
    {

        return view('frontend.pages.introDetail', $this->_data);
    }


    public function contact(Request $request)
    {

        $this->_data['title'] = 'Liên hệ';

        $this->_data['menu_active'] = 'products';

        $breadcrumbs[] = array(
            'link' => 'javascript:;',
            'name' => 'Liên hệ'
        );

        $this->_data['breadcrumbs'] = $breadcrumbs;

        return view('frontend.pages.contact', $this->_data);
    }
    public function expertRegister() {


        return view('frontend.pages.expertRegister', $this->_data);
    }


    public function socialImpact() {


        return view('frontend.pages.social_impact', $this->_data);
    }
    public function careers() {


        return view('frontend.pages.carres', $this->_data);
    }
    public function trustCenter() {


        return view('frontend.pages.trust_center', $this->_data);
    }
    public function ai() {


        return view('frontend.pages.ai', $this->_data);
    }
    public function neztwork_team() {


        return view('frontend.pages.neztwork_team', $this->_data);
    }
}
