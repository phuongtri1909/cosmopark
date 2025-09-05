<div class="gallery-list feature-gradient-bg feature-rounded-top" data-gallery-id="{{ $galleryId ?? 'default' }}">
    <div class="p-100">
        <div class="card-gallery-list mb-5" id="project-buttons">
            <!-- Project buttons will be loaded here via AJAX -->
            <div class="loading-projects">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">{{ __('Loading...') }}</span>
                </div>
                <p class="mt-2 text-muted">{{ __('Loading projects...') }}</p>
            </div>
        </div>

        <div class="gallery-list-content" id="gallery-content">
            <!-- Loading state -->
            <div class="loading-gallery text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">{{ __('Loading...') }}</span>
                </div>
                <p class="mt-2 text-muted">{{ __('Loading gallery...') }}</p>
            </div>

            <!-- Gallery rows container -->
            <div id="gallery-rows-container" class="d-none">
                <!-- Gallery rows will be loaded here via AJAX -->
            </div>

            <!-- View More Button -->
            <div class="text-center mt-4 d-flex justify-content-center d-none" id="view-more-container">
                <button onclick="loadMoreGalleries()"
                    class="btn submit-btn-custom rounded-pill p-2 mb-3 d-none d-md-flex animate-on-scroll text-decoration-none">
                    <span class="submit-text me-2 ps-3">{{ __('View more') }}</span>
                    <div class="submit-icon submit-icon-custom">
                        <img class="arrow-icon-main" src="{{ asset('assets/images/svg/arrow-left.svg') }}" />
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .main-image,
        .sub-image {
            object-fit: cover;
        }

        .feature-gradient-bg {
            background-color: white;
        }

        .feature-rounded-top {
            position: relative;
            border-radius: 50px 50px 0 0;
            z-index: 1;
        }

        .gallery-list {
            margin-top: -50px;
        }

        .card-gallery-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            max-width: 900px;
            margin: 0 auto;
        }

        .btn-category-project {
            flex: 0 0 280px;
            width: 280px;
            height: 50px;
            border: 1px solid var(--primary-color-5);
            background: #FFF;
            transition: all 0.3s ease;
            cursor: pointer;
            white-space: nowrap;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Button thứ 4 và 5 sẽ nằm ở giữa */
        .btn-category-project:nth-child(4) {
            margin-left: calc(16.666% + 10px);
        }

        .btn-category-project:nth-child(5) {
            margin-right: calc(16.666% + 10px);
        }

        /* Tablet Layout - Mỗi hàng 3 buttons, sắp xếp so le */
        @media (min-width: 577px) and (max-width: 991px) {
            .card-gallery-list {
                max-width: 600px;
                gap: 15px;
            }

            .btn-category-project {
                flex: 0 0 calc(33.333% - 10px);
                width: calc(33.333% - 10px);
                height: 45px;
                font-size: 13px;
                padding: 10px 15px;
            }

            /* Reset margin cho button 4 và 5 trên tablet */
            .btn-category-project:nth-child(4),
            .btn-category-project:nth-child(5) {
                margin-left: 0;
                margin-right: 0;
            }

            .btn-category-project:nth-child(5) {
                margin-left: calc(16.666% + 7.5px);
            }
        }

        .btn-category-project:hover {
            background: var(--primary-color-4);
            color: #FFF !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(var(--primary-color-4-rgb), 0.3);
        }

        .btn-category-project:hover img {
            filter: invert(1);
        }

        .btn-category-project.active {
            background: var(--primary-color-4);
            color: #FFF !important;
            box-shadow: 0 4px 12px rgba(var(--primary-color-4-rgb), 0.3);
        }

        /* Mobile Responsive */
        @media (max-width: 576px) {
            .card-gallery-list {
                gap: 12px;
                max-width: 320px;
            }

            .btn-category-project {
                flex: 0 0 100%;
                width: 100%;
                height: 40px;
                font-size: 0.8rem;
                padding: 8px 14px;
            }

            /* Reset margin cho tất cả buttons trên mobile */
            .btn-category-project:nth-child(2),
            .btn-category-project:nth-child(4),
            .btn-category-project:nth-child(5) {
                margin-left: 0;
                margin-right: 0;
            }
        }

        /* Lightbox Styles */
        .lightbox-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        .lightbox-content {
            position: relative;
            max-width: 90%;
            max-height: 90%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lightbox-image {
            max-width: 100%;
            max-height: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        .lightbox-close {
            position: absolute;
            top: -40px;
            right: 0;
            color: white;
            font-size: 30px;
            cursor: pointer;
            background: rgba(0, 0, 0, 0.5);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }

        .lightbox-close:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Loading states */
        .loading-projects,
        .loading-gallery {
            text-align: center;
            padding: 40px 20px;
            color: var(--color-primary);
        }

        .loading-projects .spinner-border,
        .loading-gallery .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        /* Gallery rows container */
        #gallery-rows-container {
            padding: 0;
        }

        /* Gallery row styling */
        .gallery-row {
            position: relative;
            padding: 60px 0;
            margin-bottom: 0;
        }

        .gallery-row:last-child {
            margin-bottom: 0;
        }

        /* Gallery images styling */
        .gallery-main-img {
            transition: opacity 0.3s ease;
            border-radius: 16px;
        }

        .gallery-sub-img {
            transition: opacity 0.3s ease;
            border-radius: 12px;
        }

        /* Gallery content styling */
        .gallery-title {
            color: var(--primary-color-4, #2c3e50);
            font-weight: 600;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .gallery-description {
            color: #6c757d;
            line-height: 1.6;
            font-size: 1.1rem;
        }

        .gallery-project-info .badge {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 1199.98px) {
            .gallery-row {
                padding: 40px 0;
            }
            
            .gallery-title {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 991.98px) {
            .gallery-row .row {
                flex-direction: column !important;
            }
            
            .gallery-content {
                padding-left: 0 !important;
                padding-right: 0 !important;
                margin-top: 2rem;
            }
            
            .gallery-title {
                font-size: 1.5rem;
                text-align: center;
            }
            
            .gallery-description {
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .gallery-row {
                padding: 30px 0;
            }
            
            .gallery-title {
                font-size: 1.25rem;
            }
            
            .gallery-description {
                font-size: 1rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        if (typeof window.galleryListInitialized === 'undefined') {
            window.galleryListInitialized = true;

            let currentProjectId = null;
            let currentGalleryIndex = 0;
            let allGalleries = [];
            let autoRotateInterval = null;
            let gallerySlideIntervals = {};
            let currentPage = 1;
            let hasMoreGalleries = true;

            document.addEventListener('DOMContentLoaded', function() {
                if (!window.galleryListLoaded) {
                    window.galleryListLoaded = true;
                    loadProjects();
                }
            });

            async function loadProjects() {
                try {
                    const projectButtonsContainer = document.getElementById('project-buttons');
                    if (!projectButtonsContainer) return;

                    const response = await fetch('/galleries/projects', {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Failed to load projects');
                    }

                    const data = await response.json();

                    if (data.success) {
                        renderProjectButtons(data.data);
                        if (data.data.length > 0) {
                            loadProjectGallery(data.data[0].id);
                        }
                    }
                } catch (error) {
                    console.error('Error loading projects:', error);
                    const projectButtonsContainer = document.getElementById('project-buttons');
                    if (projectButtonsContainer) {
                        projectButtonsContainer.innerHTML = '<p class="text-danger">Không thể tải danh sách dự án</p>';
                    }
                }
            }

            function renderProjectButtons(projects) {
                const container = document.getElementById('project-buttons');
                if (!container) return;

                container.innerHTML = '';

                projects.forEach((project, index) => {
                    const button = document.createElement('button');
                    button.className = `btn-category-project rounded-5 ${index === 0 ? 'active' : ''}`;
                    button.textContent = project.title;
                    button.onclick = () => selectProject(project.id, button);
                    container.appendChild(button);
                });
            }

            async function selectProject(projectId, buttonElement) {
                document.querySelectorAll('.btn-category-project').forEach(btn => btn.classList.remove('active'));
                buttonElement.classList.add('active');

                currentProjectId = projectId;
                await loadProjectGallery(projectId);
            }

            async function loadProjectGallery(projectId) {
                try {
                    stopAllGalleryAutoSlides();
                    allGalleries = [];
                    currentGalleryIndex = 0;
                    currentPage = 1;
                    hasMoreGalleries = true;


                    const loadingGallery = document.querySelector('.loading-gallery');
                    const galleryRowsContainer = document.getElementById('gallery-rows-container');
                    const viewMoreContainer = document.getElementById('view-more-container');

                    if (loadingGallery) {
                        loadingGallery.classList.remove('d-none');
                        loadingGallery.innerHTML = `
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">{{ __('Loading...') }}</span>
                    </div>
                    <p class="mt-2 text-muted">{{ __('Loading gallery...') }}</p>
                `;
                    }

                    if (galleryRowsContainer) {
                        galleryRowsContainer.classList.add('d-none');
                        galleryRowsContainer.innerHTML = '';
                    }

                    if (viewMoreContainer) {
                        viewMoreContainer.classList.add('d-none');
                    }

                    const response = await fetch(`/galleries/project/${projectId}`, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Failed to load gallery');
                    }

                    const data = await response.json();

                    if (data.success && data.data.galleries.length > 0) {
                        allGalleries = data.data.galleries;
                        
                        if (loadingGallery) {
                            loadingGallery.classList.add('d-none');
                        }
                        
                        if (galleryRowsContainer && data.data.html) {
                            galleryRowsContainer.innerHTML = data.data.html;
                            galleryRowsContainer.classList.remove('d-none');
                            
                            data.data.galleries.forEach((gallery, index) => {
                                startGalleryAutoSlide(gallery.id, index);
                            });
                        }

                        hasMoreGalleries = data.data.has_more || false;
                        
                        const viewMoreContainer = document.getElementById('view-more-container');
                        if (viewMoreContainer) {
                            const shouldShow = hasMoreGalleries && data.data.total_galleries > allGalleries.length;
                            
                            if (shouldShow) {
                                viewMoreContainer.classList.remove('d-none');
                            } else {
                                viewMoreContainer.classList.add('d-none');
                            }
                        }
                    } else {
                        if (loadingGallery) {
                            loadingGallery.innerHTML = '<p class="text-muted">{{ __('No gallery available for this project') }}</p>';
                        }

                        hasMoreGalleries = false;
                        const viewMoreContainer = document.getElementById('view-more-container');
                        if (viewMoreContainer) {
                            viewMoreContainer.classList.add('d-none');
                        }
                    }
                } catch (error) {
                    console.error('Error loading gallery:', error);
                    const loadingGallery = document.querySelector('.loading-gallery');
                    if (loadingGallery) {
                        loadingGallery.innerHTML = '<p class="text-danger">{{ __('Failed to load gallery') }}</p>';
                    }
                }
            }


            window.loadMoreGalleries = async function() {
                if (!currentProjectId || !hasMoreGalleries) return;

                const viewMoreBtn = document.querySelector('#view-more-container button');
                if (viewMoreBtn) {
                    viewMoreBtn.disabled = true;
                    viewMoreBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __('Loading...') }}';
                }

                try {
                    currentPage++;
                    
                    const response = await fetch(`/galleries/project/${currentProjectId}/load-more?page=${currentPage}&per_page=2`, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Failed to load more galleries');
                    }

                    const data = await response.json();

                    if (data.success && data.data.data.length > 0) {
                            allGalleries = [...allGalleries, ...data.data.data];

                        const galleryRowsContainer = document.getElementById('gallery-rows-container');
                        if (galleryRowsContainer && data.data.html) {
                            galleryRowsContainer.insertAdjacentHTML('beforeend', data.data.html);
                            
                            data.data.data.forEach((gallery, index) => {
                                const globalIndex = allGalleries.length - data.data.data.length + index;
                                startGalleryAutoSlide(gallery.id, globalIndex);
                            });
                        }

                        hasMoreGalleries = data.data.has_more;
                        
                        const viewMoreContainer = document.getElementById('view-more-container');
                        if (viewMoreContainer) {
                            const shouldShow = hasMoreGalleries && data.data.data.length > 0;
                            
                            if (shouldShow) {
                                viewMoreContainer.classList.remove('d-none');
                            } else {
                                viewMoreContainer.classList.add('d-none');
                            }
                        }
                    } else {
                        hasMoreGalleries = false;
                        const viewMoreContainer = document.getElementById('view-more-container');
                        if (viewMoreContainer) {
                            viewMoreContainer.classList.add('d-none');
                        }
                    }
                } catch (error) {
                    console.error('Error loading more galleries:', error);
                } finally {
                    if (viewMoreBtn) {
                        viewMoreBtn.disabled = false;
                        viewMoreBtn.innerHTML = '<span class="submit-text me-2 ps-3">View more</span><div class="submit-icon submit-icon-custom"><img class="arrow-icon-main" src="/assets/images/svg/arrow-left.svg" /></div>';
                    }
                }
            }

            function startGalleryAutoSlide(galleryId, galleryIndex) {
                if (gallerySlideIntervals[galleryId]) {
                    clearInterval(gallerySlideIntervals[galleryId]);
                }
                
                const subImages = document.querySelectorAll(`[data-gallery-sub="${galleryId}"]`);
                if (subImages.length === 0) return;
                
                let currentImageIndex = 0;
                
                gallerySlideIntervals[galleryId] = setInterval(() => {
                    const nextImageSrc = subImages[currentImageIndex].getAttribute('data-sub-src');
                    switchMainImage(galleryId, nextImageSrc, subImages[currentImageIndex]);
                    
                    currentImageIndex = (currentImageIndex + 1) % subImages.length;
                }, 5000);
            }
            
            function stopGalleryAutoSlide(galleryId) {
                if (gallerySlideIntervals[galleryId]) {
                    clearInterval(gallerySlideIntervals[galleryId]);
                    delete gallerySlideIntervals[galleryId];
                }
            }
            
            function stopAllGalleryAutoSlides() {
                Object.keys(gallerySlideIntervals).forEach(galleryId => {
                    clearInterval(gallerySlideIntervals[galleryId]);
                });
                gallerySlideIntervals = {};
            }

            function switchMainImage(galleryId, newImageSrc, clickedElement) {
                const mainImage = document.querySelector(`[data-gallery-main="${galleryId}"]`);
                if (mainImage && clickedElement) {
                    const currentMainSrc = mainImage.getAttribute('data-current-src');
                    
                    clickedElement.src = currentMainSrc;
                    clickedElement.setAttribute('data-sub-src', currentMainSrc);
                    clickedElement.setAttribute('onclick', `openLightbox('${currentMainSrc}')`);
                    
                    mainImage.src = newImageSrc;
                    mainImage.setAttribute('data-current-src', newImageSrc);
                    mainImage.setAttribute('onclick', `openLightbox('${newImageSrc}')`);
                    
                    mainImage.style.opacity = '0.7';
                    clickedElement.style.opacity = '0.7';
                    setTimeout(() => {
                        mainImage.style.opacity = '1';
                        clickedElement.style.opacity = '1';
                    }, 200);
                }
            }

            function openLightbox(imageSrc) {
                const existingLightbox = document.querySelector('.lightbox-overlay');
                if (existingLightbox) {
                    existingLightbox.remove();
                }

                const lightbox = document.createElement('div');
                lightbox.className = 'lightbox-overlay';
                lightbox.innerHTML = `
            <div class="lightbox-content">
                <span class="lightbox-close">&times;</span>
                <img src="${imageSrc}" class="lightbox-image" alt="Gallery Image">
            </div>
        `;

                document.body.appendChild(lightbox);
                document.body.style.overflow = 'hidden';

                const closeLightbox = () => {
                    if (lightbox && lightbox.parentNode) {
                        document.body.removeChild(lightbox);
                        document.body.style.overflow = 'auto';
                    }
                };

                lightbox.addEventListener('click', function(e) {
                    if (e.target === lightbox || e.target.classList.contains('lightbox-close')) {
                        closeLightbox();
                    }
                });

                const handleKeydown = (e) => {
                    if (e.key === 'Escape') {
                        closeLightbox();
                        document.removeEventListener('keydown', handleKeydown);
                    }
                };
                document.addEventListener('keydown', handleKeydown);
            }
        }
    </script>
@endpush
