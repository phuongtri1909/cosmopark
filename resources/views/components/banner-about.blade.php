<div class="banner-about position-relative overflow-hidden bg-banner-about">
    <div class="container position-relative z-2 py-5">
        <div class="row">
            <div class="col-lg-12 pt-5 text-center text-md-start">
                <h1 class="fw-bold color-primary-6 mt-4 mb-2 animate-on-scroll banner-title text-2xl-4">
                    {!! $generalIntroduction
                        ? $generalIntroduction->title
                        : 'COSMOPARK THE FUTURE. HERE' !!}
                </h1>
                <p class="lead fw-normal mb-4 animate-on-scroll banner-desc text-sm-1 color-text-secondary mt-4"
                    style="max-width: 700px;">
                    {{ $generalIntroduction ? $generalIntroduction->content : 'COSMOPARK is a project invested by Hoang Gia Vietnam Group, with overall planning as a green industrial and urban complex, complying with ecological standards, integrating sustainable production, logistics and environmentally friendly living spaces' }}
                </p>
            </div>
            <div class="col-lg-12">
                <div class="row justify-content-end">
                    <div class="col-0 col-lg-5">

                    </div>
                    <div class="col-12 col-lg-7">
                        <div class="row ">
                            @if ($introFeatures && $introFeatures->count() > 0)
                                @php
                                    $features = $introFeatures->take(5);
                                @endphp
                                
                                <!-- Hàng 1: 2 cards -->
                                <div class="row g-3 justify-content-end mt-0">
                                    @if(isset($features[0]))
                                        <div class="col-6 col-lg-4 animate-on-scroll stat-card">
                                            <div class="rounded-4 p-3 pb-4 text-center shadow stat-box">
                                                <p class="text-xs-1 text-white mb-1">
                                                    {{ $features[0]->name }}
                                                </p>
                                                <div class="display-5 fw-bold text-white stat-value" data-target="{{ $features[0]->value }}">
                                                    {{ $features[0]->value }}<small class="fs-6 fw-normal">{{ $features[0]->unit }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if(isset($features[1]))
                                        <div class="col-6 col-lg-4 animate-on-scroll stat-card">
                                            <div class="rounded-4 p-3 pb-4 text-center shadow stat-box">
                                                <p class="text-xs-1 text-white mb-1">
                                                    {{ $features[1]->name }}
                                                </p>
                                                <div class="display-5 fw-bold text-white stat-value" data-target="{{ $features[1]->value }}">
                                                    {{ $features[1]->value }}<small class="fs-6 fw-normal">{{ $features[1]->unit }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Hàng 2: 3 cards -->
                                <div class="row g-3 mt-0">
                                    @if(isset($features[2]))
                                        <div class="col-6 col-lg-4 animate-on-scroll stat-card">
                                            <div class="rounded-4 p-3 pb-4 text-center shadow stat-box">
                                                <p class="text-xs-1 text-white mb-1">
                                                    {{ $features[2]->name }}
                                                </p>
                                                <div class="display-5 fw-bold text-white stat-value" data-target="{{ $features[2]->value }}">
                                                    {{ $features[2]->value }}<small class="fs-6 fw-normal">{{ $features[2]->unit }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if(isset($features[3]))
                                        <div class="col-6 col-lg-4 animate-on-scroll stat-card">
                                            <div class="rounded-4 p-3 pb-4 text-center shadow stat-box">
                                                <p class="text-xs-1 text-white mb-1">
                                                    {{ $features[3]->name }}
                                                </p>
                                                <div class="display-5 fw-bold text-white stat-value" data-target="{{ $features[3]->value }}">
                                                    {{ $features[3]->value }}<small class="fs-6 fw-normal">{{ $features[3]->unit }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if(isset($features[4]))
                                        <div class="col-12 col-lg-4 animate-on-scroll stat-card">
                                            <div class="rounded-4 p-3 pb-4 text-center shadow stat-box">
                                                <p class="text-xs-1 text-white mb-1">
                                                    {{ $features[4]->name }}
                                                </p>
                                                <div class="display-5 fw-bold text-white stat-value" data-target="{{ $features[4]->value }}">
                                                    {{ $features[4]->value }}<small class="fs-6 fw-normal">{{ $features[4]->unit }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <!-- Fallback khi không có dữ liệu -->
                                <div class="row g-3 justify-content-end mt-0">
                                    <div class="col-6 col-lg-4 animate-on-scroll stat-card">
                                        <div class="rounded-4 p-3 pb-4 text-center shadow stat-box">
                                            <p class="text-xs-1 text-white mb-1">{{ __('Industrial Zone') }}</p>
                                            <div class="display-5 fw-bold text-white stat-value" data-target="322">
                                                322<small class="fs-6 fw-normal">ha</small></div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-4 animate-on-scroll stat-card">
                                        <div class="rounded-4 p-3 pb-4 text-center shadow stat-box">
                                            <p class="text-xs-1 text-white mb-1">{{ __('Social Housing Area') }}</p>
                                            <div class="display-5 fw-bold text-white stat-value" data-target="15">
                                                15<small class="fs-6 fw-normal">ha</small></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 mt-0">
                                    <div class="col-6 col-lg-4 animate-on-scroll stat-card">
                                        <div class="rounded-4 p-3 pb-4 text-center shadow stat-box">
                                            <p class="text-xs-1 text-white mb-1">{{ __('Energy Zone') }}</p>
                                            <div class="display-5 fw-bold text-white stat-value" data-target="500">
                                                500<small class="fs-6 fw-normal">ha</small></div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-4 animate-on-scroll stat-card">
                                        <div class="rounded-4 p-3 pb-4 text-center shadow stat-box">
                                            <p class="text-xs-1 text-white mb-1">{{ __('Golf Course, Resort & Villa') }}</p>
                                            <div class="display-5 fw-bold text-white stat-value" data-target="120">
                                                &gt;120<small class="fs-6 fw-normal">ha</small></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 animate-on-scroll stat-card">
                                        <div class="rounded-4 p-3 pb-4 text-center shadow stat-box">
                                            <p class="text-xs-1 text-white mb-1">{{ __('Smart City') }}</p>
                                            <div class="display-5 fw-bold text-white stat-value" data-target="1000">
                                                &gt;1000<small class="fs-6 fw-normal">ha</small></div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .banner-about {
            padding-bottom: 60px;
        }

        .bg-banner-about {
            background: url('/assets/images/dev/hero-slider.jpg') center/cover no-repeat;
            min-height: 700px;
        }

        .banner-about-overlay {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.92) 0%, rgba(255, 255, 255, 0.85) 100%);
            z-index: 1;
            pointer-events: none;
        }

        .stat-box {
            border: 1px solid rgba(255, 255, 255, 0.50);
            background: rgba(57, 75, 155, 0.50);
            backdrop-filter: blur(8px);
        }

        @media (max-width: 991.98px) {
            .bg-banner-about {
                min-height: 500px;
            }

            .banner-about {
                padding-bottom: 30px;
            }
        }

        .banner-about .banner-title,
        .banner-about .banner-desc {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.7s cubic-bezier(.39, .575, .565, 1);
        }

        .banner-about .banner-title.animated,
        .banner-about .banner-desc.animated {
            opacity: 1;
            transform: none;
        }

        .banner-about .stat-card {
            opacity: 0;
            transform: translateY(40px) scale(0.96);
            transition: all 0.7s cubic-bezier(.39, .575, .565, 1);
        }

        .banner-about .stat-card.animated {
            opacity: 1;
            transform: none;
        }

        .banner-about .stat-card:nth-child(1).animated {
            transition-delay: 0.1s;
        }

        .banner-about .stat-card:nth-child(2).animated {
            transition-delay: 0.2s;
        }

        .banner-about .stat-card:nth-child(3).animated {
            transition-delay: 0.3s;
        }

        .banner-about .stat-card:nth-child(4).animated {
            transition-delay: 0.4s;
        }

        .banner-about .stat-card:nth-child(5).animated {
            transition-delay: 0.5s;
        }
    </style>
@endpush

@push('scripts')
    <script></script>
@endpush
