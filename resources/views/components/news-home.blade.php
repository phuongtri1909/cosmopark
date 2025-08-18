<div class="news-home animate-on-scroll">
    <div class="col-12 p-100">
        <div class="container">
            <div class="align-items-start">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="text-center text-md-start">
                                    <x-badge-custom badge="Tin tức" />
                                    <h2 class="news-home-title mb-0 animate-on-scroll">TIN TỨC MỚI NHẤT</h2>
                                </div>
                            </div>
                            <div class="col-12 col-md-8 d-flex align-items-end justify-content-end">
                                <!-- Nút desktop -->
                                <a href="{{ route('news.index') }}" type="submit" class="btn submit-btn-custom rounded-pill p-2 mb-3 d-none d-md-flex animate-on-scroll text-decoration-none">
                                    <span class="submit-text me-2 ps-3">Xem chi tiết</span>
                                    <div class="submit-icon submit-icon-custom">
                                        <img class="arrow-icon-main"
                                            src="{{ asset('assets/images/svg/arrow-left.svg') }}" />
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-4 card-news-slider">
                        <!-- Swiper for mobile, grid for desktop -->
                        <div class="d-block d-md-none">
                            <div class="swiper news-swiper animate-on-scroll">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <x-card-news />
                                    </div>
                                    <div class="swiper-slide">
                                        <x-card-news />
                                    </div>
                                    <div class="swiper-slide">
                                        <x-card-news />
                                    </div>
                                </div>
                            </div>
                            <!-- Nút mobile -->
                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn submit-btn-custom rounded-pill p-2 d-flex d-md-none animate-on-scroll">
                                    <span class="submit-text me-2 ps-3">Xem chi tiết</span>
                                    <div class="submit-icon submit-icon-custom">
                                        <img class="arrow-icon-main"
                                            src="{{ asset('assets/images/svg/arrow-left.svg') }}" />
                                    </div>
                                </button>
                            </div>
                        </div>
                        <div class="d-none d-md-block">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4 animate-on-scroll">
                                    <x-card-news />
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 animate-on-scroll">
                                    <x-card-news />
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 animate-on-scroll">
                                    <x-card-news />
                                </div>
                            </div>
                        </div>
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

        .news-swiper .swiper-slide {
            display: flex;
            justify-content: center;
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
                new Swiper('.news-swiper', {
                    slidesPerView: 1,
                    spaceBetween: 16,

                });
            }
        });
    </script>
@endpush
