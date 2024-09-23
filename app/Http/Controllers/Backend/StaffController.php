<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\BaseBackendController;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\CoreUsers;
use App\Utils\Common as Utils;
use App\Utils\Avatar;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Permission;

class StaffController extends BaseBackendController
{
    protected $_data = array(
        'title'    => 'Quản trị viên',
        'subtitle' => 'Quản trị viên',
    );

    public function index(Request $request)
    {
        $filter = $params = array_merge(array(
            'fullname'         => null,
            'phone'            => null,
            'email'            => null,
            'account_position' => null,
            'status'           => null,
        ), Utils::J_filterEntities($request->all()));

        $objU = new CoreUsers();

        $params['pagin_path'] = Utils::get_pagin_path($filter);
        $params['is_staff'] = true;
        $users = $objU->get_by_where($params);

        $start = ($users->currentPage() - 1) * config('constants.item_perpage');

        $this->_data['users'] = $users;
        $this->_data['start'] = $start;
        $this->_data['filter'] = $filter;
        $this->_data['account_position'] = CoreUsers::ACCOUNT_POSITION;

        return view('backend.staff.index', $this->_data);
    }

    public function add(Request $request)
    {
        $validator_rule = [
            'phone'             => 'required|string',
            'status'            => ['required', 'string', Rule::in([CoreUsers::STATUS_REGISTERED, CoreUsers::STATUS_BANNED])],
            'account_position'  => 'required|string',
            'grant_permissions' => 'nullable|array',
//            'id_branchs	' => 'required|string',
        ];

        $form_init = array_merge(
            array(
                'phone'             => null,
                'status'            => null,
                'account_position'  => null,
                'grant_permissions' => null,
                'id_branchs' => null,
            ), Utils::J_filterEntities($request->all())
        );

        $form_init = array_merge($form_init, $request->old());

        $this->_data['form_init'] = (object)$form_init;

        if ($request->getMethod() == 'POST') {

            Validator::make($request->all(), $validator_rule)->validate();

            $user = CoreUsers::where('phone', $form_init['phone'])->first();

            if (empty($user) || $user->status == CoreUsers::STATUS_UNREGISTERED) {
                return redirect()->back()
                    ->withInput($request->all())
                    ->withErrors(['message' => "Tài khoản với số điện thoại này không tồn tại, vui lòng tạo tài khoản trước khi thêm quản trị viên!"]);
            }

            try {
                DB::beginTransaction();
                $user->status = $form_init['status'];
                $user->account_position = $form_init['account_position'];
                $user->id_branchs = $form_init['id_branchs'];
                $user->save();

                foreach ($request->get('grant_permissions', []) as $permissions_id) {
                    $user->givePermissionTo($permissions_id);
                }
                DB::commit();
                $request->session()->flash('msg', ['info', 'Thêm quản trị viên thành công!']);
            } catch (\Exception $e) {
                DB::rollBack();
                $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui lòng thử lại!']);
            }
            return redirect(Route('backend.staff.index'));
        }

        $this->_data['subtitle'] = 'Thêm quản trị viên';
        $this->_data['account_position'] = CoreUsers::ACCOUNT_POSITION;
        $this->_data['all_permissions'] = Permission::where('status', 1)->get()->groupBy('group');
        $this->_data['branch'] = Branch::get();

        return view('backend.staff.add', $this->_data);
    }

    public function edit(Request $request, $id)
    {
        $user = CoreUsers::find($id);

        if (empty($user) || empty($user->account_position)) {
            $request->session()->flash('msg', ['danger', 'Nhân viên không tồn tại!']);
            return redirect($this->_ref ? $this->_ref : Route('backend.staff.index'));
        }

        if (Auth()->guard('backend')->user()->id == $id) {
            $request->session()->flash('msg', ['danger', 'Không thể cập nhật Nhân viên này!']);
            return redirect($this->_ref ? $this->_ref : Route('backend.staff.index'));
        }

        $validator_rule = [
            'status'            => ['required', 'string', Rule::in([CoreUsers::STATUS_REGISTERED, CoreUsers::STATUS_BANNED])],
            'account_position'  => 'required|string',
            'grant_permissions' => 'nullable|array',
        ];

        $permissions = $user->getAllPermissions();

        $form_init = array_merge(
            array(
                'status'            => null,
                'account_position'  => null,
                'grant_permissions' => $permissions->pluck('id')->toArray(),
                'id_branchs' => null,
            ), Utils::J_filterEntities($request->all())
        );

        if ($request->getMethod() == 'POST') {

            Validator::make($request->all(), $validator_rule)->validate();

            try {

                $user->status = $form_init['status'];
                $user->account_position = $form_init['account_position'];
                $user->id_branchs = $form_init['id_branchs'];
                $user->save();

                foreach ($permissions as $permission) {
                    $user->revokePermissionTo($permission->id);
                }

                foreach ($request->get('grant_permissions', []) as $permissions_id) {
                    $user->givePermissionTo($permissions_id);
                }

                $request->session()->flash('msg', ['info', 'Cập nhật quản trị viên thành công!']);
            } catch (\Exception $e) {
                $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui lòng thử lại!']);
            }
            return redirect(Route('backend.staff.index'));
        }

        $form_init = array_merge($form_init, $user->toArray());

        $this->_data['form_init'] = (object)$form_init;

        $this->_data['subtitle'] = 'Cập nhật';
        $this->_data['account_position'] = CoreUsers::ACCOUNT_POSITION;
        $this->_data['all_permissions'] = Permission::where('status', 1)->get()->groupBy('group');
        $this->_data['branch'] = Branch::get();

        return view('backend.staff.edit', $this->_data);
    }

    public function delete(Request $request, $id)
    {
        try {
            $user = CoreUsers::find($id);

            if (empty($user)) {
                $request->session()->flash('msg', ['danger', 'Tài khoản quản trị viên không tồn tại!']);
            } else {
                if (Auth()->guard('backend')->user()->id == $id) {
                    $request->session()->flash('msg', ['danger', 'Không thể quản trị viên này!']);
                } else {
                    $user->account_position = null;
                    $user->save();

                    foreach ($user->getAllPermissions() as $permission) {
                        $user->revokePermissionTo($permission->id);
                    }

                    $request->session()->flash('msg', ['info', 'Xóa quản trị viên thành công!']);
                }
            }
        } catch (\Exception $e) {
            $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui lòng thử lại!']);
        }
        return redirect($this->_ref ? $this->_ref : Route('backend.staff.index'));
    }
}
