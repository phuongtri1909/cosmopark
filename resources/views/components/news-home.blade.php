@props(['latestNews' => []])

<div class="news-home animate-on-scroll">
    <div class="col-12 p-100">
        <div class="container">
            <div class="align-items-start">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="text-center text-md-start">
                                    <x-badge-custom badge="{{ __('News-1') }}" />
                                    <h2 class="news-home-title mb-0 animate-on-scroll">{{ __('Latest News') }}</h2>
                                </div>
                            </div>
                            <div class="col-12 col-md-8 d-flex align-items-end justify-content-end">
                                <!-- Nút desktop -->
                                <a href="{{ route('news.index') }}" type="submit" class="btn submit-btn-custom rounded-pill p-2 mb-3 d-none d-md-flex animate-on-scroll text-decoration-none">
                                    <span class="submit-text me-2 ps-3">{{ __('View details') }}</span>
                                    <div class="submit-icon submit-icon-custom">
                                        <img class="arrow-icon-main"
                                            src="{{ asset('assets/images/svg/arrow-left.svg') }}" />
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-4 card-news-slider">
                        @if($latestNews->count() > 0)
                            <!-- Swiper for mobile, grid for desktop -->
                            <div class="d-block d-md-none">
                                <div class="swiper news-swiper animate-on-scroll">
                                    <div class="swiper-wrapper">
                                        @foreach($latestNews as $news)
                                            <div class="swiper-slide">
                                                <x-card-news :news="$news" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- Nút mobile -->
                                <div class="d-flex justify-content-center mt-3">
                                     <a href="{{ route('news.index') }}" type="submit" class="btn submit-btn-custom rounded-pill p-2 mb-3 d-flex d-md-none animate-on-scroll text-decoration-none">
                                        <span class="submit-text me-2 ps-3">{{ __('View details') }}</span>
                                        <div class="submit-icon submit-icon-custom">
                                            <img class="arrow-icon-main"
                                                src="{{ asset('assets/images/svg/arrow-left.svg') }}" />
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="d-none d-md-block">
                                <div class="row">
                                    @foreach($latestNews as $news)
                                        <div class="col-12 col-md-6 col-lg-4 animate-on-scroll">
                                            <x-card-news :news="$news" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <!-- Hiển thị khi không có tin tức -->
                            <div class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-newspaper fa-3x mb-3"></i>
                                    <h5>{{ __('No news available') }}</h5>
                                    <p>{{ __('Come back later for latest news') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .news-home-title {
            color: var(--color-primary);
            font-size: var(--font-size-2xl);
            font-weight: var(--font-weight-bold);
            letter-spacing: -0.4px;
            line-height: var(--line-height);
        }

        /* Mobile Slider Styles */
        .news-swiper {
            padding-left: 16px;
            padding-right: 16px;
        }

        .news-swiper .swiper-slide {
            display: flex;
            justify-content: center;
            width: 85% !important;
            margin-right: 16px;
        }

        .news-swiper .swiper-slide:last-child {
            margin-right: 0;
        }

        /* Peek effect - show 1/4 of next slide */
        .news-swiper .swiper-wrapper {
            padding-right: 25%;
        }

        @keyframes fadeInNewsSection {
            from { opacity: 0; transform: translateY(40px);}
            to { opacity: 1; transform: none;}
        }
        @keyframes fadeInNewsTitle {
            from { opacity: 0; transform: translateY(-30px);}
            to { opacity: 1; transform: none;}
        }
        @keyframes fadeInNewsBtn {
            from { opacity: 0; transform: scale(0.8);}
            to { opacity: 1; transform: scale(1);}
        }
        @keyframes fadeInCardNews {
            from { opacity: 0; transform: translateY(40px) scale(0.96);}
            to { opacity: 1; transform: none;}
        }

        .animate-on-scroll { opacity: 0; }
        .animate-on-scroll.animated { opacity: 1; }

        .news-home.animate-on-scroll.animated {
            animation: fadeInNewsSection 0.8s both;
        }
        .news-home-title.animate-on-scroll.animated {
            animation: fadeInNewsTitle 0.8s 0.2s both;
        }
        .submit-btn-custom.animate-on-scroll.animated {
            animation: fadeInNewsBtn 0.7s 0.4s both;
        }
        .news-swiper.animate-on-scroll.animated {
            animation: fadeInNewsSection 0.8s 0.3s both;
        }
        .col-lg-4.animate-on-scroll.animated,
        .col-md-6.animate-on-scroll.animated {
            animation: fadeInCardNews 0.7s both;
        }
        .col-lg-4.animate-on-scroll.animated:nth-child(1) { animation-delay: 0.2s;}
        .col-lg-4.animate-on-scroll.animated:nth-child(2) { animation-delay: 0.4s;}
        .col-lg-4.animate-on-scroll.animated:nth-child(3) { animation-delay: 0.6s;}

        @media (min-width:768px) {
            .news-home-title {
                font-size: var(--font-size-3xl);
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth < 768) {
                const newsSwiper = new Swiper('.news-swiper', {
                    slidesPerView: 'auto',
                    spaceBetween: 16,
                    centeredSlides: false,
                    loop: true,
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                    },
                    speed: 800,
                    effect: 'slide',
                    grabCursor: true,
                    touchRatio: 1,
                    touchAngle: 45,
                    resistance: true,
                    resistanceRatio: 0.85,
                });
            }
        });
    </script>
@endpush
