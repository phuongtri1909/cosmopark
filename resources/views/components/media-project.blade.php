@props(['images' => []])

<div class="media-project pb-5">
    <div class="container d-flex justify-content-between animate-on-scroll">
        <h2 class="text-xl-3 color-primary-4 fw-bold animate-on-scroll">
            {{ __('MEDIA') }}
        </h2>
        <div class="category-media animate-on-scroll">
            <button class="color-primary-8 rounded-5 btn-category text-md px-3 py-2 me-2 animate-on-scroll active" data-target="images" data-loaded="true">
                <img src="{{ asset('assets/images/svg/image.svg') }}" alt="">
                {{ __('Images') }}
            </button>

            <button class="color-primary-8 rounded-5 btn-category text-md px-3 py-2 me-2 animate-on-scroll" data-target="plans" data-loaded="false">
                <img src="{{ asset('assets/images/svg/plan.svg') }}" alt="">
                {{ __('Plans') }}
            </button>

            <button class="color-primary-8 rounded-5 btn-category text-md px-3 py-2 me-2 animate-on-scroll" data-target="videos" data-loaded="false">
                <img src="{{ asset('assets/images/svg/video.svg') }}" alt="">
                {{ __('Video') }}
            </button>

            <button class="color-primary-8 rounded-5 btn-category text-md px-3 py-2 animate-on-scroll" data-target="street-views" data-loaded="false">
                <img src="{{ asset('assets/images/svg/street.svg') }}" alt="">
                {{ __('Street View') }}
            </button>
        </div>
    </div>

    <!-- Desktop Layout -->
    <div class="d-none d-md-block">
        <div class="swiper mt-5 media-project-swiper">
            <div class="swiper-wrapper">
                @foreach($images as $img)
                <div class="swiper-slide">
                    <div class="expo-container">
                        <img class="expo-image" src="{{ $img }}" />
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Mobile Layout -->
    <div class="d-block d-md-none">
        <!-- Images Button -->
        <div class="mobile-button-container container">
            <button class="mobile-btn-category rounded-5 active" data-target="images" data-loaded="true">
                <img src="{{ asset('assets/images/svg/image.svg') }}" alt="">
                {{ __('Images') }}
            </button>
        </div>
        
        <!-- Images Data -->
        <div class="mobile-data-section active" id="images-data">
            <div class="swiper mt-3 mobile-media-swiper">
                <div class="swiper-wrapper">
                    @foreach($images as $img)
                    <div class="swiper-slide">
                        <div class="expo-container">
                            <img class="expo-image" src="{{ $img }}" />
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Plans Button -->
        <div class="mobile-button-container container">
            <button class="mobile-btn-category rounded-5" data-target="plans" data-loaded="false">
                <img src="{{ asset('assets/images/svg/plan.svg') }}" alt="">
                {{ __('Plans') }}
            </button>
        </div>
        
        <!-- Plans Data -->
        <div class="mobile-data-section" id="plans-data">
            <div class="loading-placeholder">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">{{ __('Loading plans...') }}</p>
            </div>
        </div>

        <!-- Videos Button -->
        <div class="mobile-button-container container">
            <button class="mobile-btn-category rounded-5" data-target="videos" data-loaded="false">
                <img src="{{ asset('assets/images/svg/video.svg') }}" alt="">
                {{ __('Video') }}
            </button>
        </div>
        
        <!-- Videos Data -->
        <div class="mobile-data-section" id="videos-data">
            <div class="loading-placeholder">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">{{ __('Loading videos...') }}</p>
            </div>
        </div>

        <!-- Street Views Button -->
        <div class="mobile-button-container container">
            <button class="mobile-btn-category rounded-5" data-target="street-views" data-loaded="false">
                <img src="{{ asset('assets/images/svg/street.svg') }}" alt="">
                {{ __('Street View') }}
            </button>
        </div>
        
        <!-- Street Views Data -->
        <div class="mobile-data-section" id="street-views-data">
            <div class="loading-placeholder">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">{{ __('Loading street views...') }}</p>
            </div>
        </div>
    </div>
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/slider.css') }}">
        <style>
            .btn-category{
                border: 1px solid var(--primary-color-5);
                background: #FFF;
            }

            .btn-category:hover{
                background: var(--primary-color-4);
                color: #FFF !important;
            }

            .btn-category:hover img{
                filter: invert(1);
            }

            .btn-category.active{
                background: var(--primary-color-4);
                color: #FFF !important;
            }

            .btn-category.active img{
                filter: invert(1);
            }

            /* Mobile Button Styles */
            .mobile-btn-category {
                border: 1px solid var(--primary-color-5);
                background: #FFF;
                width: 100%;
                padding: 12px 16px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                margin: 0;
                transition: all 0.3s ease;
            }

            .mobile-btn-category:hover {
                background: var(--primary-color-4);
                color: #FFF !important;
            }

            .mobile-btn-category:hover img {
                filter: invert(1);
            }

            .mobile-btn-category.active {
                background: var(--primary-color-4);
                color: #FFF !important;
            }

            .mobile-btn-category.active img {
                filter: invert(1);
            }

            /* Mobile Data Sections */
            .mobile-data-section {
                display: none;
                opacity: 0;
                transform: translateY(20px);
                transition: all 0.3s ease;
                margin-bottom: 20px;
            }

            .mobile-data-section.active {
                display: block;
                opacity: 1;
                transform: translateY(0);
            }

            /* Loading Placeholder */
            .loading-placeholder {
                text-align: center;
                padding: 40px 20px;
                color: var(--color-primary);
            }

            .loading-placeholder .spinner-border {
                width: 3rem;
                height: 3rem;
            }

            /* Mobile Layout */
            @media (max-width: 767px) {
                .media-project .container {
                    flex-direction: column;
                    gap: 20px;
                }

                .category-media {
                    display: none; /* Hide desktop buttons on mobile */
                }

                .mobile-button-container {
                    margin-bottom: 16px;
                }

                .mobile-button-container:last-child {
                    margin-bottom: 0;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/js/index-slider.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Desktop and Mobile Section Toggle with Lazy Loading
                const categoryButtons = document.querySelectorAll('.btn-category');
                const mobileButtons = document.querySelectorAll('.mobile-btn-category');
                const mediaSections = document.querySelectorAll('.mobile-data-section');

                // Desktop button handlers
                categoryButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const target = this.getAttribute('data-target');
                        const isLoaded = this.getAttribute('data-loaded') === 'true';
                        
                        // Remove active class from all buttons
                        categoryButtons.forEach(btn => btn.classList.remove('active'));
                        
                        // Add active class to clicked button
                        this.classList.add('active');
                        
                        // Desktop: Load data for the clicked category
                        if (!isLoaded) {
                            loadDesktopData(target, this);
                        }
                    });
                });

                // Mobile button handlers
                mobileButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const target = this.getAttribute('data-target');
                        const isLoaded = this.getAttribute('data-loaded') === 'true';
                        
                        // Remove active class from all buttons and sections
                        mobileButtons.forEach(btn => btn.classList.remove('active'));
                        mediaSections.forEach(section => section.classList.remove('active'));
                        
                        // Add active class to clicked button and target section
                        this.classList.add('active');
                        const targetSection = document.getElementById(target + '-data');
                        targetSection.classList.add('active');
                        
                        // Load data if not already loaded
                        if (!isLoaded) {
                            loadSectionData(target, targetSection, this);
                        }
                    });
                });

                // Initialize first section by default on mobile
                if (window.innerWidth < 768) {
                    const firstButton = document.querySelector('.mobile-btn-category[data-target="images"]');
                    if (firstButton) {
                        firstButton.click();
                    }
                }

                // Function to load section data for mobile
                function loadSectionData(sectionType, sectionElement, buttonElement) {
                    const loadingPlaceholder = sectionElement.querySelector('.loading-placeholder');
                    
                    // Show loading state
                    loadingPlaceholder.style.display = 'block';
                    
                    // API call (replace with actual endpoint)
                    fetch(`/api/media/${sectionType}`)
                        .then(response => response.json())
                        .then(data => {
                            // Hide loading
                            loadingPlaceholder.style.display = 'none';
                            
                            // Render content
                            renderSectionContent(sectionElement, sectionType, data);
                            
                            // Mark as loaded
                            buttonElement.setAttribute('data-loaded', 'true');
                        })
                        .catch(error => {
                            console.error('Error loading data:', error);
                            loadingPlaceholder.innerHTML = `
                                <div class="text-danger">
                                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                    <p>{{ __('Error loading data. Please try again.') }}</p>
                                    <button class="btn btn-outline-primary btn-sm" onclick="loadSectionData('${sectionType}', '${sectionElement.id}', '${buttonElement.id}')">
                                        {{ __('Retry') }}
                                    </button>
                                </div>
                            `;
                        });
                }

                // Function to load data for desktop
                function loadDesktopData(sectionType, buttonElement) {
                    // Show loading state in desktop swiper
                    const swiperContainer = document.querySelector('.media-project-swiper .swiper-wrapper');
                    swiperContainer.innerHTML = `
                        <div class="swiper-slide">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-muted">{{ __('Loading') }} ${sectionType}...</p>
                            </div>
                        </div>
                    `;
                    
                    // API call (replace with actual endpoint)
                    fetch(`/api/media/${sectionType}`)
                        .then(response => response.json())
                        .then(data => {
                            // Render desktop content
                            renderDesktopContent(swiperContainer, sectionType, data);
                            
                            // Mark as loaded
                            buttonElement.setAttribute('data-loaded', 'true');
                        })
                        .catch(error => {
                            console.error('Error loading data:', error);
                            swiperContainer.innerHTML = `
                                <div class="swiper-slide">
                                    <div class="text-center py-5">
                                        <div class="text-danger">
                                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                                            <p>{{ __('Error loading data. Please try again.') }}</p>
                                            <button class="btn btn-outline-primary btn-sm" onclick="loadDesktopData('${sectionType}', '${buttonElement.id}')">
                                                {{ __('Retry') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                }

                // Function to render mobile section content
                function renderSectionContent(sectionElement, sectionType, data) {
                    let html = '';
                    
                    if (sectionType === 'videos') {
                        html = `
                            <div class="swiper mt-3 mobile-media-swiper">
                                <div class="swiper-wrapper">
                                    ${data.map(video => `
                                        <div class="swiper-slide">
                                            <div class="expo-container">
                                                <video class="expo-image" controls>
                                                    <source src="${video}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        `;
                    } else {
                        html = `
                            <div class="swiper mt-3 mobile-media-swiper">
                                <div class="swiper-wrapper">
                                    ${data.map(item => `
                                        <div class="swiper-slide">
                                            <div class="expo-container">
                                                <img class="expo-image" src="${item}" />
                                            </div>
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        `;
                    }
                    
                    sectionElement.innerHTML = html;
                }

                // Function to render desktop content
                function renderDesktopContent(swiperContainer, sectionType, data) {
                    let html = '';
                    
                    if (sectionType === 'videos') {
                        html = data.map(video => `
                            <div class="swiper-slide">
                                <div class="expo-container">
                                    <video class="expo-image" controls>
                                        <source src="${video}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>
                        `).join('');
                    } else {
                        html = data.map(item => `
                            <div class="swiper-slide">
                                <div class="expo-container">
                                    <img class="expo-image" src="${item}" />
                                </div>
                            </div>
                        `).join('');
                    }
                    
                    swiperContainer.innerHTML = html;
                }
            });
        </script>
    @endpush
@endonce
