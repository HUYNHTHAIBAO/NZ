@extends('backend.layouts.main')

@section('content')



    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-black font-weight-bold">{{$subtitle}}</h3>
        </div>
        <div class="col-md-7 align-self-center">
            {{ Breadcrumbs::render('backend.expert.detail') }}
        </div>
    </div>



    <div class="row page-titles">
        <div class="col-md-12">
            <div class="col-3">
                <p class="font-weight-bold">Thông tin trạng thái : </p>
                @if($dataId->approved == 1)
                    <div class="shadow-lg p-3 mb-5 bg-light rounded">
                                    <span class="badge bg-warning text-white">
                                        Đang chờ duyệt <i class="mdi mdi-lan-pending"></i>
                                    </span>
                        <small>
                            - {{ \Carbon\Carbon::parse($dataId->updated_at)->format('d/m/Y H:i:s') }}
                        </small>
                    </div>
                @elseif($dataId->approved == 2 )
                    <div class="shadow-lg p-3 mb-5 bg-light rounded">
                                <span class="badge bg-success text-white">
                                    Đã duyệt <i class="mdi mdi-check"></i>
                                </span>
                        <small>
                            - {{ \Carbon\Carbon::parse($dataId->updated_at)->format('d/m/Y H:i:s') }}
                        </small>
                    </div>
                @elseif($dataId->approved == 3)
                    <div class="shadow-lg p-3 mb-5 bg-white rounded">
                                <span class="badge bg-danger text-white">
                                    Đã từ chối <i class="mdi mdi-close-box"></i>
                                </span>
                        <small>
                            - {{ \Carbon\Carbon::parse($dataId->updated_at)->format('d/m/Y H:i:s') }}
                        </small>
                    </div>
                @else
                    <div class="shadow-lg p-3 mb-5 bg-white rounded">
                                        <span class="badge bg-secondary text-white">
                                            Chưa xác định
                                        </span>
                    </div>
                @endif
            </div>
            <div class="card card-outline-info">
                <div class="card-body row">
                    <div class="col-6">
                        <form action="{{ route('backend.expert.approved', $dataId->id) }}" method="post">
                            @csrf
                            <div class="form-body">
                                <div class="row p-t-20">

                                    <div class="form-group col-12">
                                        <label for="category_id_expert" class="font-weight-bold">Danh mục</label>
                                        <select id="category_id_expert" class="custom-select custom-select-lg mb-3"
                                                disabled name="">
                                            @foreach($category_expert as $item)
                                                <option value="{{ $item->id }}"
                                                        @if(isset($dataId->category_id_expert) && $item->id == $dataId->category_id_expert)
                                                        selected
                                                    @endif >{{ $item->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="category_id_expert" class="font-weight-bold">Tags</label>
                                        <ul>
                                            @foreach($tags_expert as $item)
                                                @if(isset($dataId->tags_id) && in_array($item->id, json_decode($dataId->tags_id, true)))
                                                    <li>{{ $item->name ?? '' }}</li>
                                                @endif
                                            @endforeach
                                        </ul>


                                    </div>

                                    <div class="form-group col-12">
                                        <label for="bio" class="font-weight-bold">Giới thiệu</label>
                                        <textarea class="form-control" id="bio" rows="3"
                                                  readonly>{{ $dataId->bio ?? '' }}
                                        </textarea>
                                    </div>


                                    <div class="form-group col-12">
                                        <label for="job">Nghề nghiệp hiện tại</label>
                                        <input class="form-control" id="job" name="" type="text" readonly
                                               value="{{ $dataId->job ?? '' }}">
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="advise" class="">Thing I can advice on</label>
                                        <textarea class="form-control" id="advise" rows="3"
                                                  readonly>{{ $dataId->advise ?? '' }}
                                        </textarea>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="questions" class="">Question to ask with me</label>
                                        <textarea class="form-control" id="questions" rows="3"
                                                  readonly>{{ $dataId->questions ?? '' }}
                                        </textarea>
                                    </div>


                                    <div class="form-group col-12">
                                        <label for="facebook_link">Facebook</label>
                                        <input class="form-control" id="facebook_link" name="" type="text" readonly
                                               value="{{ $dataId->facebook_link ?? '' }}">
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="x_link">X</label>
                                        <input class="form-control" id="x_link" name="" type="text" readonly
                                               value="{{ $dataId->x_link ?? '' }}">
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="instagram_link">Instagram</label>
                                        <input class="form-control" id="instagram_link" name="" readonly type="text"
                                               value="{{ $dataId->instagram_link ?? '' }}">
                                    </div>

                                    <div class="form-group col-12">
                                        <label for="tiktok_link">Tiktok</label>
                                        <input class="form-control" id="tiktok_link" name="" readonly type="text"
                                               value="{{ $dataId->tiktok_link ?? '' }}">
                                    </div>


                                    <div class="form-group col-12">
                                        <label for="linkedin_link">linkedin</label>
                                        <input class="form-control" id="linkedin_link" name="" readonly type="text"
                                               value="{{ $dataId->linkedin_link ?? '' }}">
                                    </div>

                                    <div class="col-12 text-center">
                                        <button class="btn btn-info text-light">Duyệt hồ sơ</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-6">
                        <form action="{{route('backend.expert.reject', $dataId->id)}}" method="post">
                            @csrf
                            <div class="form-body">
                                <div class="row p-t-20">
                                    <div class="form-group col-12">
                                        <label for="bio" class="font-weight-bold">Lý do từ chối</label>
                                        <textarea class="form-control" id="bio" name="reason_for_refusal" rows="3">
                                            {{$dataId->reason_for_refusal ?? ''}}
                                        </textarea>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button class="btn btn-danger text-light">Từ chối</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
