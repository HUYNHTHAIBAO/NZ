<section class="all-courses-area section-py-120">
    <div class="container">
        <div class="row">
            @include('frontend.category.sidebar')
            <div class="col-xl-9 col-lg-8">
                <div class="courses-top-wrap courses-top-wrap">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <div class="courses-top-left">
                                {{--                                    <p>Hiển thị {{$products->firstItem()}}–{{$products->lastItem()}}</p>--}}
                                {{--                                trong {{$products->total()}} kết quả</p>--}}
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div
                                class="d-flex justify-content-center justify-content-md-end align-items-center flex-wrap">
                                <div class="courses-top-right m-0 ms-md-auto">
                                    <span class="sort-by">Sắp xếp:</span>
                                    <div class="courses-top-right-select">
                                        {{--                                            <select name="orderby" class="orderby">--}}
                                        {{--                                                <option value="Most Popular">Mặc định</option>--}}
                                        {{--                                                <option value="popularity">Tên (A-Z)</option>--}}
                                        {{--                                                <option value="average rating">Tên (Z-A)</option>--}}
                                        {{--                                                <option value="latest">Giá thấp nhất</option>--}}
                                        {{--                                                <option value="latest">Giá cao nhất</option>--}}
                                        {{--                                            </select>--}}


                                        <form action="{{ route('frontend.product.main') }}" method="get" id="form-sort">
                                            <select class="sort_product" name="sort" onchange="$('#form-sort').submit()">
                                                <option value="" {{ !$sort ? 'selected' : '' }}>Mặc định</option>
                                                <option value="name_a_z" {{ $sort == 'name_a_z' ? 'selected' : '' }}>Tên (A - Z)</option>
                                                <option value="name_z_a" {{ $sort == 'name_z_a' ? 'selected' : '' }}>Tên (Z - A)</option>
                                            </select>
                                        </form>



                                    </div>
                                </div>
                                <ul class="nav nav-tabs courses__nav-tabs" id="myTab" role="tablist">


                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="grid" role="tabpanel" aria-labelledby="grid-tab">
                        <div
                            class="row courses__grid-wrap row-cols-1 row-cols-xl-3 row-cols-lg-2 row-cols-md-2 row-cols-sm-1">
                            @forelse($expert as $key => $item)
                                <div class="col">
                                    <div class="courses__item shine__animate-item">
                                        <div class="courses__item-thumb">
                                            <a href="/chuyen-gia/{{ str_replace(' ', '', $item->fullname) }}.{{$item->id}}" class="shine__animate-link">
                                                <img src="{{asset('storage/uploads') . '/' . $item->avatar_file_path ?? ''}}" alt="img">
                                            </a>
                                        </div>
                                        <div class="courses__item-content">
                                            <ul class="courses__item-meta list-wrap">
                                                {{--                                                <li class="courses__item-tag">--}}
                                                {{--                                                    <a href="#">Development</a>--}}
                                                {{--                                                </li>--}}
                                                {{--                                                <li class="avg-rating"><i class="fas fa-star"></i> (4.8 Reviews)</li>--}}
                                            </ul>
                                            {{--                                            <h5 class="title"><a href="#">Learning JavaScript With--}}
                                            {{--                                                    Imagination</a></h5>--}}
                                            <p class="author"><a href="#">{{$item->fullname ?? ''}}</a></p>
                                            <div class="courses__item-bottom d-flex align-items-center justify-content-center">
                                                <a href="/chuyen-gia/{{ str_replace(' ', '', $item->fullname) }}.{{$item->id}}">
                                                    <div class="button btn_custom" style="padding: 10px; border-radius: 10px">
                                                        <span class="text">Xem chi tiết</span>
                                                        {{--                                        <i class="flaticon-arrow-right"></i>--}}
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty

                            @endforelse
                        </div>
                        <div class="mt-2 d-flex justify-content-end">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    {{$expert->links()}}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
