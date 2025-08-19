@props([
    'reverseRow' => false,
    'reverseCol' => false,
    'reverseImage' => false,
    'title' => 'COSMOPARK',
    'subtitle' => 'ECO INDUSTRIAL ZONE',
    'desc' => 'Mô tả dự án ở đây...',
    'number' => '822',
    'unit' => 'ha',
    'image' => asset('assets/images/dev/intro-project.jpg'),
    'button' => false,
])

<div class="intro-project position-relative overflow-hidden">
    <div class="container position-relative z-2 py-5">
        <div class="row {{ $reverseRow ? 'flex-column-reverse flex-lg-row' : '' }}">

            {{-- Text --}}
            <div
                class="col-12 col-lg-8 text-center text-md-start {{ $reverseImage ? 'pt-3' : 'pt-5 mt-5' }} {{ $reverseCol ? 'order-lg-2' : 'order-lg-1' }}">
                <h1 class="fw-bold color-primary-4 mb-2 animate-on-scroll banner-title text-2xl-4">
                    {{ $title }}<br>
                    <span class="color-primary-4">{{ $subtitle }}</span>
                </h1>
                <p class="lead fw-normal animate-on-scroll banner-desc text-sm-1 color-text-secondary mt-4 mb-0">
                    {{ $desc }}
                </p>

                @if ($button)
                    <a href="https://royallongangolfandcountryclub.com/en/home/" target="_blank" type="submit"
                        class="btn submit-btn-custom animate-on-scroll rounded-pill p-2 mt-3 text-decoration-none d-inline-flex">
                        <span class="submit-text me-2 ps-3">{{ __('Book now') }}</span>
                        <div class="submit-icon submit-icon-custom">
                            <img class="arrow-icon-main" src="{{ asset('assets/images/svg/arrow-left.svg') }}" />
                        </div>
                    </a>
                @endif
            </div>

            {{-- Number --}}
            <div
                class="col-12 col-lg-4 d-flex justify-content-center align-items-lg-end ms-4 ms-lg-0 {{ $reverseCol ? 'order-lg-1' : 'order-lg-2' }}">
                <div class="d-flex justify-content-end align-items-center"
                    style="position: relative; min-height: 150px;">
                    <div style="position: relative; display: inline-block;">
                        <div class="circle-intro-project bg-primary-10 "></div>
                        <div class="line-2-intro-project">
                            <span class="text-6xl-6 fw-bold animate-on-scroll color-primary-4 line-2"
                                data-target="{{ $number }}">
                                {{ $number }}
                            </span>
                            <span class="fw-semibold text-xl-5 color-primary-4 ms-1">{{ $unit }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Image --}}
            <div class="col-12 mt-lg-5 {{ $reverseImage ? 'order-first pt-5' : 'order-last mt-3' }}">
                <img class="img-fluid rounded-4 animate-on-scroll" src="{{ $image }}"
                    alt="{{ $title }}">
            </div>
        </div>
    </div>
</div>


@push('styles')
    <style>
        .submit-btn-custom .submit-icon-custom {
            background-color: var(--primary-color-6) !important;
        }

        .circle-intro-project {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-position: center;
            position: absolute;
            left: -45px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
        }

        .line-2-intro-project {
            position: relative;
            z-index: 2;
            white-space: nowrap;
            text-align: left;
            display: inline-block;
            margin-left: 24px;
        }



        @media (max-width: 1200px) {
            .circle-intro-project {
                width: 100px;
                height: 100px;
            }

            .line-2-intro-project {
                margin-left: 16px;
            }
        }

        .intro-project {
            padding-bottom: 60px;
        }

        @media (max-width: 991.98px) {
            .intro-project {
                padding-bottom: 30px;
            }
        }

        .intro-project .img-fluid {
            opacity: 0;
            transform: translateY(40px) scale(0.96);
            transition: all 0.7s cubic-bezier(.39, .575, .565, 1);
        }

        .intro-project .img-fluid.animated {
            opacity: 1;
            transform: none;
        }

        .intro-project .banner-title,
        .intro-project .banner-desc {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.7s cubic-bezier(.39, .575, .565, 1);
        }

        .intro-project .banner-title.animated,
        .intro-project .banner-desc.animated {
            opacity: 1;
            transform: none;
        }
    </style>
@endpush

@push('scripts')
@endpush
