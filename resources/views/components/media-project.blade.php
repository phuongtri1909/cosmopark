@props(['images' => []])

<div class="media-project pb-5">
    <div class="container d-flex justify-content-between animate-on-scroll">
        <h2 class="text-xl-3 color-primary-4 fw-bold animate-on-scroll">
            {{ __('MEDIA') }}
        </h2>
        <div class="category-media animate-on-scroll">
            <button class="color-primary-8 rounded-5 btn-category text-md px-3 py-2 me-2 animate-on-scroll">
                <img src="{{ asset('assets/images/svg/image.svg') }}" alt="">
                {{ __('Images') }}
            </button>

            <button class="color-primary-8 rounded-5 btn-category text-md px-3 py-2 me-2 animate-on-scroll">
                <img src="{{ asset('assets/images/svg/plan.svg') }}" alt="">
                {{ __('Plans') }}
            </button>

            <button class="color-primary-8 rounded-5 btn-category text-md px-3 py-2 me-2 animate-on-scroll">
                <img src="{{ asset('assets/images/svg/video.svg') }}" alt="">
                {{ __('Video') }}
            </button>

            <button class="color-primary-8 rounded-5 btn-category text-md px-3 py-2 animate-on-scroll">
                <img src="{{ asset('assets/images/svg/street.svg') }}" alt="">
                {{ __('Street View') }}
            </button>
        </div>
    </div>
    <div class="swiper mt-5 media-project-swiper">
        <div class="swiper-wrapper">
            @foreach($images as $img)
            <div class="swiper-slide">
                <div class="expo-container">
                    <img class="expo-image" src="{{ $img }}" />
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/slider.css') }}">
<style>
    .btn-category{
        border: 1px solid var(--primary-color-5);
        background: #FFF;
    }

    .btn-category:hover{
        background: var(--primary-color-4);
        color: #FFF !important;
    }

    .btn-category:hover img{
        filter: invert(1);
    }

</style>
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/js/index-slider.js') }}"></script>
    @endpush
@endonce
