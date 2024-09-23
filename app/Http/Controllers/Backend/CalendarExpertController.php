<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\CoreUsers;
use App\Models\TimeDurations;
use App\Models\TimeRatesDuration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CalendarExpertController extends BaseBackendController
{
    //
    public function duration(Request $request, $id)
    {


        $user = CoreUsers::find($id);

        $settingTime = TimeRatesDuration::orderBy('id', 'asc')->where('user_id', $user->id)->with('user')->get();

        $this->_data['settingTime'] = $settingTime;
        $this->_data['user'] = $user;
        $this->_data['subtitle'] = 'Thời gian & giá chuyên gia';
        return view('backend.calendar.index', $this->_data);
    }

    public function time(Request $request, $id)
    {

        $user = CoreUsers::find($id);

        $settingTime = TimeDurations::orderBy('id', 'desc')->where('user_id', $user->id)->with('user')->get();


        $this->_data['settingTime'] = $settingTime;
        $this->_data['user'] = $user;
        $this->_data['subtitle'] = 'Lịch ngày & giờ của chuyên gia';

        return view('backend.calendar.time', $this->_data);
    }
}
