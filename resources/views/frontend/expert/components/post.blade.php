@if(isset($postExpert) && $postExpert->count() >= 1)
    <div class="my-4 col-12">
        <p class="title d-flex align-items-center text-black"
           style="font-size: 24px; font-weight: 600">
            <img class="me-2"
                 src="https://cdn-icons-png.flaticon.com/128/318/318275.png" width="25px"
                 height="25px"
                 alt=""> Bài viết</p>
        <div class="row ">
            @forelse($postExpert as $item)
                <div class="col-xl-3 col-md-6">
                    <div class="blog__post-item shine__animate-item">
                        <div class="blog__post-thumb">
                            <a href="{{route('frontend.blogExpert.detail', $item->slug)}}"
                               class="shine__animate-link"><img
                                    src="{{$item->thumbnail ? $item->thumbnail->file_src : ''}}"
                                    alt="img"></a>
                            <span class="post-tag">{{$item->expertCategory->name ?? ''}}</span>
                        </div>
                        <div class="blog__post-content">
                            <div class="blog__post-meta">
                                <ul class="list-wrap">
                                    <li>
                                        <i class="flaticon-calendar"></i>{{(format_date_custom($item->created_at))}}
                                    </li>
                                    <li><i class="flaticon-user-1"></i>
                                        <a href="/chuyen-gia/{{ str_replace(' ', '', $expert->fullname) }}.{{$expert->id}}">{{$item->user->fullname ?? ''}}</a>
                                    </li>
                                </ul>
                            </div>
                            <h4 class="title custom_line_2" style="height: 50px">
                                <a class="" title="{{$item->name ?? ''}}"
                                   href="{{route('frontend.blogExpert.detail', $item->slug)}}">{{$item->name ?? ''}}</a>
                            </h4></div>
                    </div>
                </div>
            @empty
                <p>Không có bài viết nào</p>
            @endforelse
        </div>
        <nav aria-label="Page navigation example" class="d-flex justify-content-center">
            <ul class="pagination">
                {{$postExpert->links()}}
            </ul>
        </nav>
    </div>
@else

@endif
