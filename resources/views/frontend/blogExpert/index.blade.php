@extends('frontend.layouts.frontend')

@section('content')


    <section class="blog-area section-py-120 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 col-lg-8">
                    <div class="row gutter-20">
                        @forelse($items as $item)
                            <div class="col-xl-4 col-md-6">
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
                                                    <a href="#">{{$item->user->fullname ?? ''}}</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <h4 class="title custom_line_2">
                                            <a class="" title="{{$item->name ?? ''}}"
                                               href="{{route('frontend.blogExpert.detail', $item->slug)}}">{{$item->name ?? ''}}</a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        @empty

                        @endforelse
                    </div>
                    <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                        <ul class="pagination">
                            {{$items->links()}}
                        </ul>
                    </nav>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <aside class="blog-sidebar">
                        @include('frontend.blogExpert.sidebar')
                    </aside>
                </div>
            </div>
        </div>
    </section>


@endsection
