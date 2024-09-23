@extends('frontend.layouts.frontend')

@section('content')


    <!-- dashboard-area -->
    <section class="dashboard__area section-pb-120 mt-5">
        <div class="container">
            @include('frontend.user.header')
            <div class="row">
                <div class="col-lg-3">
                    @include('frontend.user.sidebar')
                </div>
                <div class="col-lg-9">
                    <div class="dashboard__content-wrap">
                        <div class="dashboard__content-title text-center">
                            <h4 class="title">Danh sách câu hỏi</h4>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-4">
                                    <a href="{{route('frontend.questionExpert.add')}}" class="btn_custom p-2">Thêm câu hỏi</a>
                                    {{--                                    <a href="{{route('frontend.youtubeExpert.add')}}" class="btn_custom p-2"> </a>--}}

                                </div>
                                <div class="dashboard__review-table">
                                    <table class="table table-borderless">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tiêu đề</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th class="text-end">Hành động</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($data as $key => $item)
                                            <tr>
                                                <td>
                                                    {{$key+=1}}
                                                </td>
                                                <td>
                                                    {{$item->title ?? ''}}
                                                </td>
                                                <td>
                                                    @if($item->status == 1)
                                                        <span class="dashboard__quiz-result hold">
                                                    Đang chờ duyệt
                                                </span>
                                                    @elseif($item->status == 2)
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
                                                        <a href="{{route('frontend.questionExpert.edit',$item->id )}}"
                                                           title="Edit"><i class="skillgro-edit"></i></a>
                                                        <a href="{{route('frontend.questionExpert.delete',$item->id )}}"
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
                                                {{$data->links()}}
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
