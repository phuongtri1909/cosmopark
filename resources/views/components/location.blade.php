<div class="position-relative d-flex justify-content-center">
    <!-- Slider Container -->
    <div class="location-slider-container">
        <div class="location-slider">
            @if($slideLocations && $slideLocations->count() > 0)
                @foreach($slideLocations as $index => $slide)
                    <div class="location-slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index + 1 }}">
                        <img class="img-fluid animate-on-scroll w-100" 
                             src="{{ $slide->image_url }}" 
                             alt="Location {{ $index + 1 }}">
                    </div>
                @endforeach
            @else
                <!-- Fallback images -->
                <div class="location-slide active" data-slide="1">
                    <img class="img-fluid animate-on-scroll w-100" src="{{ asset('assets/images/dev/location.png') }}" alt="Location 1">
                </div>
                <div class="location-slide" data-slide="2">
                    <img class="img-fluid animate-on-scroll w-100" src="{{ asset('assets/images/dev/location.png') }}" alt="Location 2">
                </div>
                <div class="location-slide" data-slide="3">
                    <img class="img-fluid animate-on-scroll w-100" src="{{ asset('assets/images/dev/location.png') }}" alt="Location 3">
                </div>
            @endif
        </div>

        <!-- Desktop Navigation Buttons -->
        <div class="slider-nav desktop-only">
            <button class="nav-btn prev-btn" onclick="changeSlide(-1)">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <button class="nav-btn next-btn" onclick="changeSlide(1)">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Pagination Dots -->
        <div class="slider-pagination mobile-only">
            @if($slideLocations && $slideLocations->count() > 0)
                @foreach($slideLocations as $index => $slide)
                    <span class="pagination-dot {{ $index === 0 ? 'active' : '' }}" 
                          data-slide="{{ $index + 1 }}" 
                          onclick="goToSlide({{ $index + 1 }})"></span>
                @endforeach
            @else
                <span class="pagination-dot active" data-slide="1" onclick="goToSlide(1)"></span>
                <span class="pagination-dot" data-slide="2" onclick="goToSlide(2)"></span>
                <span class="pagination-dot" data-slide="3" onclick="goToSlide(3)"></span>
            @endif
        </div>
    </div>

    <div class="content-location p-4 mt-3 mt-md-0 text-end animate-on-scroll">
        <h5 class="fw-bold text-1lg-3 color-primary-4 animate-on-scroll">{{ __('STRATEGIC LOCATION MAP') }}</h5>
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
            right: 10%;
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

        /* Slider Styles */
        .location-slider-container {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .location-slider {
            position: relative;
            width: 100%;
            height: auto;
        }

        .location-slide {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .location-slide.active {
            display: block;
            opacity: 1;
        }

        .location-slide img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        /* Desktop Navigation Buttons */
        .slider-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 10;
        }

        .nav-btn {
            background: var(--primary-color-4, #333);
            border: none;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .nav-btn:hover {
            background: rgba(255, 255, 255, 1);
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .nav-btn svg {
            color: white;
        }

        .nav-btn:hover svg {
            color: var(--primary-color-4, #333);
        }

        /* Mobile Pagination Dots */
        .slider-pagination {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 12px;
            z-index: 10;
        }

        .pagination-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .pagination-dot.active {
            background: var(--color-primary, #fff);
            transform: scale(1.2);
        }

        .pagination-dot:hover {
            background: rgba(255, 255, 255, 0.8);
        }

        /* Responsive */
        .desktop-only {
            display: none;
        }

        .mobile-only {
            display: flex;
        }

        @media (min-width: 768px) {
            .desktop-only {
                display: flex;
            }

            .mobile-only {
                display: none;
            }
        }

        /* Animation keyframes */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(40px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        @keyframes zoomIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-on-scroll {
            opacity: 0;
        }

        .animate-on-scroll.animated {
            opacity: 1;
        }

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

        .bg-white .d-flex.animate-on-scroll.animated:nth-child(1) {
            animation-delay: 1s;
        }

        .bg-white .d-flex.animate-on-scroll.animated:nth-child(2) {
            animation-delay: 1.2s;
        }

        .bg-white .d-flex.animate-on-scroll.animated:nth-child(3) {
            animation-delay: 1.4s;
        }

        .bg-white .d-flex.animate-on-scroll.animated:nth-child(4) {
            animation-delay: 1.6s;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let currentSlide = 1;
        const totalSlides = {{ $slideLocations && $slideLocations->count() > 0 ? $slideLocations->count() : 3 }};

        function changeSlide(direction) {
            currentSlide += direction;
            
            if (currentSlide > totalSlides) {
                currentSlide = 1;
            } else if (currentSlide < 1) {
                currentSlide = totalSlides;
            }
            
            updateSlider();
        }

        function goToSlide(slideNumber) {
            currentSlide = slideNumber;
            updateSlider();
        }

        function updateSlider() {
            // Update slides
            document.querySelectorAll('.location-slide').forEach(slide => {
                slide.classList.remove('active');
            });
            
            document.querySelector(`[data-slide="${currentSlide}"]`).classList.add('active');
            
            // Update pagination dots
            document.querySelectorAll('.pagination-dot').forEach(dot => {
                dot.classList.remove('active');
            });
            
            document.querySelector(`[data-slide="${currentSlide}"]`).classList.add('active');
        }

        // Auto-play slider
        function autoPlay() {
            setInterval(() => {
                changeSlide(1);
            }, 5000); // Change slide every 5 seconds
        }

        // Initialize slider
        document.addEventListener('DOMContentLoaded', function() {
            updateSlider();
            autoPlay();
        });

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
