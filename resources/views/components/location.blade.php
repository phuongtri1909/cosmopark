<!-- Main container -->
<div class="location-container">
    <!-- Images container -->
    <div class="images-container position-relative d-flex justify-content-center">
        <img class="d-none d-lg-block img-fluid animate-on-scroll w-100" src="{{ asset('assets/images/locations/background.gif') }}" alt="">
        <img class="d-block d-lg-none w-100 animate-on-scroll" src="{{ asset('assets/images/locations/background.gif') }}" alt="">
        
        <!-- Overlay images -->
        <img id="line-overlay" class="overlay-image show" src="{{ asset('assets/images/locations/line.gif') }}" alt="">
        <img id="cang-overlay" class="overlay-image d-none" src="{{ asset('assets/images/locations/cang.png') }}" alt="">
    </div>

    <!-- Content container -->
    <div class="content-location p-4 mt-3 mt-md-0 text-center text-md-end animate-on-scroll" style="max-width: 450px;">
        <h5 class="fw-bold text-2xl-1 color-primary-4 animate-on-scroll">{!! __('STRATEGIC LOCATION MAP') !!}</h5>

        <div class="bg-white rounded-4 box-shadow mt-3 px-3 py-4 animate-on-scroll">
            <div class="d-flex align-items-center mb-0 mb-lg-3 animate-on-scroll clickable-item active" data-target="line">
                <img src="{{ asset('assets/images/svg/line-1.svg') }}" alt="" class="me-2">
                <span class="text-sm-1 color-text-secondary">TUYẾN ĐƯỜNG TRỌNG ĐIỂM</span>
            </div>
            <div class="d-flex align-items-center animate-on-scroll clickable-item" data-target="cang">
                <img src="{{ asset('assets/images/svg/cang.svg') }}" alt="" class="me-3">
                <span class="text-sm-1 color-text-secondary ms-1">CẢNG/CỬA KHẨU</span>
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
            margin-top: 20px;
            z-index: 2;
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .content-location {
                margin-left: auto;
                margin-right: auto;
            }
        }

        @media (min-width: 992px) {
            .location-container {
                position: relative;
            }
            
            .content-location {
                position: absolute;
                transform: none;
                left: auto;
                top: 24px;
                right: 100px;
                min-width: 340px;
                margin-top: 0;
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

        /* Overlay images styles */
        .overlay-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            z-index: 1;
            transition: opacity 0.3s ease-in-out;
        }

        .overlay-image.show {
            opacity: 1;
        }

        .overlay-image.hide {
            opacity: 0;
        }

        /* Clickable items */
        .clickable-item {
            cursor: pointer;
            transition: background-color 0.2s ease;
            border-radius: 8px;
            padding: 8px;
            margin: -8px;
        }

        .clickable-item:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .clickable-item.active {
            background-color: rgba(0, 123, 255, 0.1);
        }
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

// Handle click events for location items
function handleLocationClick() {
    const clickableItems = document.querySelectorAll('.clickable-item');
    const lineOverlay = document.getElementById('line-overlay');
    const cangOverlay = document.getElementById('cang-overlay');
    
    clickableItems.forEach(item => {
        item.addEventListener('click', function() {
            const target = this.getAttribute('data-target');
            
            // Remove active class from all items
            clickableItems.forEach(el => el.classList.remove('active'));
            
            // Add active class to clicked item
            this.classList.add('active');
            
            // Hide all overlays first
            lineOverlay.classList.add('d-none');
            cangOverlay.classList.add('d-none');
            
            // Show the appropriate overlay
            if (target === 'line') {
                lineOverlay.classList.remove('d-none');
                lineOverlay.classList.add('show');
                cangOverlay.classList.remove('show');
            } else if (target === 'cang') {
                cangOverlay.classList.remove('d-none');
                cangOverlay.classList.add('show');
                lineOverlay.classList.remove('show');
            }
        });
    });
}

window.addEventListener('scroll', animateOnScroll);
window.addEventListener('DOMContentLoaded', function() {
    animateOnScroll();
    handleLocationClick();
});
</script>
@endpush
