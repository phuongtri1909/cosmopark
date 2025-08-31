<div class="vision-mission feature-gradient-bg feature-rounded-top">
    <div class="p-100">
        <div class="row g-4">
            <div class="col-12 col-md-6">
                <div class="vision-card animate-on-scroll h-100">
                    <div>
                        <div class="vision-icon mb-3 rounded-pill bg-white p-2 d-inline-block">
                            <img src="{{ asset('assets/images/svg/vision.svg') }}" alt="Tầm nhìn" width="48"
                                height="48">
                        </div>

                    </div>
                    <h3 class="vision-title text-white fw-bold text-xl-2 mt-0 mt-md-5">{{ __('Vision') }}</h3>
                    <p class="vision-desc text-white mb-0 text-sm-2 color-primary-10">
                        {{ __('vision_description') }}
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="vision-card animate-on-scroll h-100">
                    <div>
                        <div class="vision-icon mb-3 rounded-pill bg-white p-2 d-inline-block">
                            <img src="{{ asset('assets/images/svg/mission.svg') }}" alt="Sứ mệnh" width="48"
                                height="48">
                        </div>

                    </div>
                    <h3 class="vision-title mt-0 mt-md-5 text-white fw-bold text-xl-2">{{ __('Mission') }}</h3>
                    <p class="vision-desc text-white mb-0 text-sm-2 color-primary-10">
                        {{ __('mission_description') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        /* Feature Form Utility Classes */
        .feature-gradient-bg {
            background-color: white;
        }

        .feature-rounded-top {
            position: relative;
            border-radius: 50px 50px 0 0;
            z-index: 1;
        }

        .vision-mission {
            margin-top: -50px;
        }

        .vision-card {
            background: linear-gradient(0deg, rgba(57, 75, 155, 0.60) 0%, rgba(57, 75, 155, 0.60) 100%), url('/assets/images/dev/image-footer.jpg') lightgray 50% / cover no-repeat;
            border-radius: 28px;
            padding: 2.5rem 2rem 2rem 2rem;
            min-height: 340px;
            box-shadow: 0 1px 2px 0 rgba(16, 24, 40, 0.05);
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(40px) scale(0.96);
            transition: all 0.7s cubic-bezier(.39, .575, .565, 1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .vision-card.animated {
            opacity: 1;
            transform: none;
        }

        .vision-card .vision-icon img {
            filter: drop-shadow(0 2px 8px rgba(44, 62, 120, 0.12));
        }

        .vision-title {
            letter-spacing: -0.5px;
        }

        @media (max-width: 991.98px) {
            .vision-mission {
                border-radius: 32px 32px 0 0;
            }

            .vision-card {
                padding: 1.5rem 1rem 1.5rem 1rem;
                min-height: 260px;
            }

            .vision-card .vision-icon img {
                width: 25px !important;
                height: 20px !important;
            }
        }

        .vision-card:nth-child(1).animated {
            transition-delay: 0.1s;
        }

        .vision-card:nth-child(2).animated {
            transition-delay: 0.2s;
        }
    </style>
@endpush

@push('scripts')
@endpush
