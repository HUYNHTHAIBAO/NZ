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
                @php
                    $user = \Illuminate\Support\Facades\Auth::guard('web')->user();
                    $expertUpdate = \App\Models\RegisterExpertUpdate::where('user_id', $user->id)->first();
                @endphp
                <div class="col-lg-9">
                    <div class="dashboard__content-wrap">
                        <div class="dashboard__content-title">
                            @isset($user->approved)
                                @if($user->approved == 1 || $user->approved == 2 || $user->approved == 3 )
                                    <h4 class="title text-center">Đăng ký chuyên gia</h4>
                                @else
                                    <h4 class="title text-center">Cập nhật chuyên gia</h4>
                                @endif
                            @endisset
                            <div class="ms-5 text-center">
                                @isset($user->approved)
                                    @if($user->approved == 1)
                                        <span class="badge bg-warning text-light">Đang chờ duyệt</span>
                                        <small>
                                            {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}
                                        </small>
                                    @elseif($user->approved == 2)
                                        <span class="badge bg-success text-light">Đã duyệt</span>
                                        <small>
                                            {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}
                                        </small>
                                    @elseif($user->approved == 3)
                                        <span class="badge bg-danger text-light">Đã từ chối</span> |
                                        <small><span class="font_weight_bold">Lý do </span>:
                                            {{$user->reason_for_refusal}}</small> |
                                        <small>
                                            {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}
                                        </small>
                                    @elseif($user->approved == 4)
                                        <span class="badge bg-warning text-light">Đang chờ duyệt cập nhật</span> |
                                        {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}
                                        </small>
                                    @elseif($user->approved == 5)
                                        <span class="badge bg-success text-light">Đã duyệt cập nhật</span> |
                                        {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}
                                        </small>
                                    @elseif($user->approved == 6)
                                        <span class="badge bg-danger text-light">Đã từ chối cập nhật</span> |
                                        <small><span class="font_weight_bold">Lý do </span>:
                                            {{$expertUpdate->reason_for_refusal}}</small> |
                                        <small>
                                            {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}
                                        </small>
                                    @else
                                        <span class="badge bg-danger text-light">Chưa xác định</span>
                                        <small>
                                            {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}
                                        </small>
                                    @endif
                                @endisset
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="itemOne-tab-pane" role="tabpanel"
                                         aria-labelledby="itemOne-tab" tabindex="0">
                                        <div class="instructor__profile-form-wrap">
                                            <form action="{{ route('frontend.user.registerExpert') }}"
                                                  class="instructor__profile-form" method="POST">
                                                @csrf
                                                @if($user->approved == 4)
                                                    <div class="row justify-content-center mt-5">

                                                        <div class="col-lg-8 col-12">
                                                            <label for="" class="font_weight_bold text-black mb-2">Thông
                                                                tin Giới thiệu : <span class="text-danger">*</span></label>
                                                            <div class="mb-3">
                                                                <select id="category_id_expert_update"
                                                                        name="category_id_expert" class="js-example-basic-single form-select">
                                                                    @foreach($category_expert as $item)
                                                                        <option value="{{ $item->id }}"
                                                                                @if(isset($expertUpdate->category_id_expert) && $item->id == $expertUpdate->category_id_expert)
                                                                                selected
                                                                            @endif
                                                                        >{{ $item->name ?? '' }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('category_id_expert'))
                                                                    <div
                                                                        class="custom_error">{{ $errors->first('category_id_expert') }}</div>
                                                                @endif
                                                            </div>


{{--                                                     --}}

                                                            <div class="mb-3">
                                                                <label for="tags_id" class="font_weight_bold">Chọn tags <span class="text-danger">*</span></label>
                                                                <select id="tags_id_update" class="js-example-basic-multiple form-select" name="tags_id[]" multiple="multiple">
{{--                                                                    @foreach ($tags_expert_details as $tag)--}}
{{--                                                                        <option value="{{ $tag->id }}"--}}
{{--                                                                                @if(in_array($tag->id, $selectedTags))--}}
{{--                                                                                selected--}}
{{--                                                                            @endif>--}}
{{--                                                                            {{ $tag->name }}--}}
{{--                                                                        </option>--}}
{{--                                                                    @endforeach--}}
                                                                </select>
                                                                @if ($errors->has('tags_id'))
                                                                    <div class="custom_error">{{ $errors->first('tags_id') }}</div>
                                                                @endif
                                                            </div>



                                                            <div class="form-grp">

                                                        <textarea id="bio" name="bio"
                                                                  placeholder="Giới thiệu">{{ old('bio', $expertUpdate->bio ?? '') }}</textarea>
                                                                @if ($errors->has('bio'))
                                                                    <div
                                                                        class="custom_error">{{ $errors->first('bio') }}</div>
                                                                @endif
                                                            </div>


                                                            <div class="form-grp">
                                                                <input id="job" name="job"
                                                                       placeholder="Nghề nghiệp hiện tại"
                                                                       value="{{ old('job', $expertUpdate->job ?? '') }}">
                                                                @if ($errors->has('job'))
                                                                    <div
                                                                        class="custom_error">{{ $errors->first('job') }}</div>
                                                                @endif
                                                            </div>

                                                            <div class="form-grp">
                                                             <textarea id="advise" name="advise"
                                                                  placeholder="Thing I can advice on">{{ old('advise', $expertUpdate->advise ?? '') }}</textarea>
                                                                @if ($errors->has('advise'))
                                                                    <div
                                                                        class="custom_error">{{ $errors->first('advise') }}</div>
                                                                @endif
                                                            </div>


                                                            <div class="form-grp">
                                                                <textarea id="questions" name="questions"
                                                                  placeholder="Question to ask with me">{{ old('questions', $expertUpdate->questions ?? '') }}</textarea>
                                                                @if ($errors->has('questions'))
                                                                    <div
                                                                        class="custom_error">{{ $errors->first('questions') }}</div>
                                                                @endif
                                                            </div>


                                                            <label for="" class="font_weight_bold text-black my-2">Liên
                                                                kết :</label>


                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Đường dẫn Facebook</span>
                                                                <input type="text" class="form-control m-0"
                                                                       name="facebook_link" id="basic-url"
                                                                       aria-describedby="basic-addon3"
                                                                       value="{{ old('facebook_link', $expertUpdate->facebook_link ?? '') }}"
                                                                       readonly
                                                                       placeholder="https://www.facebook.com">
                                                                @if ($errors->has('facebook_link'))
                                                                    <div
                                                                        class="custom_error">{{ $errors->first('facebook_link') }}</div>
                                                                @endif
                                                            </div>


                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Đường dẫn X</span>
                                                                <input type="text" class="form-control m-0"
                                                                       name="x_link" id="basic-url"
                                                                       aria-describedby="basic-addon3"
                                                                       value="{{ old('x_link', $expertUpdate->x_link ?? '') }}"
                                                                       placeholder="https://www.x.com"
                                                                >
                                                                @if ($errors->has('x_link'))
                                                                    <div
                                                                        class="custom_error">{{ $errors->first('x_link') }}</div>
                                                                @endif

                                                            </div>


                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Đường dẫn Instagram</span>
                                                                <input type="text" class="form-control m-0"
                                                                       name="instagram_link" id="basic-url"
                                                                       aria-describedby="basic-addon3"
                                                                       value="{{ old('instagram_link', $expertUpdate->instagram_link ?? '') }}"
                                                                       placeholder="https://www.instagram.com"
                                                                >
                                                                @if ($errors->has('instagram_link'))
                                                                    <div
                                                                        class="custom_error">{{ $errors->first('instagram_link') }}</div>
                                                                @endif

                                                            </div>


                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Đường dẫn TikTok</span>
                                                                <input type="text" class="form-control m-0"
                                                                       name="tiktok_link" id="basic-url"
                                                                       aria-describedby="basic-addon3"
                                                                       value="{{ old('instagram_link', $expertUpdate->tiktok_link ?? '') }}"
                                                                       placeholder="https://www.tikTok.com"
                                                                >
                                                                @if ($errors->has('tiktok_link'))
                                                                    <div
                                                                        class="custom_error">{{ $errors->first('tiktok_link') }}</div>
                                                                @endif
                                                            </div>


                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon3">Đường dẫn Linkedin</span>
                                                                <input type="text" class="form-control m-0"
                                                                       name="linkedin_link" id="basic-url"
                                                                       aria-describedby="basic-addon3"
                                                                       value="{{ old('linkedin_link', $expertUpdate->linkedin_link ?? '') }}"
                                                                       placeholder="https://www.linkedin.com"
                                                                >
                                                                @if ($errors->has('linkedin_link'))
                                                                    <div
                                                                        class="custom_error">{{ $errors->first('linkedin_link') }}</div>
                                                                @endif
                                                            </div>


                                                            <div class="submit-btn mt-25 text-center">
                                                                @isset($user->approved)
                                                                    @if($user->approved == 1)
                                                                        <button type="submit" class=""
                                                                                style="background-color: #ccc;padding: 10px; border-radius: 10px; border: none; color: #000"
                                                                                disabled>
                                                                            <span class="">Đang chờ duyệt</span>
                                                                        </button>
                                                                    @elseif($user->approved == 2)
                                                                        <button type="submit" class="categories_button">
                                                                            <span class="categories_link">Cập
                                                                            nhật</span>
                                                                        </button>
                                                                    @elseif($user->approved == 3)
                                                                        <button type="submit" class="categories_button">
                                                                            <span
                                                                                class="categories_link"> Đăng ký</span>
                                                                        </button>
                                                                    @elseif($user->approved == 4)
                                                                        <button type="submit" class=""
                                                                                style="background-color: #ccc;padding: 10px; border-radius: 10px; border: none; color: #000"
                                                                                disabled>
                                                                            <span
                                                                                class="">Đang chờ duyệt cập nhật</span>
                                                                        </button>
                                                                    @elseif($user->approved == 5)
                                                                        <button type="submit" class="categories_button">
                                                                            <span class="categories_link">Cập
                                                                            nhật</span>
                                                                        </button>
                                                                    @elseif($user->approved == 6)
                                                                        <button type="submit" class="categories_button">
                                                                            <span class="categories_link">Cập
                                                                            nhật</span>
                                                                        </button>
                                                                    @else
                                                                        <button type="submit" class="categories_button">
                                                                            <span class="Đăng ký"></span>
                                                                        </button>
                                                                    @endif
                                                                @endisset
                                                            </div>
                                                            @else
                                                                <div class="row justify-content-center">

                                                                    <div class="col-lg-8 col-12">

                                                                        <div class="mb-3">
                                                                            <label for="category_id_expert">Chọn danh mục</label>
                                                                            <select id="category_id_expert" name="category_id_expert" class="js-example-basic-single form-select">
                                                                                @foreach($category_expert as $item)
                                                                                    <option value="{{ $item->id }}"
                                                                                            @if(isset($user->category_id_expert) && $item->id == $user->category_id_expert)
                                                                                            selected
                                                                                        @endif>
                                                                                        {{ $item->name ?? '' }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            @if ($errors->has('category_id_expert'))
                                                                                <div class="custom_error">{{ $errors->first('category_id_expert') }}</div>
                                                                            @endif
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label for="tags_id" class="font_weight_bold" style="">Chọn tags <span class="text-danger">*</span></label>
                                                                            <select id="tags_id" class="js-example-basic-multiple form-select" name="tags_id[]" multiple="multiple">
{{--                                                                                @foreach ($tags_expert_details as $tag)--}}
{{--                                                                                    <option value="{{ $tag->id }}"--}}
{{--                                                                                            @if(in_array($tag->id, $selectedTags))--}}
{{--                                                                                            selected--}}
{{--                                                                                        @endif>--}}
{{--                                                                                        {{ $tag->name }}--}}
{{--                                                                                    </option>--}}
{{--                                                                                @endforeach--}}
                                                                            </select>
                                                                            @if ($errors->has('tags_id'))
                                                                                <div class="custom_error">{{ $errors->first('tags_id') }}</div>
                                                                            @endif
                                                                        </div>



                                                                        {{--                                                                        @foreach($tags_expert_details as $item)--}}
{{--                                                                            <span>{{$item->name ?? ''}}</span>--}}
{{--                                                                        @endforeach--}}


                                                                        <div class="form-grp">
                                                                            <label for="bio">Giới thiệu <span
                                                                                    class="text-danger">*</span></label>
                                                                            <textarea id="bio" name="bio"
                                                                                      placeholder="Giới thiệu">{{ old('bio', $user->bio ?? '') }}</textarea>
                                                                            @if ($errors->has('bio'))
                                                                                <div
                                                                                    class="custom_error">{{ $errors->first('bio') }}</div>
                                                                            @endif
                                                                        </div>
                                                                        <div class="form-grp">
                                                                            <label for="bio">Nghề nghiệp hiện tại <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input id="job" name="job"
                                                                                   placeholder="Nghề nghiệp hiện tại"
                                                                                   value="{{ old('job', $user->job ?? '') }}">
                                                                            @if ($errors->has('job'))
                                                                                <div
                                                                                    class="custom_error">{{ $errors->first('job') }}</div>
                                                                            @endif
                                                                        </div>

                                                                        <div class="form-grp">
                                                                            <label for="bio">Thing I can advice on <span
                                                                                    class="text-danger">*</span></label>
                                                             <textarea id="advise" name="advise"
                                                                       placeholder="Thing I can advice on">{{ old('advise', $user->advise ?? '') }}</textarea>
                                                                            @if ($errors->has('advise'))
                                                                                <div
                                                                                    class="custom_error">{{ $errors->first('advise') }}</div>
                                                                            @endif
                                                                        </div>


                                                                        <div class="form-grp">
                                                                            <label for="bio">Question to ask with me<span
                                                                                    class="text-danger">*</span></label>
                                                                <textarea id="questions" name="questions"
                                                                          placeholder="Question to ask with me">{{ old('questions', $user->questions ?? '') }}</textarea>
                                                                            @if ($errors->has('questions'))
                                                                                <div
                                                                                    class="custom_error">{{ $errors->first('questions') }}</div>
                                                                            @endif
                                                                        </div>


                                                                        <label for=""
                                                                               class="font_weight_bold text-black my-2">Liên
                                                                            kết :</label>


                                                                        <div class="input-group mb-3">
                                                                            <span class="input-group-text"
                                                                                  id="basic-addon3">Đường dẫn Facebook</span>
                                                                            <input type="text" class="form-control m-0"
                                                                                   name="facebook_link" id="basic-url"
                                                                                   aria-describedby="basic-addon3"
                                                                                   value="{{ old('linkedin_link', $user->facebook_link ?? '') }}"
                                                                                   placeholder="https://www.facebook.com">
                                                                            @if ($errors->has('facebook_link'))
                                                                                <div
                                                                                    class="custom_error">{{ $errors->first('facebook_link') }}</div>
                                                                            @endif

                                                                        </div>


                                                                        <div class="input-group mb-3">
                                                                            <span class="input-group-text"
                                                                                  id="basic-addon3">Đường dẫn X</span>
                                                                            <input type="text" class="form-control m-0"
                                                                                   name="x_link" id="basic-url"
                                                                                   aria-describedby="basic-addon3"
                                                                                   value="{{ old('x_link', $user->x_link ?? '') }}"
                                                                                   placeholder="https://www.x.com">
                                                                            @if ($errors->has('x_link'))
                                                                                <div
                                                                                    class="custom_error">{{ $errors->first('linkedin_link') }}</div>
                                                                            @endif

                                                                        </div>

                                                                        <div class="input-group mb-3">
                                                                            <span class="input-group-text"
                                                                                  id="basic-addon3">Đường dẫn Instagram</span>
                                                                            <input type="text" class="form-control m-0"
                                                                                   name="instagram_link" id="basic-url"
                                                                                   aria-describedby="basic-addon3"
                                                                                   value="{{ old('instagram_link', $user->instagram_link ?? '') }}"
                                                                                   placeholder="https://www.instagram.com">
                                                                            @if ($errors->has('instagram_link'))
                                                                                <div
                                                                                    class="custom_error">{{ $errors->first('instagram_link') }}</div>
                                                                            @endif

                                                                        </div>


                                                                        <div class="input-group mb-3">
                                                                            <span class="input-group-text"
                                                                                  id="basic-addon3">Đường dẫn Tiktok</span>
                                                                            <input type="text" class="form-control m-0"
                                                                                   name="tiktok_link" id="basic-url"
                                                                                   aria-describedby="basic-addon3"
                                                                                   value="{{ old('tiktok_link', $user->Tiktok ?? '') }}"
                                                                                   placeholder="https://www.tiktok.com">
                                                                            @if ($errors->has('tiktok_link'))
                                                                                <div
                                                                                    class="custom_error">{{ $errors->first('tiktok_link') }}</div>
                                                                            @endif

                                                                        </div>


                                                                        <div class="input-group mb-3">
                                                                            <span class="input-group-text"
                                                                                  id="basic-addon3">Đường dẫn Linkedin</span>
                                                                            <input type="text" class="form-control m-0"
                                                                                   name="linkedin_link" id="basic-url"
                                                                                   aria-describedby="basic-addon3"
                                                                                   value="{{ old('linkedin_link', $user->linkedin_link ?? '') }}"
                                                                                   placeholder="https://www.linkedin.com">
                                                                            @if ($errors->has('linkedin_link'))
                                                                                <div
                                                                                    class="custom_error">{{ $errors->first('linkedin_link') }}</div>
                                                                            @endif

                                                                        </div>


                                                                        <div class="submit-btn mt-25 text-center">
                                                                            @isset($user->approved)
                                                                                @if($user->approved == 1)
                                                                                    <button type="submit"
                                                                                            class="" disabled
                                                                                            style="background-color: #ccc;padding: 10px; border-radius: 10px; border: none; color: #000">
                                                                                        <span
                                                                                            class="">Đang chờ duyệt</span>
                                                                                    </button>
                                                                                @elseif($user->approved == 2)
                                                                                    <button type="submit"
                                                                                            class="categories_button">
                                                                                <span
                                                                                    class="categories_link">Cập nhật</span>
                                                                                    </button>
                                                                                @elseif($user->approved == 3)
                                                                                    <button type="submit"
                                                                                            class="categories_button">
                                                                                <span
                                                                                    class="categories_link">Đăng ký</span>
                                                                                    </button>
                                                                                @elseif($user->approved == 4)
                                                                                    <button type="submit"
                                                                                            class="" disabled
                                                                                            style="background-color: #ccc;padding: 10px; border-radius: 10px; border: none; color: #000">
                                                                                        <span class="">Đang chờ duyệt cập nhật</span>
                                                                                    </button>
                                                                                @elseif($user->approved == 5)
                                                                                    <button type="submit"
                                                                                            class="categories_button">
                                                                                <span
                                                                                    class="categories_link">Cập nhật</span>
                                                                                    </button>
                                                                                @elseif($user->approved == 6)
                                                                                    <button type="submit"
                                                                                            class="categories_button">
                                                                                <span
                                                                                    class="categories_link">Cập nhật</span>
                                                                                    </button>
                                                                                @endif
                                                                            @endisset
                                                                            @if(empty($user->approved))
                                                                                <button type="submit"
                                                                                        class="categories_button">
                                                                                    <span class="categories_link">Đăng ký</span>
                                                                                </button>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </form>
                                        </div>
                                    </div>
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
        $(document).ready(function() {
            // Xác định các giá trị tag đã chọn từ server
            var selectedTags = @json($selectedTags);

            // Gọi AJAX khi thay đổi danh mục
            $('#category_id_expert').change(function() {
                var category_id_expert = $(this).val();

                // AJAX để lấy các tags tương ứng
                $.ajax({
                    url: '{{ route('frontend.ajax.getTagsByCategory') }}',
                    type: 'POST',
                    data: {
                        category_id_expert: category_id_expert,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#tags_id').empty(); // Xóa các tags hiện tại
                        $.each(data, function(key, value) {
                            // Kiểm tra xem giá trị có phải là tag cần chọn không
                            var isSelected = selectedTags.includes(value.id) ? ' selected' : '';
                            $('#tags_id').append('<option value="'+ value.id +'"'+ isSelected +'>'+ value.name +'</option>');
                        });
                        // Đảm bảo các tùy chọn đã chọn được thiết lập đúng
                        $('#tags_id').val(selectedTags).trigger('change');
                    }
                });
            });

            // Trigger change event để load tags khi trang load
            $('#category_id_expert').trigger('change');
        });



        $(document).ready(function() {
            // Xác định các giá trị tag đã chọn từ server
            var selectedTags = @json($selectedTags);

            // Gọi AJAX khi thay đổi danh mục
            $('#category_id_expert_update').change(function() {
                var category_id_expert = $(this).val();

                // AJAX để lấy các tags tương ứng
                $.ajax({
                    url: '{{ route('frontend.ajax.getTagsByCategory') }}',
                    type: 'POST',
                    data: {
                        category_id_expert: category_id_expert,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#tags_id_update').empty(); // Xóa các tags hiện tại
                        $.each(data, function(key, value) {
                            // Kiểm tra xem giá trị có phải là tag cần chọn không
                            var isSelected = selectedTags.includes(value.id) ? ' selected' : '';
                            $('#tags_id_update').append('<option value="'+ value.id +'"'+ isSelected +'>'+ value.name +'</option>');
                        });
                        // Đảm bảo các tùy chọn đã chọn được thiết lập đúng
                        $('#tags_id_update').val(selectedTags).trigger('change');
                    }
                });
            });

            // Trigger change event để load tags khi trang load
            $('#category_id_expert').trigger('change');
        });
    </script>

@endsection

