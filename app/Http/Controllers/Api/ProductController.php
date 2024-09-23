<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseAPIController;
use App\Jobs\InsertViewedProduct;
use App\Models\Product;
use App\Models\ProductPriceRange;
use App\Models\ProductType;
use App\Models\ProductVariation;
use App\Models\VariationValues;
use Illuminate\Http\Request;
use Validator;

class ProductController extends BaseAPIController
{
    /**
     * @OA\Get(
     *     path="/product/getAll",
     *     tags={"Products"},
     *     summary="Get all products",
     *     description="",
     *     operationId="ProductGetAll",
     *     @OA\Parameter( name="company_id", description="Company ID", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="api_key", description="API Key", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter(name="category_ids[]", description="Danh sách id danh mục, ex: [1,2,3]", required=false, in="query",
     *         @OA\Schema( type="array", @OA\Items())
     *     ),
     *     @OA\Parameter(name="keywords", description="Từ khóa tìm kiếm", required=false, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="price_from", description="Giá thấp nhất", required=false, in="query",
     *         @OA\Schema( type="integer", )
     *     ),
     *     @OA\Parameter( name="price_to", description="Giá cao nhất", required=false, in="query",
     *         @OA\Schema( type="integer", )
     *     ),
     *     @OA\Parameter( name="skip_product_ids[]", description="Danh sách id sản phẩm bỏ qua, ex: [1,2,3]", required=false, in="query",
     *         @OA\Schema( type="array", @OA\Items())
     *     ),
     *     @OA\Parameter( name="id_branch", description="id đại lý ", required=false, in="query",
     *         @OA\Schema( type="integer", )
     *     ),
     *     @OA\Parameter( name="token", description="token from api login", required=false, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="limit", description="limit", required=false, in="query",
     *         @OA\Schema( type="integer", )
     *     ),
     *     @OA\Parameter( name="page", description="page", required=false, in="query",
     *         @OA\Schema( type="integer", )
     *     ),
     *     @OA\Parameter( name="sort", description="sắp xếp sản phẩm", required=false, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Missing/Invalid params"),
     *     @OA\Response(response="500", description="Server error"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="403", description="Account is banned"),
     * )
     */
    public function getAll(Request $request)
    {
        //Log::info($request->all());
        if (!$request->get('company_id') || !$request->get('api_key'))
            return $this->throwError(400, 'Vui lòng nhập Company ID & API_Key!');

        $this->checkCompany($request->get('company_id'), $request->get('api_key'));

        if ($request->get('token', null))
            $user = $this->getAuthenticatedUser();

        $aInit = [
            'category_ids'       => null,
            'company_id'         => null,
            'api_key'            => null,
            'store_id'           => null,
            'store_category_ids' => null,
            'trademark_ids'      => null,
            'keywords'           => null,
            'price_from'         => null,
            'price_to'           => null,
            'skip_product_ids'   => null,
            'limit'              => null,
            'sort'               => null,
            'type'               => null,
        ];

        $params = array_merge(
            $aInit, $request->only(array_keys($aInit))
        );

        $validator = Validator::make($request->all(), [
//            'category_ids'       => 'nullable|array',
        'store_id'           => 'nullable|integer',
        'store_category_ids' => 'nullable|array',
        'trademark_ids'      => 'nullable|array',
        'keywords'           => 'nullable|string',
        'skip_product_ids'   => 'nullable|array',
        'price_from'         => 'nullable|integer|min:0',
        'price_to'           => 'nullable|integer|min:0',
        'limit'              => 'nullable|integer|min:1',
        'sort'               => 'nullable|string',
        'type'               => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->throwError($validator->errors()->first(), 400);
        }

        $params = array_filter($params);
        $params['token'] = $request->get('token');
        $params['pagin_path'] = route('product.getAll') . '?' . http_build_query($params);
        $params['sort'] = $request->get('sort', 'newest');
//        $params['sort'] = 'random';
        $params['status'] = 1;
//        $params['product_type_id'] = $request->get('category_ids');
//        $product_type = ProductType::get_by_where(['assign_key' => true,], ['id', 'name', 'parent_id']);
        $id_branch = 0;
        if(!empty($request->get('id_branch'))){
            $id_branch = $request->get('id_branch');
        }
        $params['id_branchs'] = $id_branch;

        if (isset($params['category_ids'])) {
            $array_tree_categories = \App\Utils\ProductType::buildTree(ProductType::get_all());
            $array_categories = \App\Utils\ProductType::treeToArray($array_tree_categories);
            foreach ($params['category_ids'] as $id) {
                $params['product_type_id'] = array_merge($params['category_ids'], \App\Utils\ProductType::get_all_child_categories($array_categories, $id));
            }
        }
        unset($params['category_ids']);


        $products = Product::get_by_where($params);

        foreach ($products as $product) {
            if ($product->point === null) {
                $product->point = 0;
            }
        }

        if (!empty($user)) {
            $today = strtotime(date('d-m-Y H:i')); // Thời gian hiện tại dưới dạng Unix timestamp
            $created_at = strtotime($user['created_at']); // Thời gian tạo tài khoản của $user dưới dạng Unix timestamp
            $diffInSeconds = abs($today - $created_at); // Sự chênh lệch giữa hai thời điểm (tính theo số giây)
            $days = floor($diffInSeconds / (60 * 60 * 24)); // Chuyển đổi số giây thành số ngày
            if ($days >= 365) {
                if ($user->point == null) {
                    $user->point = "0";
                    $user->created_at = now();
                    $user->save();
                }
            }
        }
        return $this->returnResult($products);
    }


    /**
     * @OA\Get(
     *     path="/product/{id}",
     *     tags={"Products"},
     *     summary="Get product by id",
     *     description="",
     *     operationId="ProductGetByID",
     *     @OA\Parameter( name="company_id", description="Company ID", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="api_key", description="API Key", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="token", description="token from api login", required=false, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="id", description="id", required=true, in="path",
     *         @OA\Schema( type="integer", )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Missing/Invalid params"),
     *     @OA\Response(response="500", description="Server error"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="403", description="Account is banned"),
     * )
     */
    public function detail($id, Request $request)
    {
        if (!$request->get('company_id') || !$request->get('api_key'))
            return $this->throwError(400, 'Vui lòng nhập Company ID & API_Key!');

        $this->checkCompany($request->get('company_id'), $request->get('api_key'));

        if ($request->get('token', null))
            $user = $this->getAuthenticatedUser();

        $product = Product::with(['product_type', 'thumbnail', 'images', 'images_extra',])
            ->where('company_id', config('constants.company_id'))
            ->find($id);
        if (!$product) {
            $this->throwError('Sản phẩm không tồn tại!', 400);
        }
        if ($product && isset($user)) {
            $this->dispatch(new InsertViewedProduct(['user_id' => $user->id, 'product_id' => $id, 'time' => time()]));
        }
//        $view_data = \View::getShared();
//        $all_category = ProductType::get_by_where([
//            'status'     => 1,
//            'assign_key' => true,
//        ]);
        $link_detail = url('/webview/product/' . $product->id);
        $product->link_detail = $link_detail;

        if ($product) {
            $variations = VariationValues::get_group_variations($id);

            $product_variations = [];
            $variation_combine = [];

            if (count($variations))
                $product_variations = ProductVariation::get_product_variations_with_combine($id);

            $variations = collect(['variations' => $variations]);
            $product_variations = collect(['product_variations' => $product_variations]);

//            $product_wholesales = ProductWholesales::select(['id', 'quantity_from', 'quantity_to', 'price'])->where('product_id', $id)->get();
//            $product_wholesales = collect(['wholesales' => $product_wholesales]);

            $product = collect($product);
            $PriceRanges = ProductPriceRange::where('product_id', $id)->get();
            $product['PriceRange'] = $PriceRanges;
            foreach ($PriceRanges as $k=>$PriceRange) {
                $quantity_end = '';
                $PriceRangetext = '';
                if ($PriceRange['quantity_max'] == 9999999) {
                    $quantity_end = 'Trở lên';
                    $PriceRangetext = 'Mua từ '.$PriceRange['quantity_min'].' sản phẩm trở lên giá : '.number_format($PriceRange['quantity_price']).' vnđ';
                } else {
                    $quantity_end = (string) $PriceRange['quantity_max'];
                    $PriceRangetext = 'Mua từ '.$PriceRange['quantity_min'].' đến '.$PriceRange['quantity_max'] .' sản phẩm giá : '.number_format($PriceRange['quantity_price']).' vnđ';
                }
                $product['PriceRange'][$k]['PriceRangetext'] = $PriceRangetext;
                $product['PriceRange'][$k]['quantity_end'] = $quantity_end;
                $product['PriceRange'][$k]['quantity_start'] = (string) $PriceRange['quantity_min'];


            }

            $product = $product->merge($variations)
                ->merge($product_variations)
                ->merge($variation_combine);
//                ->merge($product_wholesales);
        }

//        $return = [
//            $product,
//            $link_detail
//        ];
        return $this->returnResult($product);
    }

    /**
     * @OA\Get(
     *     path="/product/type/getAll",
     *     tags={"Products"},
     *     summary="Get all product type",
     *     description="",
     *     operationId="ProductTypeGetAll",
     *     @OA\Parameter( name="company_id", description="Company ID", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Parameter( name="api_key", description="API Key", required=true, in="query",
     *         @OA\Schema( type="string", )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     @OA\Response(response="400", description="Missing/Invalid params"),
     *     @OA\Response(response="500", description="Server error"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="403", description="Account is banned"),
     * )
     */
    public function getAllType(Request $request)
    {
        if (!$request->get('company_id') || !$request->get('api_key'))
            return $this->throwError(400, 'Vui lòng nhập Company ID & API_Key!');

        $this->checkCompany($request->get('company_id'), $request->get('api_key'));

        $data = ProductType::with(['thumbnail', 'icon'])
            ->where('company_id', config('constants.company_id'))
            ->where('status', 1)
            ->orderBy('priority', 'ASC')->get();

        return $this->returnResult($data);
    }

//
//    public function getRating($product_id, Request $request)
//    {
//        $aInit = [
//            'limit' => null,
//        ];
//
//        $params = array_merge(
//            $aInit, $request->only(array_keys($aInit))
//        );
//
//        $validator = Validator::make($request->all(), [
//            'limit' => 'nullable|integer|min:1',
//        ]);
//
//        if ($validator->fails())
//            return $this->throwError($validator->errors()->first(), 400);
//
//        $params = array_filter($params);
//        $params['product_id'] = $product_id;
//        $params['pagin_path'] = route('product.getRating', $product_id) . '?' . http_build_query($params);
//
//        $data = Rate::get_by_where($params, ['user']);
//
//        return $this->returnResult($data);
//    }
}
