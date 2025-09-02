@props(['features' => null])

<div class="px-3 px-md-0 py-5">
    <div class="feature-5col-row">
        @if($features)
            @foreach($features as $feature)
                <div class="feature-5col">
                    <div class="feature-card animate-on-scroll"
                        style="background: linear-gradient(180deg, #FFF 0%, rgba(255,255,255,0.00) 100%), url('{{ Storage::url($feature['image']) }}') center/cover no-repeat;">
                        <div class="feature-card-body">
                            <h5 class="fw-bold color-primary-4 text-1lg">{!! $feature['title'] !!}</h5>
                            <p class="color-primary-8 text-md">{{ $feature['description'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Default features if no data provided -->
            <div class="feature-5col">
                <div class="feature-card animate-on-scroll"
                    style="background: linear-gradient(180deg, #FFF 0%, rgba(255,255,255,0.00) 100%), url('{{ asset('assets/images/dev/feature-1.png') }}') center/cover no-repeat;">
                    <div class="feature-card-body">
                        <h5 class="fw-bold color-primary-4 text-1lg">{!! __('STRATEGIC LOCATION') !!}</h5>
                        <p class="color-primary-8 text-md">{{ __('strategic_location_desc') }}</p>
                    </div>
                </div>
            </div>
            <div class="feature-5col">
                <div class="feature-card animate-on-scroll"
                    style="background: linear-gradient(180deg, #FFF 0%, rgba(255,255,255,0.00) 100%), url('{{ asset('assets/images/dev/feature-2.png') }}') center/cover no-repeat;">
                    <div class="feature-card-body">
                        <h5 class="fw-bold text-white text-1lg">{!! __('SYNCHRONIZED INFRASTRUCTURE') !!}</h5>
                        <p class="text-white text-md">{{ __('infrastructure_description') }}</p>
                    </div>
                </div>
            </div>
            <div class="feature-5col">
                <div class="feature-card animate-on-scroll"
                    style="background: linear-gradient(180deg, #FFF 0%, rgba(255,255,255,0.00) 100%), url('{{ asset('assets/images/dev/feature-3.png') }}') center/cover no-repeat;">
                    <div class="feature-card-body">
                        <h5 class="fw-bold color-primary-4 text-1lg">{!! __('GOVERNMENT INCENTIVES') !!}</h5>
                        <p class="color-primary-8 text-md">{{ __('incentives_description') }}</p>
                    </div>
                </div>
            </div>
            <div class="feature-5col">
                <div class="feature-card animate-on-scroll"
                    style="background: linear-gradient(180deg, #FFF 0%, rgba(255,255,255,0.00) 100%), url('{{ asset('assets/images/dev/feature-4.png') }}') center/cover no-repeat;">
                    <div class="feature-card-body">
                        <h5 class="fw-bold text-white text-1lg">{!! __('COMPLETE AMENITIES') !!}</h5>
                        <p class="text-white text-md">{{ __('amenities_description') }}</p>
                    </div>
                </div>
            </div>
            <div class="feature-5col">
                <div class="feature-card animate-on-scroll"
                    style="background: linear-gradient(180deg, #FFF 0%, rgba(255,255,255,0.00) 100%), url('{{ asset('assets/images/dev/feature-5.png') }}') center/cover no-repeat;">
                    <div class="feature-card-body">
                        <h5 class="fw-bold color-primary-4 text-1lg">{!! __('SUSTAINABLE ECOLOGICAL DEVELOPMENT') !!}</h5>
                        <p class="color-primary-8 text-md">{{ __('ecological_description') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@once
    @push('styles')
        <style>
            /* Desktop: 5 cột */
            @media (min-width: 1200px) {
                .feature-5col-row {
                    display: flex;
                    flex-wrap: wrap;
                    margin-left: 0;
                    margin-right: 0;
                }

                .feature-5col-row > .feature-5col {
                    width: 20%;
                    flex: 0 0 20%;
                    max-width: 20%;
                    padding-left: 0;
                    padding-right: 0;
                }
            }

            /* Tablet: 2-2-1 layout */
            @media (min-width: 768px) and (max-width: 1199.98px) {
                .feature-5col-row {
                    display: flex;
                    flex-wrap: wrap;
                }

                .feature-5col-row > .feature-5col {
                    width: 50%;
                    flex: 0 0 50%;
                    max-width: 50%;
                }

                .feature-5col-row > .feature-5col:nth-child(5) {
                    width: 100%;
                    flex: 0 0 100%;
                    max-width: 100%;
                }
            }

            /* Mobile: 1 cột */
            @media (max-width: 767.98px) {
                .feature-5col-row > .feature-5col {
                    width: 100%;
                    max-width: 100%;
                    flex: 0 0 100%;
                }
            }

            /* Feature card style & animation */
            .feature-card {
                border-radius: 0;
                box-shadow: none;
                overflow: hidden;
                height: 100%;
                display: flex;
                flex-direction: column;
                opacity: 0;
                transform: translateY(40px) scale(0.96);
                transition: all 0.7s cubic-bezier(.39, .575, .565, 1);
                min-height: 340px;
                position: relative;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
            }

            .feature-card.animated {
                opacity: 1;
                transform: none;
            }

            .feature-card-body {
                 position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                padding: 2rem 1.2rem 1.2rem 1.2rem;
                z-index: 2;
            }

            /* Gradient overlay for each card */
            .feature-5col-row>.feature-5col:nth-child(1) .feature-card-body {
                background: linear-gradient(180deg, #FFF 0%, rgba(255, 255, 255, 0.00) 100%);
            }

            .feature-5col-row>.feature-5col:nth-child(2) .feature-card-body {
                background: linear-gradient(180deg, #394B9B 0%, rgba(57, 75, 155, 0.00) 55.08%);
            }

            .feature-5col-row>.feature-5col:nth-child(3) .feature-card-body {
                background: linear-gradient(180deg, rgba(255, 255, 255, 0.20) 0%, rgba(255, 255, 255, 0.00) 67.03%);
            }

            .feature-5col-row>.feature-5col:nth-child(4) .feature-card-body {
                background: linear-gradient(180deg, #37814B 0%, rgba(55, 129, 75, 0.00) 54.38%);
            }

            .feature-5col-row>.feature-5col:nth-child(5) .feature-card-body {
                background: linear-gradient(180deg, #FFF 30.55%, rgba(255, 255, 255, 0.00) 66.09%);
            }

            @media (max-width: 991.98px) {
                .feature-card {
                    min-height: 260px;
                }

                .feature-card-body {
                    padding: 1.2rem 0.8rem 1rem 0.8rem;
                }
            }

            @media (min-width: 1200px) {
                .feature-card {
                    min-height: 640px;
                }
            }

            @media (max-width: 1199.98px) {
                .feature-card {
                    min-height: 600px;
                }
            }

            .feature-5col-row>.feature-5col:nth-child(1) .feature-card.animated {
                transition-delay: 0.05s;
            }

            .feature-5col-row>.feature-5col:nth-child(2) .feature-card.animated {
                transition-delay: 0.15s;
            }

            .feature-5col-row>.feature-5col:nth-child(3) .feature-card.animated {
                transition-delay: 0.25s;
            }

            .feature-5col-row>.feature-5col:nth-child(4) .feature-card.animated {
                transition-delay: 0.35s;
            }

            .feature-5col-row>.feature-5col:nth-child(5) .feature-card.animated {
                transition-delay: 0.45s;
            }
        </style>
    @endpush

    @push('scripts')
    @endpush
@endonce 