@extends('frontend.layouts.frontend')
@section('content')
    <!-- dashboard-area -->
    <section class="dashboard__area section-pb-120 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="dashboard__content-wrap">
                        <div class="pb-4">
                            <p class="bg-light p-1"><a class="text-black font_weight_bold"
                                                       href="{{route('frontend.user.profile')}}"> Tài khoản </a> / <a
                                    class="text-black font_weight_bold"
                                    href="{{route('frontend.plan.index')}}"> Danh sánh gói </a> / Tạo
                                gói</p>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-6 ">
                                <div class="dashboard__review-table p-2">
                                    <form action="{{route('frontend.plan.add')}}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <input id="sort" type="text" name="sort"
                                                   value="{{old('sort')}}"
                                                   placeholder="Số thứ tự hiển thị" class="form-control input_user">
                                            @if ($errors->has('sort'))
                                                <div class="custom_error">{{ $errors->first('sort') }}</div>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <input id="title" type="text" name="title"
                                                   value="{{old('title')}}"
                                                   placeholder="Tiêu đề" class="form-control input_user">
                                            @if ($errors->has('title'))
                                                <div
                                                    class="custom_error">{{ $errors->first('title') }}</div>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <textarea class="form-control input_user" name="desc" id="" rows="3"
                                                      placeholder="Mô tả">{{old('desc')}}</textarea>
                                            @if ($errors->has('desc'))
                                                <div class="custom_error">{{ $errors->first('desc') }}</div>
                                            @endif
                                        </div>


                                        <div class="mb-3">
                                            <div id="formatted-price"
                                                 style="margin-bottom: 10px; font-weight: bold; display: none"></div>
                                            <input id="price" type="text" name="price_formatted"
                                                   value="{{ old('price_formatted') }}" placeholder="Nhập giá"
                                                   class="form-control input_user">
                                            <input id="price-hidden" type="hidden" name="price"
                                                   value="{{ old('price') }}">
                                            @if ($errors->has('price'))
                                                <div class="custom_error">{{ $errors->first('price') }}</div>
                                            @endif
                                        </div>

                                        <div class="mb-3">
                                            <select class="form-select input_user"
                                                    name="option_plan" id="option_plan">
                                               @foreach(\App\Models\ExpertPlan::OPTION_PLAN as $item)
                                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                                                @endforeach

                                            </select>

                                        </div>

                                        <div class="mb-3 d-none" id="additional_info">
                                            <input id="number_people_max" type="text" name="number_people_max"
                                                   value="{{ old('number_people_max') }}" placeholder="Nhập số người tối đa cho nhóm mặt định là 2"
                                                   class="form-control input_user">
                                        </div>

                                        <div class="mb-3">
                                            <select class="form-select input_user" aria-label="Default select example"
                                                    name="status">
                                                <option selected value="">Trạng thái</option>
                                                <option value="1">Bật</option>
                                                <option value="2">Tắt</option>
                                            </select>
                                            @if ($errors->has('status'))
                                                <div class="custom_error">{{ $errors->first('status') }}</div>
                                            @endif
                                        </div>


                                        <div class="col-md-12 text-center">
                                            <div class="submit-btn mt-25">
                                                <button type="submit" class="categories_button">
                                                    <span class="categories_link">Thêm</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const priceInput = document.getElementById('price');
            const formattedPrice = document.getElementById('formatted-price');
            const priceHidden = document.getElementById('price-hidden');
            let oldValue = priceInput.value; // Lưu giá trị cũ

            // Hàm định dạng giá trị và cập nhật hiển thị
            function formatAndDisplayPrice(value) {
                // Remove non-numeric characters
                value = value.replace(/\D/g, '');

                // Add thousands separator
                let formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                // Update input value with formatted value
                priceInput.value = formattedValue;

                // Update the formatted price display
                formattedPrice.textContent = formattedValue ? `${formattedValue} VNĐ` : '';

                // Update the hidden input value
                priceHidden.value = value;
            }

            // Gọi hàm để hiển thị giá trị mặc định khi tải trang
            formatAndDisplayPrice(priceInput.value);

            // Lắng nghe sự kiện focus để xóa giá trị khi người dùng bắt đầu nhập liệu
            priceInput.addEventListener('focus', function () {
                oldValue = priceInput.value; // Lưu lại giá trị hiện tại trước khi xóa
                priceInput.value = '';
                formattedPrice.textContent = '';
            });

            // Lắng nghe sự kiện blur để khôi phục giá trị cũ nếu không có gì được nhập
            priceInput.addEventListener('blur', function () {
                if (priceInput.value === '') {
                    priceInput.value = oldValue;
                    formattedPrice.textContent = oldValue ? `${oldValue} VNĐ` : '';
                }
            });

            // Lắng nghe sự kiện nhập liệu để cập nhật giá trị khi người dùng nhập liệu
            priceInput.addEventListener('input', function (e) {
                formatAndDisplayPrice(e.target.value);
            });
        });

        $(document).ready(function() {
            $('#option_plan').change(function() {

                var selectedValue = $(this).val();

                if (selectedValue == '2') {
                    $('#additional_info').removeClass('d-none');
                } else {
                    $('#additional_info').addClass('d-none');
                }
            });
        });
    </script>


@endsection
