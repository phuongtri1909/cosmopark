<div class="intro-home feature-gradient-bg feature-rounded-top">
    <div class="col-12 p-100">
        <div class="container">
            <div class="align-items-start">
                <!-- Left Column - Form Header & Form -->
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="mb-4 text-center text-md-start">
                                    <x-badge-custom badge="Giới thiệu chung" />
                                    <h2 class="feature-title animate-on-scroll mb-0">COSMOPARK THE FUTURE. HERE</h2>
                                </div>
                            </div>
                            <div class="col-12 col-md-8">
                                <p class="text-center text-md-start text-sm-1 color-text-secondary">
                                    COSMOPARK là dự án được đầu tư bởi Tập đoàn Hoàng Gia Việt Nam, với quy hoạch
                                    tổng thể
                                    như một tổ hợp khu công nghiệp và đô thị xanh, tuân thủ các tiêu chuẩn sinh
                                    thái, tích
                                    hợp sản xuất bền vững, logistics và không gian sống thân thiện với môi trường
                                </p>

                                <div class="d-flex justify-content-center justify-content-md-start">
                                    <button type="submit"
                                        class="btn submit-btn-custom animate-on-scroll rounded-pill p-2">
                                        <span class="submit-text me-2 ps-3">Xem chi tiết</span>
                                        <div class="submit-icon submit-icon-custom">
                                            <img class="arrow-icon-main"
                                                src="{{ asset('assets/images/svg/arrow-left.svg') }}" />
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-4 text-center">
                        <div class="row gy-5 justify-content-center intro-feature-row">
                            <div
                                class="col-6 d-flex flex-column align-items-center intro-feature-col animate-on-scroll">
                                <span class="line-1 text-sm-1 color-text-secondary">Khu công nghiệp</span>
                                <span class="line-2 text-2xl-4 fw-bold animate-on-scroll" data-target="322">322 <small
                                        class="line-3 fw-semibold text-md-2">ha</small></span>
                            </div>
                            <div
                                class="col-6 d-flex flex-column align-items-center intro-feature-col animate-on-scroll">
                                <span class="line-1 text-sm-1 color-text-secondary">Khu ở xã hội</span>
                                <span class="line-2 text-2xl-4 fw-bold animate-on-scroll" data-target="15">15 <small
                                        class="line-3 fw-semibold text-md-2">ha</small></span>
                            </div>
                            <div
                                class="col-6 d-flex flex-column align-items-center intro-feature-col animate-on-scroll">
                                <span class="line-1 text-sm-1 color-text-secondary">Khu năng lượng mặt trời</span>
                                <span class="line-2 text-2xl-4 fw-bold animate-on-scroll" data-target="500">500 <small
                                        class="line-3 fw-semibold text-md-2">ha</small></span>
                            </div>
                            <div
                                class="col-6 d-flex flex-column align-items-center intro-feature-col animate-on-scroll">
                                <span class="line-1 text-sm-1 color-text-secondary">Sân Golf, Resort & Villa</span>
                                <span class="line-2 text-2xl-4 fw-bold animate-on-scroll" data-target="120">&gt;120 <small
                                        class="line-3 fw-semibold text-md-2">ha</small></span>
                            </div>
                            <div
                                class="col-6 d-flex flex-column align-items-center intro-feature-col animate-on-scroll">
                                <span class="line-1 text-sm-1 color-text-secondary">Khu đô thị thông minh</span>
                                <span class="line-2 text-2xl-4 fw-bold animate-on-scroll" data-target="1000">&gt;1000 <small
                                        class="line-3 fw-semibold text-md-2">ha</small></span>
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
        /* Feature Form Utility Classes */
        .feature-gradient-bg {
            background-color: white;
        }

        .feature-rounded-top {
            position: relative;
            border-radius: 50px 50px 0 0;
            z-index: 1;
        }

        .feature-title {
            color: var(--color-primary);
            font-size: var(--font-size-2xl);
            font-weight: var(--font-weight-bold);
            letter-spacing: -0.4px;
            line-height: var(--line-height);
        }



        /* Animation: Fade in up */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        /* Animation: Scale in */
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Animation: Slide in from left */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-60px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Example usage for your elements */
        .feature-title {
            animation: fadeInUp 1s cubic-bezier(.39, .575, .565, 1) both;
        }

        .feature-badge {
            animation: scaleIn 0.8s 0.2s cubic-bezier(.39, .575, .565, 1) both;
        }

        .submit-btn-custom .submit-icon-custom {
            background-color: var(--primary-color-6) !important;
        }

        .line-2 {
            color: var(--primary-color-6);
            letter-spacing: -2px;
        }

        @media (min-width:768px) {
            .feature-title {
                font-size: var(--font-size-3xl);
            }



            .feature-rounded-top {
                border-radius: 80px 80px 0 0;
            }

        }

        @media (min-width: 992px) {
            .intro-feature-row {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 0;
            }

            .intro-feature-row>.intro-feature-col {
                flex: 0 0 20%;
                max-width: 20%;
                padding-left: 0;
                padding-right: 0;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        /* Animation: Scale in */
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Animation: Slide in from left */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-60px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Animation: Pulse */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(0, 123, 255, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(0, 123, 255, 0);
            }
        }

        /* Animation: Bounce */
        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }

            50% {
                opacity: 1;
                transform: scale(1.05);
            }

            70% {
                transform: scale(0.9);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Apply animations */
        .feature-title {
            animation: fadeInUp 1s cubic-bezier(.39, .575, .565, 1) both;
        }

        .feature-badge {
            animation: scaleIn 0.8s 0.2s cubic-bezier(.39, .575, .565, 1) both;
        }

        .intro-home .submit-btn-custom {
            animation: bounceIn 1s 0.5s cubic-bezier(.39, .575, .565, 1) both;
        }

        .intro-feature-col {
            opacity: 0;
            animation: fadeInUp 1s cubic-bezier(.39, .575, .565, 1) both;
        }

        .intro-feature-col:nth-child(1) {
            animation-delay: 0.2s;
        }

        .intro-feature-col:nth-child(2) {
            animation-delay: 0.4s;
        }

        .intro-feature-col:nth-child(3) {
            animation-delay: 0.6s;
        }

        .intro-feature-col:nth-child(4) {
            animation-delay: 0.8s;
        }

        .intro-feature-col:nth-child(5) {
            animation-delay: 1s;
        }

        .intro-home .submit-btn-custom:hover {
            animation: pulse 1s;
        }

        .intro-home .feature-title,
        .intro-home .submit-btn-custom,
        .intro-feature-col {
            opacity: 0;
        }

        .feature-title.animated {
            animation: fadeInUp 1s cubic-bezier(.39, .575, .565, 1) both;
            opacity: 1;
        }

        .intro-home .submit-btn-custom.animated {
            animation: bounceIn 1s 0.5s cubic-bezier(.39, .575, .565, 1) both;
            opacity: 1;
        }

        .intro-feature-col.animated {
            animation: fadeInUp 1s cubic-bezier(.39, .575, .565, 1) both;
            opacity: 1;
        }

        .intro-feature-col.animated:nth-child(1) {
            animation-delay: 0.2s;
        }

        .intro-feature-col.animated:nth-child(2) {
            animation-delay: 0.4s;
        }

        .intro-feature-col.animated:nth-child(3) {
            animation-delay: 0.6s;
        }

        .intro-feature-col.animated:nth-child(4) {
            animation-delay: 0.8s;
        }

        .intro-feature-col.animated:nth-child(5) {
            animation-delay: 1s;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top < window.innerHeight - 60 && // 60px để animation sớm hơn chút
                rect.bottom > 0
            );
        }

        function animateOnScroll() {
            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                if (isInViewport(el)) {
                    el.classList.add('animated');
                }
            });
        }

        window.addEventListener('scroll', animateOnScroll);
        window.addEventListener('DOMContentLoaded', animateOnScroll);
    </script>
@endpush
