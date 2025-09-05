<div class="zone-slider d-flex flex-column align-items-center position-relative p-100 animate-on-scroll">
    <div class="container">
        <img class="zone-bg-vector animate-on-scroll" src="{{ asset('assets/images/svg/vector-3.svg') }}" />
        <img class="zone-bg-img animate-on-scroll" src="{{ asset('assets/images/svg/vector-3.svg') }}" />

        <div class="d-block d-md-flex justify-content-between align-items-end text-center text-md-start">
            <div>
                <div class="zone-badge animate-on-scroll">
                    <div class="badge-custom-zone badge rounded-pill mb-3 p-2 p-md-3 animate-on-scroll">
                        {{ __('Sub Zones') }}
                    </div>
                </div>
                <p class="zone-title text-xl-2 fw-bold text-white mb-0 animate-on-scroll">{!! __('COSMOPARK THE FUTURE. HERE') !!}
                </p>
            </div>

            <div class="zone-navigation d-flex justify-content-center align-items-center gap-2 mb-3 d-none d-md-flex animate-on-scroll">
                <button class="btn-prev d-flex align-items-center justify-content-center animate-on-scroll">
                    <img src="{{ asset('assets/images/svg/caret-left.svg') }}" alt="{{ __('Previous') }}">
                </button>
                <button class="btn-next d-flex align-items-center justify-content-center animate-on-scroll">
                    <img src="{{ asset('assets/images/svg/caret-right.svg') }}" alt="{{ __('Next') }}">
                </button>
            </div>

        </div>

        <div class="view-zone-slider mt-5">
            <div class="swiper zone-swiper">
                <div class="swiper-wrapper">

                    @foreach ($projects as $project)
                        <div class="swiper-slide">
                            <x-card-zone :project="$project" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        @keyframes fadeInZone {
            from { opacity: 0; transform: translateY(40px);}
            to { opacity: 1; transform: none;}
        }
        @keyframes scaleInBadgeZone {
            from { opacity: 0; transform: scale(0.8);}
            to { opacity: 1; transform: scale(1);}
        }
        @keyframes fadeInNavZone {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: none;}
        }
        .badge-custom-zone {
            border: 1px solid var(--primary-color-5);
            background-color: transparent;
            color: var(--primary-color-7);
            font-size: var(--font-size-sm);
            font-weight: var(--font-weight-normal);
        }

        .zone-slider {
            background: var(--primary-color);
        }

        .zone-slider .zone-bg-vector,
        .zone-slider .zone-bg-img {
            position: absolute;
            left: 35%;
            transform: translateX(-50%);
            z-index: 1;
            height: auto;
        }

        .zone-slider .zone-bg-vector {
            top: 19px;
            width: 180px;
            max-width: 40vw;
        }

        .zone-slider .zone-bg-img {
            top: 320px;
            width: 220px;
            max-width: 60vw;
        }

        @media (min-width: 992px) {
            .zone-slider .zone-bg-vector {
                left: auto;
                right: 445px;
                transform: none;
                top: 19px;
                width: 320px;
                max-width: 100%;
            }

            .zone-slider .zone-bg-img {
                left: auto;
                right: 445px;
                transform: none;
                top: 481px;
                width: 420px;
                max-width: 100%;
            }
        }

        @media (min-width: 1200px) {
            .zone-slider .zone-bg-vector {
                width: 420px;
            }

            .zone-slider .zone-bg-img {
                width: 520px;
            }
        }

        .btn-prev,
        .btn-next {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: transparent;
            border: 1px solid white;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-prev img,
        .btn-next img {
            width: 24px;
            height: 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-prev:hover img {
            transform: translateX(-4px);
            filter: brightness(0) invert(1);
        }

        .btn-next:hover img {
            transform: translateX(4px);
            filter: brightness(0) invert(1);
        }

        .btn-prev:hover,
        .btn-next:hover {
            border-color: var(--color-success);
        }

        .btn-prev:active img {
            transform: translateX(-2px);
        }

        .btn-next:active img {
            transform: translateX(2px);
        }

        .view-zone-slider {
            position: relative;
            padding: 0;
            overflow: visible;
        }

        .zone-swiper .swiper-slide {
            width: 320px;
            height: auto;
            display: flex;
        }

        .zone-swiper .swiper-slide .card-zone {
            width: 100%;
            height: 100%;
        }

        @media (min-width: 768px) {
            .view-zone-slider {
                padding: 0;
            }
        }

        .zone-slider.animate-on-scroll { opacity: 0; }
        .zone-slider.animate-on-scroll.animated { animation: fadeInZone 0.7s both; opacity: 1; }
        .zone-badge.animate-on-scroll.animated .badge-custom-zone { animation: scaleInBadgeZone 0.7s 0.2s both; }
        .zone-title.animate-on-scroll.animated { animation: fadeInZone 0.7s 0.3s both; }
        .zone-navigation.animate-on-scroll.animated { animation: fadeInNavZone 0.7s 0.5s both; }
        .btn-prev.animate-on-scroll.animated,
        .btn-next.animate-on-scroll.animated { animation: popBtn 0.5s 0.7s both; }
    </style>
@endpush
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.zone-swiper', {
                slidesPerView: 'auto',
                spaceBetween: 20,
                loop: true,
                slidesOffsetAfter: 180,
                navigation: {
                    nextEl: '.btn-next',
                    prevEl: '.btn-prev',
                },
                breakpoints: {
                    768: {
                        slidesPerView: 1.5,
                        slidesOffsetAfter: 240,
                    },
                    992: {
                        slidesPerView: 2.5,
                        slidesOffsetAfter: 260,
                    },
                    1200: {
                        slidesPerView: 3.2,
                        slidesOffsetAfter: 280,
                    }
                }
            });
        });
    </script>
@endpush
