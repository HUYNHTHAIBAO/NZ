@if(isset($questionExpert) && $questionExpert->count() >= 1)
    <div class="my-4 col-12">
        <p class="title d-flex align-items-center justify-content-center text-black"
           style="font-size: 24px; font-weight: 600">
            <img class="me-2"
                 src="https://cdn-icons-png.flaticon.com/128/318/318275.png" width="25px"
                 height="25px"
                 alt=""> Câu hỏi & Trả lời
        </p>
        <div class="">
            <div class="accordion" id="accordionExample">
                @forelse($questionExpert as $key => $item)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $key }}">
                            <button class="accordion-button collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}"
                                    aria-expanded="false" aria-controls="collapse{{ $key }}">
                                {{ $item->title ?? '' }}
                            </button>
                        </h2>
                        <div id="collapse{{ $key }}" class="accordion-collapse collapse"
                             aria-labelledby="heading{{ $key }}" data-bs-parent="#accordionExample"
                             style="">
                            <div class="accordion-body">
                                <ul class="list-wrap">
                                    <li class="course-item open-item">
                                        {{ $item->desc ?? '' }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @empty

                @endforelse

            </div>
        </div>
    </div>
@else

@endif
