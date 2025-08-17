<div class="vision-mission feature-gradient-bg feature-rounded-top">
    <div class="p-100">
        <div class="row g-4">
            <div class="col-12 col-md-6">
                <div class="vision-card animate-on-scroll h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="vision-icon mb-3 rounded-pill bg-white p-2 d-inline-block">
                            <img src="{{ asset('assets/images/svg/vision.svg') }}" alt="Tầm nhìn" width="48"
                                height="48">
                        </div>
                        <h3 class="vision-title mb-3 text-white fw-bold text-xl-2">TẦM NHÌN</h3>
                        <p class="vision-desc text-white mb-0 text-sm-2 color-primary-10">
                            Trở thành biểu tượng mới của khu công nghiệp – đô thị xanh tại Việt Nam, nơi kết nối hài hòa
                            giữa sản xuất bền vững, phát triển đô thị hiện đại và môi trường sống thân thiện, hướng đến
                            tiêu chuẩn quốc tế về phát triển bền vững.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="vision-card animate-on-scroll h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="vision-icon mb-3 rounded-pill bg-white p-2 d-inline-block">
                            <img src="{{ asset('assets/images/svg/mission.svg') }}" alt="Sứ mệnh" width="48"
                                height="48">
                        </div>
                        <h3 class="vision-title mb-3 text-white fw-bold text-xl-2">SỨ MỆNH</h3>
                        <p class="vision-desc text-white mb-0 text-sm-2 color-primary-10">
                            COSMOPARK cam kết xây dựng một hệ sinh thái công nghiệp – đô thị bền vững, tích hợp sản xuất
                            xanh, logistics hiện đại và không gian sống thân thiện với môi trường. Dự án hướng đến môi
                            trường đầu tư minh bạch, hiệu quả và đóng góp vào sự phát triển của Tây Ninh và vùng kinh tế
                            xuyên biên giới.
                        </p>
                    </div>
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
            justify-content: flex-start;
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
