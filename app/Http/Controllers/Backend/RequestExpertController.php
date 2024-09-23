<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\RequestExpert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestExpertController extends BaseBackendController
{
    //
    public function index()
    {
        $data = RequestExpert::orderBy('id', 'desc')->get();

        $this->_data['data'] = $data;
        return view('backend.requestExpert.index', $this->_data);
    }
}
