@props(['align' => 'text-center text-md-start'])

<div class="intro-image-wrapper">
    <img class="img-intro animate-on-scroll" src="{{ asset('assets/images/dev/image-6.jpg') }}" alt="">
    <div class="content-intro-image {{ $align }}">
        <h2 class="text-xl-3 color-primary-4 fw-bold animate-on-scroll">
            COSMOPARK
        </h2>
        <p class="color-text-secondary text-sm-2 content animate-on-scroll">
            Định hướng phát triển hệ sinh thái công nghiệp bền vững. Với mô hình
            kinh tế tuần hoàn là trọng tâm, dự án áp
            dụng chặt chẽ các tiêu chí EIP 2.0 của UNIDO & IFC World Bank. Điều này đảm bảo sự phù hợp và đóng góp hiệu
            quả vào các mục tiêu phát triển bền vững của khu vực và toàn cầu.
        </p>
    </div>
</div>

@once
    @push('styles')
        <style>
            .intro-image-wrapper {
                position: relative;
            }

            .img-intro {
                width: 100%;
                min-height: 500px;
                object-fit: cover;
                display: block;
            }

            .content-intro-image {
                position: absolute;
                top: 25%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 90%;
                padding: 16px;
                border-radius: 8px;
            }

            .content-intro-image .content {
                width: auto;
            }

            @media (min-width: 992px) {
                .content-intro-image {
                    top: 100px;
                    left: 100px;
                    transform: none;
                    width: 750px;
                    text-align: left;
                }

                .content-intro-image .content {
                    width: 100%;
                }
            }

            /* Animation keyframes */
            @keyframes fadeInImgIntro {
                from {
                    opacity: 0;
                    transform: scale(0.96) translateY(40px);
                }

                to {
                    opacity: 1;
                    transform: scale(1) translateY(0);
                }
            }

            @keyframes fadeInContentIntro {
                from {
                    opacity: 0;
                    transform: translateY(40px);
                }

                to {
                    opacity: 1;
                    transform: none;
                }
            }

            @keyframes fadeInTitleIntro {
                from {
                    opacity: 0;
                    transform: translateY(-30px);
                }

                to {
                    opacity: 1;
                    transform: none;
                }
            }

            @keyframes fadeInTextIntro {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: none;
                }
            }

            /* Chỉ áp dụng opacity: 0 cho các thành phần con */
            .img-intro.animate-on-scroll,
            .content-intro-image h2.animate-on-scroll,
            .content-intro-image .content.animate-on-scroll {
                opacity: 0;
            }

            .animate-on-scroll.animated {
                opacity: 1;
            }

            /* Giữ nguyên animation */
            .img-intro.animate-on-scroll.animated {
                animation: fadeInImgIntro 1s both;
            }

            .content-intro-image.animate-on-scroll.animated {
                animation: fadeInContentIntro 1s 0.2s both;
            }

            .content-intro-image h2.animate-on-scroll.animated {
                animation: fadeInTitleIntro 0.8s 0.4s both;
            }

            .content-intro-image .content.animate-on-scroll.animated {
                animation: fadeInTextIntro 0.8s 0.6s both;
            }
        </style>
    @endpush
@endonce
