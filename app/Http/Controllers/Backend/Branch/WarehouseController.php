<?php

namespace App\Http\Controllers\Backend\Branch;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\BaseBackendController;
use App\Http\Requests\Backend\Branch\StoreWarehouseRequest;
use App\Models\Branch;
use App\Models\Files;
use App\Models\Product;
use App\Models\Orders;
use App\Models\ProductImages;
use App\Models\ProductType;
use App\Models\Warehouse;
use App\Models\BanImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class WarehouseController extends BaseBackendController
{

    private $data = [];

    /**
     * BranchController constructor.
     */
    public function __construct()
    {
        $this->data['title'] = 'Bàn';
        $this->data['subtitle'] = 'Bàn';
        parent::__construct();
    }

    public function index(Request $request)
    {

        if ($request->getMethod() == 'GET') {

            if (!empty($request->get('branch_id'))) {
                Cookie::queue('branch_id', $request->get('branch_id'));

                if($request->get('branch_id') == 1234){
                    $params['status'] = 2;
                    $this->data['data'] =  Warehouse::getAll($params);
                    $this->data['list_branch'] = Branch::getAll([]);
                    $view = \View::make('backend.warehouse.ajaxList', $this->data);
                    $return = [
                        'e' => 0,
                        'r' => $view->render()
                    ];
                    return \Response::json($return);
                }else{

                    $params['branch_id'] = $request->get('branch_id');
                    $this->data['data'] = Warehouse::getAll($params);
                    $this->data['list_branch'] = Branch::getAll([]);
                    $view = \View::make('backend.warehouse.ajaxList', $this->data);
                    $return = [
                        'e' => 0,
                        'r' => $view->render()
                    ];
                    return \Response::json($return);
                }


            }

        }

        $value = Cookie::get('branch_id');
        //dd($value1);
        if($value){
            if($value == 1234){
                $params['status'] = 2;
                //$params['branch_id'] = $value;
                $this->data['data'] = Warehouse::getAll($params);
                $this->data['list_branch'] = Branch::getAll([]);
            }else{
                $params['branch_id'] = $value;
                $this->data['data'] = Warehouse::getAll($params);
                $this->data['list_branch'] = Branch::getAll([]);
            }

            // $params['branch_id'] = $value[0];

        }else{
            $this->data['data'] = Warehouse::getAll([]);
            $this->data['list_branch'] = Branch::getAll([]);
        }

        //$this->data['data'] = Warehouse::getAll([]);
        //$this->data['list_branch'] = Branch::getAll([]);
        $this->data['start'] = 0;

        return view('backend.warehouse.index', $this->data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create(Request $request)
    {


        /* if ($request->getMethod() == 'POST') {

             $aInit = Warehouse::get_validation_admin();
             Validator::make($request->all(), $aInit)->validate();
             $params = array_fill_keys(array_keys($aInit), null);
             $params = array_merge(
                 $params, $request->only(array_keys($params))
             );


             //$params['name'] = $request->get('name');
             // $params['branch_id'] = $request->get('branch_id');
             //$params['description'] = $request->get('warehouse_description');
             //$params['thumbnail_id'] = 720;


             $params['thumbnail_id'] = empty($params['thumbnail_id']) ? $params['image_ids[]'][0] : $params['thumbnail_id'];

 //            empty($params['thumbnail_id']) ? $params['image_ids'][0] : $params['thumbnail_id'];

             $branch = Warehouse::create($params);
             $branch->save();

             if (!$branch) {
                 $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui lòng thử lại!']);
             }
             $request->session()->flash('msg', ['info', 'Thêm thành công!']);
         }*/


        //$image_ids = old('image_ids');
        $image_ids = old('image_ids');
        $this->data['relate_data'] = [
            'file_image_ids' => $image_ids ? Files::whereIn('id', $image_ids)->orderByRaw("FIELD(id," . implode(',', $image_ids) . ")")->get() : [],

        ];

        $this->data['isEditable'] = false;
        $this->data['warehouse'] = [];
        $this->data['branch'] = Branch::getAll([], 50);
        return view('backend.warehouse.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        if ($request->getMethod() == 'POST') {

            $aInit = Warehouse::get_validation_admin();
            Validator::make($request->all(), $aInit)->validate();
            $params = array_fill_keys(array_keys($aInit), null);
            $params = array_merge(
                $params, $request->only(array_keys($params))
            );

            $params['name'] = $request->get('name');
            $params['branch_id'] = $request->get('branch_id');
            $params['description'] = $request->get('description');

            $params['status'] = 0;
            $params['thumbnail_id'] = $request->get('image_ids')[0];
            // $image_ids =  $request->get('image_ids[]');
            //$params['thumbnail_id']  = $request->get('image_ids[]');
            // $params['thumbnail_id'] = empty($params['thumbnail_id']) ? $params['image_ids[]'][0] : $params['thumbnail_id'];

            $branch = Warehouse::create($params);
            $branch->save();
            $image_ids = $request->get('image_ids');
            if(!empty($image_ids)){
                foreach ($image_ids as $id){
                    BanImages::create([
                        'warehouse_id' => $branch->id,
                        'file_id' => $id,
                    ]);
                }
            }else{
                BanImages::create([
                    'warehouse_id' => $branch->id,
                    'file_id' => 763,
                ]);
            }

            if (!$branch) {


                $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui lòng thử lại!']);
            }
            $request->session()->flash('msg', ['info', 'Thêm thành công!']);


        }

        return redirect()->route('backend.warehouses.index');
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
    public function edit(Request $request, $id)
    {
        $this->data['isEditable'] = true;
        $this->data['warehouse'] = Warehouse::find($id);
        $this->data['branch'] = Branch::getAll([], 50);

        /* todo  26-07-22 - Ca: get list edit image */
        $product = Warehouse::find($id);
        $image_ids = old('image_ids', isset($product->thumbnail) ? $product->thumbnail->pluck('id')->toArray() : []);
        //  $image_ids = old('image_ids');
        $this->data['relate_data'] = [
            'file_image_ids' => $image_ids ? Files::whereIn('id', $image_ids)->orderByRaw("FIELD(id," . implode(',', $image_ids) . ")")->get() : [],

        ];
        /* todo  26-07-22 - Ca: get list edit image */

        return view('backend.warehouse.create', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreWarehouseRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // $params = $request->all();
        $params['name'] = $request->get('name');
        $params['branch_id'] = $request->get('branch_id');
        $params['description'] = $request->get('description');

        /* todo  26-07-22 - Ca: update list edit image */
        $image_ids = $request->get('image_ids');
        BanImages::where('warehouse_id', $id)->delete();
        if (!empty($image_ids)) {
            foreach ($image_ids as $idimage)
                BanImages::create([
                    'warehouse_id' => $id,
                    'file_id' => $idimage,
                ]);
        }
        /* todo  26-07-22 - Ca: update list edit image */

        $branch = Warehouse::find($id);
        if (!$branch) {
            $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui lòng thử lại!']);
        }
        $branch->update($params);
        $request->session()->flash('msg', ['info', 'Cập nhật thành công!']);
        return redirect()->route('backend.warehouses.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        $id = $request->id ?? 0;
        $branch = Warehouse::find($id);
        if (!$branch) {
            return ResponseHelper::error('Không thể Xóa', []);
        }

        $branch->delete();
        return ResponseHelper::success('Đã xóa thành công', []);
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function editban(Request $request, $id)
    {
        $this->data['isEditable'] = true;
        $this->data['warehouse'] = Warehouse::find($id);
        $paramss['status'] = 2;
       // $this->data['listban'] = Warehouse::getAll([$paramss], 50);
        $this->data['listban'] = Warehouse::Where('status','<>',2)->get();

        $this->data['branch'] = Branch::getAll([], 50);

        /* todo  26-07-22 - Ca: get list edit image */
        $product = Warehouse::find($id);
        $image_ids = old('image_ids', isset($product->thumbnail) ? $product->thumbnail->pluck('id')->toArray() : []);
        //  $image_ids = old('image_ids');
        $this->data['relate_data'] = [
            'file_image_ids' => $image_ids ? Files::whereIn('id', $image_ids)->orderByRaw("FIELD(id," . implode(',', $image_ids) . ")")->get() : [],

        ];
        /* todo  26-07-22 - Ca: get list edit image */

        return view('backend.warehouse.createban', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param StoreWarehouseRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateban(Request $request, $id)
    {
        // $params = $request->all();
        //$params['name'] = $request->get('name');
       // $params['branch_id'] = $request->get('branch_id');
       // $params['description'] = $request->get('description');

        /* todo  26-07-22 - Ca: update list edit image */
        $image_ids = $request->get('image_ids');
        BanImages::where('warehouse_id', $id)->delete();
        if (!empty($image_ids)) {
            foreach ($image_ids as $idimage)
                BanImages::create([
                    'warehouse_id' => $id,
                    'file_id' => $idimage,
                ]);
        }
        /* todo  26-07-22 - Ca: update list edit image */

        //
        $ban1 = Warehouse::find($id);

        $ban2 = Warehouse::find($request->get('branch_id'));

        if (empty($ban1)) {
            $request->session()->flash('msg', ['danger', 'Có lỗi xảy ra, vui lòng thử lại!']);
        }else{
            $order = Orders::find($ban1->order_id);
            //--------
            $paramsOder['warehouse_id'] = $ban2->id;
            $order->update($paramsOder);
            //--------
            $params2['order_id']  = $order->id;
            $params2['status'] = 2;

            $params1['order_id']  = 0;
            $params1['status'] = 0;
            $ban1->update($params1);
            //--------
            $ban2->update($params2);
        }



        $request->session()->flash('msg', ['info', 'Cập nhật thành công!']);
        return redirect()->route('backend.warehouses.index');
    }

    public function getbantokhuvuc(Request $request)
    {
       $params['branch_id'] = $request->get('branch_id');
        $params['status1'] = 2;
        //$product_typeLanguage = Warehouse::Where('status','<>',2)->where('branch_id','=',$request->get('branch_id'))->get();
        $product_typeLanguage = Warehouse::getAll($params);

        $return = [
            'e' => 0,
            'data' => $product_typeLanguage,
        ];
        return \Response::json($return);

    }
}
