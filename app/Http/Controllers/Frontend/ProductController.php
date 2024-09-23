<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseFrontendController;
use App\Models\CoreUsers;
use App\Models\ExpertCategory;
use App\Models\ExpertCategoryTags;
use App\Models\ExpertCategoryTagsPivot;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\VariationValues;
use App\Models\Wishlist;
use App\Utils\Category;
use App\Utils\Common;
use App\Utils\Common as Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use View;

class ProductController extends BaseFrontendController
{
    public function main(Request $request)
    {
        $query = CoreUsers::query();

        // Điều kiện tìm kiếm theo fullname hoặc bio
        if ($request->filled('key')) {
            $query->where(function ($q) use ($request) {
                $q->where('fullname', 'like', '%' . $request->get('key') . '%')
                    ->orWhere('bio', 'like', '%' . $request->get('key') . '%');
            });
        }

        // Điều kiện lọc theo danh mục
        $categoryId = $request->get('category_id_expert', '');
        if ($categoryId) {
            $query->where('category_id_expert', $categoryId);
        }

        // Điều kiện lọc theo tags
        if ($request->has('tags')) {
            $tagIds = $request->get('tags');
            $query->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('tags_id', $tagIds)
                    ->groupBy('expert_category_id')
                    ->havingRaw('COUNT(DISTINCT tags_id) = ?', [count($tagIds)]);
            });
        }


        // Thêm các điều kiện khác
        $query->where(function ($query) {
            $query->where('account_type', 2)
                ->orWhere('approved', 2)
                ->orWhere('approved', 5);
        });



        $query->leftJoin('settting_time_rates_duration', function ($join) {
            $join->on('lck_core_users.id', '=', 'settting_time_rates_duration.user_id')
                ->where('settting_time_rates_duration.duration_id', '=', 1);
        })
            ->select('lck_core_users.*', DB::raw('COALESCE(settting_time_rates_duration.price, 0) as price'))
            ->groupBy('lck_core_users.id');

// Lọc theo giá
        if ($request->has('price_filter')) {
            $priceFilter = $request->get('price_filter');

            switch ($priceFilter) {
                case 'desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'below_2':
                    $query->where('price', '<', 2000000);
                    break;
                case '2_4':
                    $query->whereBetween('price', [2000000, 4000000]);
                    break;
                case '4_7':
                    $query->whereBetween('price', [4000000, 7000000]);
                    break;
                case '7_13':
                    $query->whereBetween('price', [7000000, 13000000]);
                    break;
                case 'above_15':
                    $query->where('price', '>', 15000000);
                    break;
                case 'all': // Xử lý tùy chọn 'Tất cả'
                    break;
            }
        }



        $data = $query->get();

        $this->_data['expert'] = $data;
        $this->_data['expertCategory'] = ExpertCategory::where('status', 1)->orderBy('id', 'desc')->get();
        $this->_data['activeCategoryId'] = $categoryId;

        $activeCategory = ExpertCategory::find($categoryId);
        $this->_data['activeCategoryName'] = $activeCategory ? $activeCategory->name : '';

        $tags = ExpertCategoryTagsPivot::where('expert_category_id', $categoryId)
            ->pluck('tags_id');
        $this->_data['tags'] = ExpertCategoryTags::whereIn('id', $tags)->get();

        return view('frontend.category.index', $this->_data);
    }



    public function route(Request $request, $slug)
    {
        $aSlug = explode('/', $slug);

        $slug = end($aSlug);

        $category = Category::get_by_slug($this->all_category, $slug);

        if (!empty($category))
            return $this->category($request, $category);
        else
            return $this->detail($request, $slug);
    }

    public function category(Request $request, $category)
    {
        $categories = PostCategory::get_all();

        $this->_data['all_categories'] = $categories;

        $all_child = Category::get_all_child_categories($this->all_category, $category['id']);

        $all_child_near = Category::get_all_child_categories_near($this->all_category, $category['id']);

        $this->_data['all_child'] = $all_child_near;

        $all_child = array_merge($all_child, [$category['id']]);

        $products = Product::get_by_where([
            'sort'            => $request->get('sort', null),
            'price_range'     => $request->get('price_range', null),
            'status'          => 1,
            'product_type_id' => $all_child,
            'limit'           => 9,
            'pagin'           => true,
            'pagin_path'      => Common::get_pagin_path($request->all()),
        ]);

        $this->_data['products'] = $products;
        $this->_data['category'] = $category;
        $this->_data['category_id'] = $category['id'];
        $this->_data['title'] = $category['name'];
        $this->_data['seo_title'] = $category['seo_title'];

        $this->_data['description'] = $category['description'];
        $this->_data['seo_description'] = $category['seo_descriptions'];

        $this->_data['seo_keywords'] = $category['seo_keywords'];

        if ($category['thumbnail'])
            $this->_data['image_fb_url'] = $category['thumbnail']['file_src'];

        $this->_data['can_index'] = $category['can_index'];

        $parent_cate_ids = Category::get_all_parent_id($this->all_category, $category['id']);

        $breadcrumbs = [];

        foreach ($parent_cate_ids as $v) {
            $breadcrumbs[] = array(
                'link' => $this->all_category[$v]['link'],
                'name' => $this->all_category[$v]['name'],
            );
        }

        $breadcrumbs[] = array(
            'link' => 'javascript:;',
            'name' => $category['name']
        );
        $this->_data['menu_active'] = '';
        $this->_data['breadcrumbs'] = $breadcrumbs;

        return view('frontend.category.index', $this->_data);
    }

    public function detail(Request $request, $slug)
    {
        $product = Product::get_by_slug($slug);
        if (empty($product) || $product->status != 1)
            abort(404);

        if (!isset($this->all_category[$product->product_type_id]))
            abort(404);

        $category = $this->all_category[$product->product_type_id];

        $out_of_stock = 0;

        if ($product->inventory_management && !$product->inventory_policy && $product->inventory < 1)
            $out_of_stock = 1;

        $product->out_of_stock = $out_of_stock;

        $this->_data['category'] = $category;
        $this->_data['title'] = $product->title;
        $this->_data['seo_title'] = $product->seo_title;

        $this->_data['description'] = $product->description;
        $this->_data['seo_description'] = $product->seo_descriptions;

        $this->_data['seo_keywords'] = $product->seo_keywords;

        if ($product->image_fb)
            $this->_data['image_fb_url'] = $product->image_fb->file_src;

        $this->_data['product'] = $product;

        $this->_data['arr_product_variants'] = VariationValues::get_group_variations($product->id);

        $parent_cate_ids = Category::get_all_parent_id($this->all_category, $category['id']);

        $breadcrumbs = [];

        foreach ($parent_cate_ids as $v) {
            $breadcrumbs[] = array(
                'link' => $this->all_category[$v]['link'],
                'name' => $this->all_category[$v]['name'],
            );
        }

        $breadcrumbs[] = array(
            'link' => $this->all_category[$category['id']]['link'],
            'name' => $this->all_category[$category['id']]['name'],
        );

        $breadcrumbs[] = array(
            'link' => 'javascript:;',
            'name' => $product->title
        );

        $this->_data['menu_active'] = '';
        $this->_data['breadcrumbs'] = $breadcrumbs;
        $this->_data['can_index'] = $product->can_index;

        //get related
        $related_products = Product::get_by_where([
            'status'            => 1,
            'status_censorship' => 1,
            'product_type_id'   => [$category['id']],
            'skip_product_ids'  => $product->id,
            'limit'             => 6,
            'pagin'             => false,
        ]);
        $this->_data['related_products'] = $related_products;

        return view('frontend.product.detail', $this->_data);
    }

    public function system(Request $request)
    {
        $user = CoreUsers::find(Auth::guard('web')->user()->id);

        if (!$user) return abort(404);
        $filter = $params = array_merge(array(
            'name'   => null,
            'status' => null,
        ), $request->all());

        $params['pagin_path'] = Utils::get_pagin_path($filter);

        $data = CoreUsers::where('referrer_id', $user->id)->get();

        $breadcrumbs = [];

        $breadcrumbs[] = array(
            'link' => 'javascript:;',
            'name' => 'Quản lý hệ thống'
        );
        $this->_data['breadcrumbs'] = $breadcrumbs;
        $this->_data['list_data'] = $data;
//        $this->_data['type_html'] = $type_html;
        $this->_data['filter'] = $filter;
        $this->_data['start'] = 0;

        return view('frontend.user.system', $this->_data);
    }

    public function ajaxUser(Request $request)
    {
        $msg = '';
        $error = '';
        $user = CoreUsers::where('referrer_id', $request->id)->get();

        $html = [];
        if (!empty($user)) {
            foreach ($user as $k => $v) {
                $fullname = $v->fullname ? $v->fullname : '';
                $name = $v->phone . '/' . $fullname;
                $html[] .= '<li><a class="onClickShowChild" data-id="' . $v->id . '">' . $name . ' </a><ul class="child_' . $v->id . ' tree-view-child" style="padding-left: 100px"></ul>';
            }
            $html[] .= '</li>';
        }
        $data = [
            'data'  => [
                'html' => $html,
            ],
            'msg'   => $msg,
            'error' => $error,
        ];
        return response()->json($data, 200);
    }

    public function variation(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $getData = array_merge(array(
                'product_id'          => null,
                'variation_value_ids' => null,
            ), $request->all());

            $product_variant = [];
            $can_buy = false;
            if (!empty($getData['product_id']) && !empty($getData['variation_value_ids'])) {

                $product_variants = ProductVariation::get_product_variations_with_combine($getData['product_id']);

                $_variation_value_ids = $getData['variation_value_ids'];
                sort($_variation_value_ids);
                foreach ($product_variants as $k => $v) {
                    $VariationValueCombination = explode(',', $v->variation_value_combination);

                    sort($VariationValueCombination);

                    if ($VariationValueCombination == $_variation_value_ids) {
                        $product_variant = $v;
                        $can_buy = true;
                        $galleries = !empty($v->gallery) ? json_decode($v->gallery, true) : [];
                        break;
                    }
                }

                if (!$can_buy) {
                    foreach ($product_variants as $k => $v) {
                        $VariationValueCombination = explode(',', $v->variation_value_combination);

                        sort($VariationValueCombination);
                        $variant_value_id = end($getData['variation_value_ids']);
                        if (in_array($variant_value_id, $VariationValueCombination)) {
                            $galleries = !empty($v->gallery) ? json_decode($v->gallery, true) : [];
                            break;
                        }
                    }
                }
            }

            if ($product_variant) {
                $out_of_stock = 0;

                if ($product_variant->inventory_management && $product_variant->inventory < 1 && !$product_variant->inventory_policy)
                    $out_of_stock = 1;

                $product_variant->out_of_stock = $out_of_stock;

                if ($out_of_stock)
                    $can_buy = 0;

                $product_variant->price_text = number_format($product_variant->price) . ' đ';
            }

            $galleries_html = '';

            if (count($galleries)) {
                $galleries_html = view('frontend.product.galleries')
                    ->with('galleries', $galleries)
                    ->render();
            } else {
                $product = Product::with('images')->find($getData['product_id']);
                $galleries_html = view('frontend.product.galleries')
                    ->with('galleries', $product->images)
                    ->render();
            }

            $return = [
                'status'         => true,
                'variation'      => $product_variant,
                'can_buy'        => $can_buy,
                'inventory_text' => $can_buy ? 'Còn hàng' : 'Hết hàng',
                'galleries_html' => $galleries_html,
            ];
            echo json_encode($return, JSON_UNESCAPED_UNICODE);
        }

        exit;
    }

    public function wishlist(Request $request)
    {
        if (!Auth::guard('web')->check()) {
            return abort(404);
        }

        $user = CoreUsers::find(Auth::guard('web')->user()->id);

        $wish_list = Wishlist::with(['product'])
            ->where('user_id', $user->id)->get();


        $breadcrumbs[] = array(
            'link' => 'javascript:;',
            'name' => 'Danh sách yêu thích'
        );

        $this->_data['wish_list'] = $wish_list;
        $this->_data['breadcrumbs'] = $breadcrumbs;

        return view('frontend.product.wishlist', $this->_data);
    }
    public function webviewDetail($id)
    {
        $product = Product::findOrFail($id);
        return view('frontend.product.webviewDetail', ['post' => $product]);
    }
}
