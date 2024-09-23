<div class="col-xl-3 col-lg-4 order-2 order-lg-0">
    <aside class="courses__sidebar">
        <div class="courses-widget">
            <h4 class="widget-title">Danh mục</h4>
            <div class="courses-cat-list">
                <form action="{{ route('frontend.product.main') }}" method="get">
                    <ul class="list-wrap">
                        <li>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category_id" id="category_all" value="" {{ !isset($category_id) ? 'checked' : '' }}>
                                <label class="form-check-label" for="category_all">Tất cả</label>
                            </div>
                        </li>
                        @foreach($categoryExpert as $item)
                            <li>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category_id" id="category_{{ $item->id }}" value="{{ $item->id }}" {{ isset($category_id) && $category_id == $item->id ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category_{{ $item->id }}">{{ $item->name }}</label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <button type="submit" class="btn btn_custom mt-3">Chọn</button>
                </form>



            </div>
        </div>
    </aside>
</div>
