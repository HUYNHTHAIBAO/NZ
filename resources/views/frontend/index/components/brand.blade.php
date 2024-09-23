    <style>
        /* Marquee styles */
    .marquee {
        --gap: 1rem;
        position: relative;
        display: flex;
        overflow: hidden;
        user-select: none;
        gap: var(--gap);
    }
    .marquee__content {
        flex-shrink: 0;
        display: flex;
        justify-content: space-around;
        gap: var(--gap);
        min-width: 100%;
    }
    @keyframes scroll {
        from {
            transform: translateX(0);
        }
        to {
            transform: translateX(calc(-100% - var(--gap)));
        }
    }
    /* Pause animation when reduced-motion is set */
    @media (prefers-reduced-motion: reduce) {
        .marquee__content {
            animation-play-state: paused !important;
        }
    }
    /* Enable animation */
    .enable-animation .marquee__content {
        animation: scroll 20s linear infinite;
    }
    /* Reverse animation */
    .marquee--reverse .marquee__content {
        animation-direction: reverse;
    }
    /* Pause on hover */
    .marquee--hover-pause:hover .marquee__content {
        animation-play-state: paused;
    }
    /* Attempt to size parent based on content. Keep in mind that the parent width is equal to both content containers that stretch to fill the parent. */
    .marquee--fit-content {
        max-width: fit-content;
    }
    /* A fit-content sizing fix: Absolute position the duplicate container. This will set the size of the parent wrapper to a single child container. Shout out to Olavi's article that had this solution 👏 @link: https://olavihaapala.fi/2021/02/23/modern-marquee.html  */
    .marquee--pos-absolute .marquee__content:last-child {
        position: absolute;
        top: 0;
        left: 0;
    }
    /* Enable position absolute animation on the duplicate content (last-child) */
    .enable-animation .marquee--pos-absolute .marquee__content:last-child {
        animation-name: scroll-abs;
    }
    @keyframes scroll-abs {
        from {
            transform: translateX(calc(100% + var(--gap)));
        }
        to {
            transform: translateX(0);
        }
    }
    /* Other page demo styles */
    .marquee__content > * {
        flex: 0 0 auto;
        color: white;
        margin: 2px;
        /*padding: 1rem 2rem;*/
        border-radius: 0.25rem;
        text-align: center;
    }

</style>
@if(isset($partner) && $partner->count() >= 1)
    <section class="testimonial__area-two testimonial__bg container-fluid" style="margin-top: 80px">
        <div class="">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-7">
                    <div class="section__title text-center mb-20">
                        <h2 class="categories_title">
                            <span class="title_rgba">ĐỐI TÁC</span> của NeztWork
                        </h2>
                    </div>
                </div>
            </div>

            <div class="brand-area-three">
                <div class="">
                    <div class="brand_slider">
                        @forelse($partner as $key => $item)
                            <div class="brand_slider_item d-flex align-items-center justify-content-center">
                                <div class="d-flex">
                                    <div class="brand__item-two" style="width: 160px; height: 160px;">
                                        <img src="{{$item->file_src}}" alt="img"  style="width: 100%; height: 100%; object-fit: contain">
                                    </div>
                                </div>
                            </div>
                        @empty

                        @endforelse
                    </div>
                </div>
            </div>

{{--            <div class="container-fluid">--}}
{{--                <section class="enable-animation">--}}
{{--                    <div class="marquee">--}}
{{--                        <ul class="marquee__content m-0">--}}
{{--                            @forelse($partner as $key => $item)--}}
{{--                            <li>--}}
{{--                                 <img src="{{$item->file_src}}" alt="img"  style="width: 100%; height: 100%; object-fit: contain">--}}
{{--                            </li>--}}
{{--                            @empty--}}

{{--                            @endforelse--}}

{{--                        </ul>--}}
{{--                        <ul aria-hidden="true" class="marquee__content m-0">--}}
{{--                            @forelse($partner as $key => $item)--}}
{{--                                <li>--}}
{{--                                      <img src="{{$item->file_src}}" alt="img"  style="width: 100%; height: 100%; object-fit: contain">--}}
{{--                                </li>--}}
{{--                            @empty--}}

{{--                            @endforelse--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </section>--}}
{{--                <section class="enable-animation">--}}
{{--                    <div class="marquee marquee--reverse">--}}
{{--                        <ul class="marquee__content m-0">--}}
{{--                            @forelse($partner as $key => $item)--}}
{{--                                <li>--}}
{{--                                    <img src="{{$item->file_src}}" alt="img"  style="width: 100%; height: 100%; object-fit: contain">--}}
{{--                                </li>--}}
{{--                            @empty--}}

{{--                            @endforelse--}}
{{--                        </ul>--}}
{{--                        <ul aria-hidden="true" class="marquee__content m-0">--}}
{{--                            @forelse($partner as $key => $item)--}}
{{--                                <li>--}}
{{--                                    <img src="{{$item->file_src}}" alt="img"  style="width: 100%; height: 100%; object-fit: contain">--}}
{{--                                </li>--}}
{{--                            @empty--}}

{{--                            @endforelse--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--            </div>--}}
        </div>
    </section>
@else

@endif
