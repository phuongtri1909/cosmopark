@php
    use App\Models\BannerHome;
    $bannerHomes = BannerHome::active()->ordered()->get();
@endphp

<div class="hero-slider animate__animated animate__fadeIn">
    @if($bannerHomes->count() > 0)
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                @foreach($bannerHomes as $bannerHome)
                    <div class="swiper-slide">
                        <img src="{{ $bannerHome->image_url }}" alt="Banner trang chủ {{ $loop->iteration }}" />
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- Fallback khi không có banner -->
        <div class="hero-slider-fallback">
            <img src="{{ asset('assets/images/dev/hero-slider.jpg') }}" alt="Hero Default" />
        </div>
    @endif
</div>

@push('styles')
    <style>
        /* Animation cho hero-slider */
        .hero-slider {
            animation: heroFadeIn 1.2s cubic-bezier(.39, .575, .565, 1) both;
        }

        @keyframes heroFadeIn {
            from {
                opacity: 0;
                transform: scale(1.04);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .hero-slider .swiper-slide img {
            opacity: 0;
            animation: heroImgZoomIn 1.2s cubic-bezier(.39, .575, .565, 1) both;
            animation-delay: 0.2s;
        }

        @keyframes heroImgZoomIn {
            from {
                opacity: 0;
                transform: scale(1.08);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .hero-slider .hero-swiper,
        .hero-slider .swiper,
        .hero-slider .swiper-wrapper,
        .hero-slider .swiper-slide {
            height: 900px !important;
            min-height: 900px;
            width: 100%;
        }

        .hero-slider {
            position: relative;
            max-width: 100vw;
            overflow: hidden;
            margin-bottom: -115px;
            z-index: 0;
        }

        .hero-slider .swiper-slide {
            display: flex;
            align-items: stretch;
            justify-content: stretch;
            overflow: hidden;
        }

        .hero-slider .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
            background: #eaeaea;
        }

        /* Fallback styles */
        .hero-slider-fallback {
            height: 900px;
            width: 100%;
            overflow: hidden;
        }

        .hero-slider-fallback img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        @media (max-width: 768px) {

            .hero-slider .hero-swiper,
            .hero-slider .swiper,
            .hero-slider .swiper-wrapper,
            .hero-slider .swiper-slide {
                height: 50vh !important;
                min-height: 400px;
            }

            .hero-slider .swiper-slide img {
                height: 50vh;
                min-height: 400px;
            }

            .hero-slider {
                margin-bottom: -85px;
            }

            .hero-slider-fallback {
                height: 50vh;
                min-height: 400px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if($bannerHomes->count() > 1)
                new Swiper('.hero-swiper', {
                    loop: true,
                    autoplay: {
                        delay: 3500,
                        disableOnInteraction: false,
                    },
                    allowTouchMove: false,
                });
            @endif
        });
    </script>
@endpush
