<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\CoreUsers;
use App\Models\ExpertApplications;
use App\Models\ExpertCategory;
use App\Models\ExpertCategoryTags;
use App\Models\ExpertProfiles;
use App\Models\FileExpert;
use App\Models\RegisterExpertUpdate;
use App\Utils\Common as Utils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpertController extends BaseBackendController
{
    //
    protected $_data = array(
        'title' => 'Quản lý Chuyên gia',
        'subtitle' => 'Quản lý Chuyên gia',
    );

    public function index(Request $request)
    {
        $filter = $params = array_merge(array(
            'fullname' => null,
            'phone' => null,
            'email' => null,
            'status' => null,
        ), Utils::J_filterEntities($request->all()));

        $objU = new CoreUsers();

        $params['pagin_path'] = Utils::get_pagin_path($filter);
        $params['is_staff'] = false;
        $params['account_type'] = [2];

        $users = $objU->get_by_where($params);

        $start = ($users->currentPage() - 1) * config('constants.item_perpage');
        $this->_data['users'] = $users;
        $this->_data['start'] = $start;
        $this->_data['filter'] = $filter;

        return view('backend.expert.index', $this->_data);
    }

    public function expertApplication(Request $request)
    {
        $data = CoreUsers::where('approved', 1)->get();
        $this->_data['data'] = $data;
        $this->_data['subtitle'] = 'Danh sách hồ sơ đăng ký chuyên gia';
        return view('backend.expert.application', $this->_data);
    }


    public function expertApplicationUpdate(Request $request)
    {
        $data = RegisterExpertUpdate::where('approved', 1)->get();
        $this->_data['data'] = $data;
        $this->_data['title'] = 'Quản lý cập nhật hồ sơ';
        return view('backend.expert.applicationUpdate', $this->_data);
    }


    public function detail(Request $request, $id)
    {

        $application =  CoreUsers::find($id);

        $this->_data['dataId'] = $application;

        $this->_data['title'] = 'Chi tiết hồ sơ';
        $this->_data['category_expert'] = ExpertCategory::where('status', 1)->get();
        $this->_data['tags_expert'] = ExpertCategoryTags::where('status', 1)->get();

        return view('backend.expert.detail', $this->_data);
    }

    public function detailUpdate(Request $request, $id)
    {

        $application =  RegisterExpertUpdate::find($id);

        $this->_data['dataId'] = $application;

        $this->_data['title'] = 'Chi tiết hồ sơ';
        $this->_data['category_expert'] = ExpertCategory::where('status', 1)->get();
        $this->_data['tags_expert'] = ExpertCategoryTags::where('status', 1)->get();
        return view('backend.expert.detailUpdate', $this->_data);
    }

    public function approved(Request $request, $id)
    {
        try {
            // Tìm kiếm người dùng theo ID
            $user = CoreUsers::findOrFail($id);

            if ($user) {
                // Cập nhật trạng thái và thời gian duyệt
                $user->approved = 2;
                $user->account_type = 2;
                $user->updated_at = now();
                $user->save();

                return redirect()->route('backend.expert.expertApplication')->with('success', 'Duyệt thành công');
            } else {
                return redirect()->back()->with('danger', 'Không tìm thấy chuyên gia');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Duyệt thất bại, vui lòng thử lại sau');
        }
    }

    public function approvedUpdate(Request $request, $id)
    {
        try {
            // Tìm kiếm người dùng theo ID
            $updateInfo  = RegisterExpertUpdate::findOrFail($id);



                // Cập nhật trạng thái và thời gian duyệt
                $updateInfo ->approved = 2;
                $updateInfo ->updated_at = now();
                $updateInfo ->save();


            // Lấy thông tin người dùng từ bảng CoreUsers và cập nhật các trường thông tin
            $user = CoreUsers::findOrFail($updateInfo->user_id);
            if ($user) {
                $user->bio = $updateInfo->bio;
                $user->job = $updateInfo->job;
                $user->advise = $updateInfo->advise;
                $user->questions = $updateInfo->questions;
                $user->facebook_link = $updateInfo->facebook_link;
                $user->x_link = $updateInfo->x_link;
                $user->instagram_link = $updateInfo->instagram_link;
                $user->tiktok_link = $updateInfo->tiktok_link;
                $user->linkedin_link = $updateInfo->linkedin_link;
                $user->category_id_expert = $updateInfo->category_id_expert;
                $user->approved = 5; // Đánh dấu là đã duyệt
                $user->save();
            }

                return redirect()->route('backend.expert.expertApplicationUpdate')->with('success', 'Duyệt thành công');

        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Duyệt thất bại, vui lòng thử lại sau');
        }
    }


    public function reject(Request $request, $id)
    {
        // Tìm kiếm người dùng theo ID
        $user = CoreUsers::findOrFail($id);
        if ($user) {
                 $user->approved = 3;
                $user->reason_for_refusal = $request->get('reason_for_refusal');
                $user->updated_at = now();
                $user->account_type = 0;  // Cập nhật loại tài khoản thành 2
                $user->save();
            }

        return redirect()->route('backend.expert.expertApplication')->with('success', 'Từ chối thành công');
    }
    public function rejectUpdate(Request $request, $id)
    {
        try {
            // Tìm kiếm người dùng theo ID
            $updateInfo  = RegisterExpertUpdate::findOrFail($id);



            // Cập nhật trạng thái và thời gian duyệt
            $updateInfo ->approved = 3;
            $updateInfo->reason_for_refusal = $request->get('reason_for_refusal');
            $updateInfo ->updated_at = now();
            $updateInfo ->save();


            // Lấy thông tin người dùng từ bảng CoreUsers và cập nhật các trường thông tin
            $user = CoreUsers::findOrFail($updateInfo->user_id);
            if ($user) {
                $user->approved = 6; // Đánh dấu là đã duyệt
                $user->save();
            }

            return redirect()->route('backend.expert.expertApplicationUpdate')->with('success', 'Duyệt thành công');

        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Duyệt thất bại, vui lòng thử lại sau');
        }
    }


}
