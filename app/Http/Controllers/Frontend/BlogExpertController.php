<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseFrontendController;
use App\Models\CommentPostExpert;
use App\Models\CoreUsers;
use App\Models\ExpertCategory;
use App\Models\Files;
use App\Models\LikePostExpert;
use App\Models\Post;
use App\Models\PostExpert;
use App\Utils\Common as Utils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BlogExpertController extends BaseFrontendController
{
    //
    protected $_data = [];


    public function categorySideBar()
    {
        return ExpertCategory::where('status', 1)->orderBy('id', 'desc')->get();
    }


    public function main(Request $request)
    {
        $keyword = request()->input('search');

        $filter = array_merge(array(
            'keyword' => $keyword,
            'page' => null,
            'search' => null,
        ), $request->all());

        $params = [
            'pagin_path' => Utils::get_pagin_path($filter),
            'keyword' => $filter['search'],
            'status' => 1,
            'limit' => 12,
        ];

        $this->_data['items'] = PostExpert::get_by_where($params);

        $this->_data['categorySideBar'] = $this->categorySideBar();


        return view('frontend.blogExpert.index', $this->_data);
    }

    public function categories(Request $request, $slug)
    {
        // Lấy category theo slug
        $category = ExpertCategory::where('slug', $slug)->where('status', 1)->first();

        if ($category) {
            // Lấy tất cả bài viết trong danh mục đó
            $this->_data['data'] = PostExpert::where('expert_category_id', $category->id)
                ->where('status', 1)
                ->with(['thumbnail', 'expertCategory', 'user'])
                ->paginate(12);


            $this->_data['categorySideBar'] = $this->categorySideBar();

        }

        return view('frontend.blogExpert.categories', $this->_data);
    }


    public function detail(Request $request, $slug)
    {
        $post = PostExpert::where('slug', $slug)->where('status', 1)
            ->with(['thumbnail', 'expertCategory', 'user', 'comment'])
            ->first();

        $this->_data['commentCount'] = CommentPostExpert::where('post_id', $post->id)->count();
        $this->_data['likeCount'] = LikePostExpert::where('post_id', $post->id)->count();


        $this->_data['menu_active'] = 'news';

        $this->_data['title'] = $post->name;
        $this->_data['seo_title'] = $post->seo_title;

        $this->_data['description'] = $post->description;
        $this->_data['seo_description'] = $post->seo_descriptions;

        $this->_data['seo_keywords'] = $post->seo_keywords;

        $this->_data['post'] = $post;


        $relative_post = [];
        if ($post->expert_category_id) {
            $relative_post = PostExpert::get_by_where([
                'pagin' => false,
                'limit' => 5,
                'expert_category_id' => [$post->expert_category_id],
                'skip_ids' => [$post->id],
                'status' => PostExpert::STATUS_SHOW,
            ]);
        }

        $this->_data['relative_post'] = $relative_post;
        $this->_data['categorySideBar'] = $this->categorySideBar();

        $this->_data['can_index'] = $post->can_index;


        return view('frontend.blogExpert.detail', $this->_data);
    }

    public function comment(Request $request, $id)
    {
        // Tìm bài viết theo id
        $post = PostExpert::find($id);


        if (!$post) {
            return redirect()->back()->with('danger', 'Bài viết không tồn tại');
        }

        if ($request->isMethod('post')) {

            if (!Auth::guard('web')->check()) {
                return redirect()->back()->with('warning', 'Bạn cần đăng nhập để bình luận.');
            }
            // Validate dữ liệu nhập vào
            $request->validate([
                'content' => 'required',
            ],
                [
                    'content.required' => 'Nội dung không được để trống',
                ]);

            try {
                // Tạo mới bình luận
                $data = new CommentPostExpert();
                $data->content = $request->get('content');
                $data->user_id = Auth::guard('web')->id(); // Lấy user_id của người đăng nhập
                $data->post_id = $post->id;
                $data->save();

                return redirect()->back()->with('success', 'Bình luận thành công');
            } catch (\Exception $e) {
                return redirect()->back()->with('danger', 'Có lỗi xảy ra, vui lòng thử lại sau!');
            }
        }

    }

    public function like(Request $request, $id)
    {

        if (!Auth::guard('web')->check()) {
            return redirect()->back()->with('warning', 'Bạn cần đăng nhập đề sử dụng tính năng này');
        }

        $postExpert = PostExpert::find($id);

        // Kiểm tra xem người dùng đã like bài viết này chưa
        $like = LikePostExpert::where('user_id', Auth::guard('web')->id())->where('post_id', $postExpert->id)->first();
        if ($like) {
            return redirect()->back()->with('info', 'Bạn đã like bài viết này.');
        }

        // Tạo mới lượt like
        $newLike = new LikePostExpert();
        $newLike->user_id = Auth::guard('web')->id();
        $newLike->post_id = $postExpert->id;
        $newLike->save();


        return redirect()->back()->with('success', 'Like bài viết thành công');
    }

    public function unLike(Request $request, $id)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::guard('web')->check()) {
            return redirect()->back()->with('warning', 'Bạn cần đăng nhập để bỏ like bài viết.');
        }

        $postExpert = PostExpert::findOrFail($id);

        // Xóa lượt like của người dùng nếu tồn tại
        $like = LikePostExpert::where('user_id', Auth::guard('web')->id())->where('post_id', $postExpert->id)->first();
        if ($like) {
            $like->delete();
            return redirect()->back()->with('success', 'Bạn đã bỏ like bài viết.');
        }
    }


    public function index(Request $request)
    {

        $user = CoreUsers::find(Auth()->guard('web')->user()->id);
        $postExpert = PostExpert::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);

        $this->_data['postExpert'] = $postExpert;

        return view('frontend.blogExpert.main', $this->_data);
    }


    public function create(Request $request)
    {
        $user = CoreUsers::find(Auth()->guard('web')->user()->id);

        if ($request->getMethod() == 'POST') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'thumbnail_file_id' => 'required|file|max:1024 ',
            ], [
                'name.required' => 'Tên bài viết không được để trống',
                'name.max' => 'Tên danh mục không đượt vượt quá 255 ký tự',
                'thumbnail_file_id.required' => 'Hình ảnh bài viết không được để trống',
                'thumbnail_file_id.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            try {
                $file_path = null;
                if ($request->hasFile('thumbnail_file_id')) {
                    $file = $request->file('thumbnail_file_id');
                    $filename = uniqid();
                    $sub_dir = date('Y/m/d');
                    $ext = $file->extension();
                    $origin_file_name = $filename . '.' . $ext;
                    $file_path = $sub_dir . '/' . $origin_file_name;
                    $file->storeAs('public/uploads/' . $sub_dir, $origin_file_name);
                    $fileRecord = new Files();
                    $fileRecord->file_path = $file_path;
                    $fileRecord->user_id = $user->id;
                    $fileRecord->save();
                }
                // Tạo bài viết mới
                $postExpert = new PostExpert();
                $postExpert->name = $request->get('name');
                $postExpert->excerpt = $request->get('excerpt');
                $postExpert->detail = $request->get('detail');
                $postExpert->expert_category_id = $request->get('expert_category_id');
                $postExpert->user_id = $user->id;
                $postExpert->status = 0;
                $postExpert->slug = str_slug($request->get('name'));
                if (isset($fileRecord)) {
                    $postExpert->thumbnail_file_id = $fileRecord->id;
                }
                $postExpert->save();
                return redirect()->route('frontend.blogExpert.index')->with('info', 'Đăng bài thành công, vui lòng chờ duyệt');
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }
        $categoryExpert = ExpertCategory::where('status', 1)->get();
        $this->_data['categoryExpert'] = $categoryExpert;
        return view('frontend.blogExpert.create', $this->_data);
    }

    public function edit(Request $request, $id)
    {
        $user = CoreUsers::find(Auth()->guard('web')->user()->id);
        $postExpert = PostExpert::where('user_id', $user->id)->where('id', $id)->with('expertCategory')->first();
        if (!$postExpert) {
            return redirect()->route('frontend.blogExpert.index')->with('warning', 'Bài viết không tồn tại hoặc bạn không có quyền chỉnh sửa bài viết này.');
        }

        if ($request->getMethod() == 'POST') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'thumbnail_file_id' => 'sometimes|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ], [
                'name.required' => 'Tên bài viết không được để trống',
                'name.max' => 'Tên bài viết không được vượt quá 255 ký tự',
                'thumbnail_file_id.mimes' => 'Hình ảnh không đúng định dạng',
                'thumbnail_file_id.max' => 'Dung lượng hình ảnh không được vượt quá 2MB',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            try {
                $file_path = null;
                if ($request->hasFile('thumbnail_file_id')) {
                    $file = $request->file('thumbnail_file_id');
                    $filename = uniqid();
                    $sub_dir = date('Y/m/d');
                    $ext = $file->extension();
                    $origin_file_name = $filename . '.' . $ext;
                    $file_path = $sub_dir . '/' . $origin_file_name;
                    $file->storeAs('public/uploads/' . $sub_dir, $origin_file_name);
                    $fileRecord = new Files();
                    $fileRecord->file_path = $file_path;
                    $fileRecord->user_id = $user->id;
                    $fileRecord->save();
                }

                // Cập nhật bài viết
                $postExpert->name = $request->get('name');
                $postExpert->excerpt = $request->get('excerpt');
                $postExpert->detail = $request->get('detail');
                $postExpert->expert_category_id = $request->get('expert_category_id');
                $postExpert->slug = str_slug($request->get('name'));
                if (isset($fileRecord)) {
                    $postExpert->thumbnail_file_id = $fileRecord->id;
                }
                $postExpert->save();

                return redirect()->route('frontend.blogExpert.index')->with('info', 'Cập nhật bài viết thành công, vui lòng chờ duyệt');
            } catch (\Exception $e) {
                return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
            }
        }

        $categoryExpert = ExpertCategory::where('status', 1)->get();
        $this->_data['categoryExpert'] = $categoryExpert;
        $this->_data['postExpert'] = $postExpert;
        return view('frontend.blogExpert.edit', $this->_data);
    }


    public function delete(Request $request, $id)
    {
        try {
            $postExpert = PostExpert::find($id);
            $postExpert->delete();

            return redirect()->route('frontend.blogExpert.index')->with('success', 'Xóa thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }

    }

}
