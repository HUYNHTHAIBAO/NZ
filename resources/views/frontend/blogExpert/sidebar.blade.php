
    <div class="blog-widget widget_search">
        <div class="sidebar-search-form">
            <form action="{{route('frontend.blogExpert.main')}}" method="get">
                <input type="text" name="search" placeholder="Tìm kiếm bài viết..." value="{{request()->get('search', '')}}">
                <button><i class="flaticon-search"></i></button>
            </form>
        </div>
    </div>
    <div class="blog-widget">
        <h4 class="widget-title">Danh mục</h4>
        <div class="shop-cat-list">
            <ul class="list-wrap" id="categoryList">
                @forelse($categorySideBar as $item)
                    <li>
                        <a href="{{ route('frontend.blogExpert.categories', $item->slug) }}">
                            <i class="flaticon-angle-right"></i>{{$item->name ?? ''}}
                        </a>
                    </li>
                @empty
                @endforelse
            </ul>


        </div>
    </div>

