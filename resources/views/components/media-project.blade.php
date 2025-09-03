@props(['project' => null])

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
        <div class="slider-wrapper-container mt-5">
            <div class="slider-container">
                <div class="slider-wrapper">
                    <div class="slider-track" id="desktop-slider-track">
                    </div>
                </div>
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
            <div class="mt-3">
                <div class="slider-wrapper-container">
                    <div class="slider-container">
                        <div class="slider-wrapper">
                            <div class="slider-track" id="mobile-images-track">
                            </div>
                        </div>
                    </div>
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

    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="ratio ratio-16x9">
                        <iframe id="videoIframe" src="" title="YouTube video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
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

            /* Video Thumbnail Styles */
            .video-thumbnail {
                position: relative;
                cursor: pointer;
                transition: transform 0.3s ease;
            }

            .video-thumbnail:hover {
                transform: scale(1.05);
            }

            .video-play-button {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 60px;
                height: 60px;
                background: rgba(255, 0, 0, 0.8);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 24px;
                transition: all 0.3s ease;
            }

            .video-thumbnail:hover .video-play-button {
                background: rgba(255, 0, 0, 1);
                transform: translate(-50%, -50%) scale(1.1);
            }

            .slide-images img {
                object-fit: cover !important;
                object-position: center !important;
            }

            .video-thumbnail img {
                object-fit: cover !important;
                object-position: center !important;
            }

            /* Empty State */
            .empty-state {
                text-align: center;
                padding: 40px 20px;
                color: #6c757d;
            }

            .empty-state i {
                font-size: 48px;
                margin-bottom: 16px;
                opacity: 0.5;
            }

            /* Mobile Layout */
            @media (max-width: 767px) {
                .media-project .container {
                    flex-direction: column;
                    gap: 20px;
                }

                .category-media {
                    display: none;
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
                const projectSlug = '{{ $project->slug }}';
                
                if (!projectSlug) {
                    console.error('Project slug not found');
                    return;
                }
                
                let currentType = 'images';
                let mediaData = {};
                let desktopSlider = null;
                let mobileSlider = null;

                loadMediaData('images', true);

                setTimeout(() => {
                    reinitializeSliders();
                }, 800);

                setTimeout(() => {
                    if (!mediaData.images || mediaData.images.length === 0) {
                        showEmptyState('images');
                    }
                }, 2500);

                document.querySelectorAll('.btn-category').forEach(button => {
                    button.addEventListener('click', function() {
                        const target = this.dataset.target;
                        if (target === currentType) return;

                        document.querySelectorAll('.btn-category').forEach(btn => btn.classList.remove('active'));
                        this.classList.add('active');

                        loadMediaData(target, false);
                        currentType = target;
                    });
                });

                document.querySelectorAll('.mobile-btn-category').forEach(button => {
                    button.addEventListener('click', function() {
                        const target = this.dataset.target;
                        if (target === currentType) return;

                        document.querySelectorAll('.mobile-btn-category').forEach(btn => btn.classList.remove('active'));
                        document.querySelectorAll('.mobile-data-section').forEach(section => section.classList.remove('active'));
                        
                        this.classList.add('active');
                        document.getElementById(target + '-data').classList.add('active');

                        if (!mediaData[target]) {
                            loadMediaData(target, false);
                        } else {
                            renderMedia(target);
                        }
                        
                        currentType = target;
                    });
                });

                function loadMediaData(type, isInitial = false) {
                    const loadingPlaceholder = document.querySelector(`#${type}-data .loading-placeholder`);
                    if (loadingPlaceholder) {
                        loadingPlaceholder.style.display = 'block';
                    }

                    fetch(`/project-media/${projectSlug}/${type}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            mediaData[type] = data;
                            renderMedia(type);
                            
                            if (loadingPlaceholder) {
                                loadingPlaceholder.style.display = 'none';
                            }
                        })
                        .catch(error => {
                            console.error('Error loading media:', error);
                            showEmptyState(type);
                            
                            if (loadingPlaceholder) {
                                loadingPlaceholder.style.display = 'none';
                            }
                        });
                }

                function renderMedia(type) {
                    const data = mediaData[type];
                    
                    if (!data || data.length === 0) {
                        showEmptyState(type);
                        return;
                    }

                    renderDesktopSlider(type, data);
                    
                    renderMobileSlider(type, data);

                    setTimeout(() => {
                        reinitializeSliders();
                    }, 100);
                }

                function renderDesktopSlider(type, data) {
                    const track = document.getElementById('desktop-slider-track');
                    if (!track) {
                        return;
                    }

                    track.innerHTML = '';
                    
                    if (type === 'videos') {
                        renderVideoSlides(track, data, 'desktop');
                    } else {
                        renderImageSlides(track, data, 'desktop');
                    }
                }

                function renderMobileSlider(type, data) {
                    const track = document.getElementById('mobile-' + type.replace('-', '') + '-track');
                    if (!track) {
                        return;
                    }

                    track.innerHTML = '';
                    
                    if (type === 'videos') {
                        renderVideoSlides(track, data, 'mobile');
                    } else {
                        renderImageSlides(track, data, 'mobile');
                    }
                }

                function renderImageSlides(track, data, layout) {
                    
                    data.forEach((item, index) => {
                        const slide = document.createElement('div');
                        slide.className = `slide ${index === 0 ? 'active' : ''}`;
                        slide.dataset.index = index;
                        
                        const leftImageUrl = getImageUrl(data, index - 1);
                        const rightImageUrl = getImageUrl(data, index + 1);
                        
                        slide.innerHTML = `
                            <div class="slide-images">
                                <div class="side-image left-image">
                                    <img src="${leftImageUrl}" alt="Left Image">
                                </div>
                                <div class="center-image">
                                    <img src="${item.file_url}" alt="${item.title || 'Image'}">
                                </div>
                                <div class="side-image right-image">
                                    <img src="${rightImageUrl}" alt="Right Image">
                                </div>
                            </div>
                        `;
                        
                        track.appendChild(slide);
                    });
                }

                function renderVideoSlides(track, data, layout) {
                    
                    data.forEach((item, index) => {
                        const slide = document.createElement('div');
                        slide.className = `slide ${index === 0 ? 'active' : ''}`;
                        slide.dataset.index = index;
                        
                        const leftThumbnail = getVideoThumbnail(data, index - 1);
                        const rightThumbnail = getVideoThumbnail(data, index + 1);
                        
                        slide.innerHTML = `
                            <div class="slide-images">
                                <div class="side-image left-image">
                                    <img src="${leftThumbnail}" alt="Left Video">
                                </div>
                                <div class="center-image">
                                    <div class="video-thumbnail" onclick="playVideo('${item.embed_url}', '${item.title || 'Video'}')">
                                        <img src="${item.thumbnail_url}" alt="${item.title || 'Video'}">
                                        <div class="video-play-button">
                                            <i class="fas fa-play"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="side-image right-image">
                                    <img src="${rightThumbnail}" alt="Right Video">
                                </div>
                            </div>
                        `;
                        
                        track.appendChild(slide);
                    });
                }

                function getImageUrl(data, index) {
                    if (index < 0 || index >= data.length) {
                        return 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop';
                    }
                    return data[index].file_url || 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop';
                }

                function getVideoThumbnail(data, index) {
                    if (index < 0 || index >= data.length) {
                        return 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop';
                    }
                    return data[index].thumbnail_url || 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&h=600&fit=crop';
                }

                function showEmptyState(type) {
                    const typeLabels = {
                        'images': 'hình ảnh',
                        'plans': 'kế hoạch',
                        'videos': 'video',
                        'street-views': 'góc nhìn đường phố'
                    };

                    const emptyState = `
                        <div class="empty-state">
                            <i class="fas fa-${type === 'videos' ? 'video' : 'image'}"></i>
                            <h5>Không có ${typeLabels[type]} nào</h5>
                            <p>Dự án này chưa có ${typeLabels[type]} để hiển thị.</p>
                        </div>
                    `;

                    const desktopTrack = document.getElementById('desktop-slider-track');
                    if (desktopTrack) {
                        desktopTrack.innerHTML = emptyState;
                    }

                    const mobileSection = document.getElementById(type + '-data');
                    if (mobileSection) {
                        const track = mobileSection.querySelector('.slider-track');
                        if (track) {
                            track.innerHTML = emptyState;
                        }
                    }

                    if (desktopSlider && desktopSlider.autoPlayInterval) {
                        clearInterval(desktopSlider.autoPlayInterval);
                    }
                    if (mobileSlider && mobileSlider.autoPlayInterval) {
                        clearInterval(mobileSlider.autoPlayInterval);
                    }
                }

                function reinitializeSliders() {
                    const desktopTrack = document.getElementById('desktop-slider-track');
                    if (desktopTrack && desktopTrack.children.length > 0) {
                        if (window.desktopExpoSlider && typeof window.desktopExpoSlider.refreshSlides === 'function') {
                            window.desktopExpoSlider.refreshSlides();
                            desktopSlider = window.desktopExpoSlider;
                        }
                    }

                    const mobileTrack = document.getElementById('mobile-' + currentType.replace('-', '') + '-track');
                    if (mobileTrack && mobileTrack.children.length > 0) {
                        if (window.mobileExpoSlider && typeof window.mobileExpoSlider.refreshSlides === 'function') {
                            window.mobileExpoSlider.refreshSlides();
                            mobileSlider = window.mobileExpoSlider;
                        }
                    }
                }

                window.playVideo = function(videoUrl, title) {
                    if (!videoUrl) {
                        return;
                    }
                    
                    const modal = document.getElementById('videoModal');
                    const iframe = document.getElementById('videoIframe');
                    const modalTitle = document.getElementById('videoModalLabel');
                    
                    if (!modal || !iframe || !modalTitle) {
                        return;
                    }
                    
                    iframe.src = videoUrl;
                    modalTitle.textContent = title || 'Video';
                    
                    try {
                        const bootstrapModal = new bootstrap.Modal(modal);
                        bootstrapModal.show();
                    } catch (e) {
                        modal.style.display = 'block';
                        modal.classList.add('show');
                    }
                };

                document.getElementById('videoModal').addEventListener('hidden.bs.modal', function () {
                    const iframe = document.getElementById('videoIframe');
                    if (iframe) {
                        iframe.src = '';
                    }
                });

                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('btn-close') || e.target.closest('.btn-close')) {
                        const modal = document.getElementById('videoModal');
                        if (modal) {
                            modal.style.display = 'none';
                            modal.classList.remove('show');
                            const iframe = document.getElementById('videoIframe');
                            if (iframe) {
                                iframe.src = '';
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endonce
