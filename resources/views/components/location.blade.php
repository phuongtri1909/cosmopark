<div class="position-relative d-flex justify-content-center ">
    <img class="d-none d-lg-block img-fluid animate-on-scroll w-100" src="{{ asset('assets/images/dev/location-1.png') }}" alt="">
    <img class="d-block d-lg-none w-100 animate-on-scroll" src="{{ asset('assets/images/dev/location-2.png') }}" alt="">

    <div class="content-location p-4 mt-3 mt-md-0 text-center text-md-end animate-on-scroll" style="max-width: 450px;">
        <h5 class="fw-bold text-2xl-1 color-primary-4 animate-on-scroll">{{ __('STRATEGIC LOCATION') }}</h5>
        <span class="text-xs-1 color-text-secondary animate-on-scroll">{{ __('location_map_description') }}</span>

        <div class="bg-white rounded-4 box-shadow mt-3 p-3 animate-on-scroll">
            <div class="d-flex align-items-center mb-0 mb-lg-3 animate-on-scroll">
                <img src="{{ asset('assets/images/svg/line-1.svg') }}" alt="" class="me-2">
                <span class="text-sm-1 color-text-secondary">{{ __('WESTERN EXPRESSWAY') }}</span>
            </div>
            <div class="d-flex align-items-center mb-0 mb-lg-3 animate-on-scroll">
                <img src="{{ asset('assets/images/svg/line-2.svg') }}" alt="" class="me-2">
                <span class="text-sm-1 color-text-secondary">{{ __('EXPRESSWAY N2') }}</span>
            </div>
            <div class="d-flex align-items-center mb-0 mb-lg-3 animate-on-scroll">
                <img src="{{ asset('assets/images/svg/line-3.svg') }}" alt="" class="me-2">
                <span class="text-sm-1 color-text-secondary">{{ __('PROVINCIAL ROAD 818') }}</span>
            </div>
            <div class="d-flex align-items-center animate-on-scroll">
                <img src="{{ asset('assets/images/svg/line-4.svg') }}" alt="" class="me-2">
                <span class="text-sm-1 color-text-secondary">{{ __('RING ROAD 4') }}</span>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .box-shadow {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .content-location {
            position: absolute;
            top: -20px;
            z-index: 2;
        }

        @media (min-width: 992px) {
            .content-location {
                transform: none;
                left: auto;
                top: 24px;
                right: 100px;
                min-width: 340px;
            }
        }

        /* Animation keyframes */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px);}
            to { opacity: 1; transform: none;}
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(40px);}
            to { opacity: 1; transform: none;}
        }
        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.8);}
            to { opacity: 1; transform: scale(1);}
        }

        .animate-on-scroll { opacity: 0; }
        .animate-on-scroll.animated { opacity: 1; }

        /* Ảnh lớn */
        .img-fluid.animate-on-scroll.animated,
        .w-100.animate-on-scroll.animated {
            animation: zoomIn 1s both;
        }
        /* Box nội dung */
        .content-location.animate-on-scroll.animated {
            animation: fadeInRight 1s 0.2s both;
        }
        /* Tiêu đề */
        .content-location h5.animate-on-scroll.animated {
            animation: fadeInUp 0.8s 0.4s both;
        }
        /* Mô tả */
        .content-location span.animate-on-scroll.animated {
            animation: fadeInUp 0.8s 0.6s both;
        }
        /* Box trắng */
        .bg-white.animate-on-scroll.animated {
            animation: fadeInUp 0.8s 0.8s both;
        }
        /* Các dòng tuyến đường */
        .bg-white .d-flex.animate-on-scroll.animated {
            animation: fadeInUp 0.7s both;
        }
        .bg-white .d-flex.animate-on-scroll.animated:nth-child(1) { animation-delay: 1s;}
        .bg-white .d-flex.animate-on-scroll.animated:nth-child(2) { animation-delay: 1.2s;}
        .bg-white .d-flex.animate-on-scroll.animated:nth-child(3) { animation-delay: 1.4s;}
        .bg-white .d-flex.animate-on-scroll.animated:nth-child(4) { animation-delay: 1.6s;}
    </style>
@endpush

@push('scripts')
<script>
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top < window.innerHeight - 60 &&
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
