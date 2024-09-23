<?php

namespace App\Http\Controllers\Backend\Branch;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\BaseBackendController;
use App\Http\Requests\Backend\Branch\StoreBranchRequest;
use App\Models\Branch;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends BaseBackendController
{

    private $data = [];

    /**
     * BranchController constructor.
     */
    public function __construct()
    {
        $this->data['title'] = 'Đại lý';
        $this->data['subtitle'] = 'Đại lý';
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $loggedInUser = Auth::user();

        if ($loggedInUser && $loggedInUser->id === 168) {
            $this->data['data'] = Branch::getAll([]); // Lấy tất cả đại lý nếu người dùng có ID là 168
        } else {
            $idBranchs = $loggedInUser->id_branchs;
            if ($idBranchs) {
                // Lấy thông tin đại lý dựa trên ID đại lý của người dùng đăng nhập
                $this->data['data'] = Branch::where('id', $idBranchs)->paginate(10);
            } else {
                // Xử lý trong trường hợp không có ID đại lý của người dùng đăng nhập
            }
        }

//        $this->data['data'] = Branch::getAll([]);
        $this->data['start'] = 0;
        return view('backend.branch.index',$this->data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create()
    {
        $this->data['isEditable'] = false;
        $this->data['branch'] = [];
        return view('backend.branch.create',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBranchRequest $request)
    {
        $params = $request->all();
        $branch = Branch::create($params);
        if(!$branch){
            $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui lòng thử lại!']);
        }
        $request->session()->flash('msg', ['info', 'Thêm thành công!']);
        return redirect()->route('backend.brands.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function edit( Request $request, $id)
    {
        $this->data['isEditable'] = true;
        $this->data['branch'] = Branch::find($id);
        return view('backend.branch.create',$this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreBranchRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreBranchRequest $request, $id)
    {
        $params = $request->all();
        $branch = Branch::find($id);
        if(!$branch){
            $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui lòng thử lại!']);
        }
        $branch->update($params);
        $request->session()->flash('msg', ['info', 'Cập nhật thành công!']);
        return redirect()->route('backend.brands.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        $id = $request->id ?? 0;
        $branch = Branch::find($id);
        if(!$branch){
            return ResponseHelper::error('Không thể Xóa',[]);
        }

        $branch->delete();
        return ResponseHelper::success('Đã xóa thành công',[]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxWareHouse(Request $request)
    {
        $branch_id = $request->branch_id ?? 0;
        $branch = Branch::find($branch_id);
        $warehouse_id = $request->warehouse_id ?? 0;
        $warehouse = Warehouse::getAll(['branch_id'=>$branch_id]);
        if(!$branch){
            return ResponseHelper::error('Không thể tìm id branch',[]);
        }
        $html = view('backend.branch.ajax',['warehouse'=>$warehouse,'warehouse_id'=>$warehouse_id])->render();
        return ResponseHelper::success('Đã xóa thành công',[
            'jsonData' => $html
        ]);
    }
}
