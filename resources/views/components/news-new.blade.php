@props(['newsList' => [], 'categories' => []])

<div class="news-new pb-5">
    <div class="container">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center flex-column flex-md-row mb-4">
            <h2 class="text-xl-3 color-primary-4 fw-bold mb-3 mb-md-0">
                TIN TỨC MỚI NHẤT
            </h2>

            <!-- Search Section - Full width on mobile -->
            <div class="w-md-auto">
                <div class="position-relative search-box">
                    <span class="position-absolute top-50 start-0 translate-middle-y ps-3">
                        <img src="{{ asset('assets/images/svg/search.svg') }}" alt="Search" width="16">
                    </span>
                    <input type="text" id="newsSearchInput" class="form-control rounded-pill ps-5"
                           placeholder="Tìm kiếm tin tức..." value="{{ request('search') }}">
                </div>
            </div>
        </div>

        <!-- Category Filter Section -->
        <div class="category-filter-section mb-4">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button type="button" class="btn-category-news color-primary-8 rounded-5 text-md px-3 py-2 animate-on-scroll active"
                        data-category="all">
                    Tất cả
                </button>
                @foreach($categories as $category)
                    <button type="button" class="btn-category-news color-primary-8 rounded-5 text-md px-3 py-2 animate-on-scroll"
                            data-category="{{ $category->id }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container">
        <div id="newsListContainer">
            <x-news-list :blogs="$newsList" />
        </div>

        <!-- Loading spinner -->
        <div id="loadingSpinner" class="text-center py-5" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Đang tải...</span>
            </div>
        </div>
    </div>
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/slider.css') }}">
        <style>
            .btn-category-news {
                border: 1px solid var(--primary-color-5);
                background: #FFF;
                transition: all 0.3s ease;
                cursor: pointer;
                white-space: nowrap;
                flex-shrink: 0;
            }

            .btn-category-news:hover {
                background: var(--primary-color-4);
                color: #FFF !important;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(var(--primary-color-4-rgb), 0.3);
            }

            .btn-category-news:hover img {
                filter: invert(1);
            }

            .btn-category-news.active {
                background: var(--primary-color-4);
                color: #FFF !important;
                box-shadow: 0 4px 12px rgba(var(--primary-color-4-rgb), 0.3);
            }

            .search-box {
                max-width: 400px;
            }

            .search-box input {
                border: 1px solid var(--primary-color-5);
                width: 100%;
                padding-left: 40px;
                transition: all 0.3s ease;
            }

            .search-box input:hover {
                border-color: var(--primary-color-4);
            }

            .search-box input:focus {
                border-color: var(--primary-color-4);
                box-shadow: 0 0 0 0.2rem rgba(var(--primary-color-4-rgb), 0.25);
                transform: scale(1.02);
            }

            .category-filter-section {
                border-bottom: 1px solid #e9ecef;
                padding-bottom: 1rem;
            }

            .fade-in {
                animation: fadeIn 0.3s ease-in;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            /* Mobile Responsive */
            @media (max-width: 768px) {
                .search-box {
                    max-width: 100%;
                }

                .category-filter-section {
                    overflow-x: auto;
                    padding-bottom: 0.5rem;
                }

                .category-filter-section .d-flex {
                    min-width: max-content;
                    padding-bottom: 0.5rem;
                }

                .btn-category-news {
                    font-size: 0.875rem;
                    padding: 0.5rem 1rem;
                }
            }

            @media (max-width: 576px) {
                .btn-category-news {
                    font-size: 0.8rem;
                    padding: 0.4rem 0.8rem;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/js/index-slider.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const categoryButtons = document.querySelectorAll('.btn-category-news');
                const searchInput = document.getElementById('newsSearchInput');
                const newsListContainer = document.getElementById('newsListContainer');
                const loadingSpinner = document.getElementById('loadingSpinner');

                let currentCategory = 'all';
                let currentSearch = '';
                let searchTimeout;

                // Initialize pagination for initial page load
                initializePagination();

                // Category button click handler
                categoryButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const category = this.dataset.category;
                        if (category !== currentCategory) {
                            currentCategory = category;
                            setActiveCategoryButton(category);
                            filterNews();
                        }
                    });
                });

                // Search input handler with debounce
                searchInput.addEventListener('input', function() {
                    const searchValue = this.value.trim();
                    if (searchValue !== currentSearch) {
                        currentSearch = searchValue;
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(() => {
                            filterNews();
                        }, 500);
                    }
                });

                // Set active category button
                function setActiveCategoryButton(category) {
                    categoryButtons.forEach(button => {
                        button.classList.remove('active');
                        if (button.dataset.category === category) {
                            button.classList.add('active');
                        }
                    });
                }

                // Initialize pagination for initial page load
                function initializePagination() {
                    const paginationLinks = newsListContainer.querySelectorAll('.custom-pagination a');
                    paginationLinks.forEach(link => {
                        link.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();

                            const url = new URL(this.href);
                            const page = url.searchParams.get('page');

                            if (page) {
                                loadPage(page);
                            }

                            return false;
                        });
                    });
                }

                // Filter news using AJAX
                function filterNews() {
                    showLoading();

                    const formData = new FormData();
                    formData.append('category', currentCategory);
                    formData.append('search', currentSearch);
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route("news.filter") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideLoading();
                        updateNewsList(data);
                    })
                    .catch(error => {
                        hideLoading();
                        console.error('Error:', error);
                        showError('Có lỗi xảy ra khi tải dữ liệu');
                    });
                }

                // Update news list with new data
                function updateNewsList(data) {
                    newsListContainer.innerHTML = data.html;
                    newsListContainer.classList.add('fade-in');

                    // Remove animation class after animation completes
                    setTimeout(() => {
                        newsListContainer.classList.remove('fade-in');
                    }, 300);

                    // Update pagination links to work with AJAX
                    updatePaginationLinks();
                }

                // Update pagination links to work with AJAX
                function updatePaginationLinks() {
                    const paginationLinks = newsListContainer.querySelectorAll('.custom-pagination a');
                    paginationLinks.forEach(link => {
                        // Remove any existing event listeners
                        link.removeEventListener('click', handlePaginationClick);
                        // Add new event listener
                        link.addEventListener('click', handlePaginationClick);
                    });
                }

                // Handle pagination click
                function handlePaginationClick(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Lấy page từ URL
                    const url = new URL(this.href);
                    const page = url.searchParams.get('page');

                    if (page) {
                        loadPage(page);
                    }

                    return false;
                }

                // Load specific page
                function loadPage(page) {
                    showLoading();

                    const formData = new FormData();
                    formData.append('category', currentCategory);
                    formData.append('search', currentSearch);
                    formData.append('page', page);
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route("news.filter") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideLoading();
                        updateNewsList(data);

                        // Scroll to top of news list
                        newsListContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    })
                    .catch(error => {
                        hideLoading();
                        console.error('Error:', error);
                        showError('Có lỗi xảy ra khi tải trang');
                    });
                }

                // Show loading spinner
                function showLoading() {
                    loadingSpinner.style.display = 'block';
                    newsListContainer.style.opacity = '0.5';
                }

                // Hide loading spinner
                function hideLoading() {
                    loadingSpinner.style.display = 'none';
                    newsListContainer.style.opacity = '1';
                }

                // Show error message
                function showError(message) {
                    newsListContainer.innerHTML = `
                        <div class="col-12 text-center py-5">
                            <div class="text-danger">
                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                <h5>Lỗi</h5>
                                <p>${message}</p>
                            </div>
                        </div>
                    `;
                }
            });
        </script>
    @endpush
@endonce
