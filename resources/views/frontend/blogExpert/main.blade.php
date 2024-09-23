@extends('frontend.layouts.frontend')

@section('content')


    <!-- dashboard-area -->
    <section class="dashboard__area section-pb-120 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="dashboard__content-wrap">
                        <div class="pb-4">
                            <p class="bg-light p-1"><a class="text-black font_weight_bold"
                                                       href="{{route('frontend.user.profile')}}"> Tài khoản </a>
                                / Quản lý bài viết</p>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-4">
                                    <a href="{{route('frontend.blogExpert.create')}}" class="btn_custom p-2">Đăng
                                        bài</a>
                                </div>
                                <div class="dashboard__review-table">
                                    <table class="table table-borderless">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Hình</th>
                                            <th style="width: 100px">Tên bài viết</th>
                                            <th>Danh mục</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th>Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($postExpert as $key => $item)
                                            <tr>
                                                <td>
                                                    {{$key+=1}}
                                                </td>
                                                <td>
                                                    <img style="width: 50px; height: 50px; object-fit: cover"
                                                         src="{{$item->thumbnail->file_src ?? ''}}" alt="">
                                                </td>


                                                <td><span class="custom_line_1"
                                                          style="width: 200px"> {{$item->name ?? ''}} </span></td>
                                                <td>
                                                    {{$item->expertCategory->name ?? ''}}
                                                </td>
                                                <td>
                                                    @if($item->status == 0)
                                                        <span class="dashboard__quiz-result hold">
                                                    Đang chờ duyệt
                                                </span>
                                                    @elseif($item->status == 1)
                                                        <span class="dashboard__quiz-result">
                                                        Đã duyệt
                                                </span>
                                                    @elseif($item->status == 3)
                                                        <span class="dashboard__quiz-result fail">
                                                        Đã Từ chối
                                                </span>
                                                    @else
                                                        <span class="dashboard__quiz-result">
                                                        Chưa xác định
                                                    </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{format_date_custom($item->created_at ?? '')}}
                                                </td>

                                                <td>
                                                    <div class="dashboard__review-action">
                                                        <a href="{{route('frontend.blogExpert.edit',$item->id )}}"
                                                           title="Edit"><i class="skillgro-edit"></i></a>
                                                        <a href="{{route('frontend.blogExpert.delete',$item->id )}}"
                                                           title="Delete"><i class="skillgro-bin"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty

                                        @endforelse
                                        </tbody>
                                    </table>


                                    <div class="mt-2 d-flex justify-content-end">
                                        <nav aria-label="Page navigation example">
                                            <ul class="pagination">
                                                {{$postExpert->links()}}
                                            </ul>
                                        </nav>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>



@endsection
