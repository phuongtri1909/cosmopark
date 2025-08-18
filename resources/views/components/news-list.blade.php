@if($blogs->count() > 0)
    <div class="row gx-1 g-3">
        @foreach ($blogs as $news)
            <div class="col-12 col-md-6 col-lg-4">
                <x-card-news :news="$news" />
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $blogs->links('components.paginate') }}
    </div>
@else
    <div class="no-results-container">
        <div class="no-results-content">
            <div class="no-results-icon">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 21L16.514 16.506L21 21ZM19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3 class="no-results-title">Không tìm thấy bài viết nào</h3>
            <p class="no-results-description">
                Hãy thử tìm kiếm với từ khóa khác hoặc chọn danh mục khác
            </p>
            <div class="no-results-actions">
                <button type="button" class="btn-reset-filter" onclick="resetFilters()">
                    <i class="fas fa-refresh me-2"></i>
                    Xóa bộ lọc
                </button>
            </div>
        </div>
    </div>
@endif

@once
    @push('styles')
        <style>
            .no-results-container {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 300px;
                padding: 2rem 1rem;
            }

            .no-results-content {
                text-align: center;
                max-width: 500px;
                animation: slideInUp 0.6s ease-out;
            }

            .no-results-icon {
                margin-bottom: 1.5rem;
                color: var(--primary-color-4);
                opacity: 0.7;
                animation: bounceIn 0.8s ease-out 0.2s both;
            }

            .no-results-title {
                color: var(--primary-color-8);
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 1rem;
                animation: fadeInUp 0.6s ease-out 0.4s both;
            }

            .no-results-description {
                color: var(--primary-color-6);
                font-size: 1rem;
                line-height: 1.6;
                margin-bottom: 2rem;
                animation: fadeInUp 0.6s ease-out 0.6s both;
            }

            .no-results-actions {
                animation: fadeInUp 0.6s ease-out 0.8s both;
            }

            .btn-reset-filter {
                background: var(--primary-color-4);
                color: white;
                border: none;
                padding: 0.75rem 1.5rem;
                border-radius: 25px;
                font-weight: 500;
                transition: all 0.3s ease;
                cursor: pointer;
                box-shadow: 0 4px 12px rgba(var(--primary-color-4-rgb), 0.3);
            }

            .btn-reset-filter:hover {
                background: var(--primary-color-5);
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(var(--primary-color-4-rgb), 0.4);
            }

            .btn-reset-filter:active {
                transform: translateY(0);
            }

            /* Animations */
            @keyframes slideInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

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
                    opacity: 1;
                    transform: scale(1);
                }
            }

            /* Mobile Responsive */
            @media (max-width: 768px) {
                .no-results-container {
                    min-height: 250px;
                    padding: 1.5rem 1rem;
                }

                .no-results-icon svg {
                    width: 60px;
                    height: 60px;
                }

                .no-results-title {
                    font-size: 1.25rem;
                }

                .no-results-description {
                    font-size: 0.9rem;
                }

                .btn-reset-filter {
                    padding: 0.6rem 1.2rem;
                    font-size: 0.9rem;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            function resetFilters() {
                // Reset category to "all"
                const allButton = document.querySelector('.btn-category-news[data-category="all"]');
                if (allButton) {
                    allButton.click();
                }

                // Reset search input
                const searchInput = document.getElementById('newsSearchInput');
                if (searchInput) {
                    searchInput.value = '';
                }

                // Trigger filter
                if (typeof filterNews === 'function') {
                    filterNews();
                }
            }
        </script>
    @endpush
@endonce
