@props(['images' => []])

<div class="news-new pb-5">
    <div class="container d-flex justify-content-between align-items-center flex-column flex-md-row">
        <h2 class="text-xl-3 color-primary-4 fw-bold">
            TIN TỨC MỚI NHẤT
        </h2>

        <div class="d-flex align-items-center gap-2">
            <button class="color-primary-8 rounded-5 btn-category-news text-md px-3 py-2 me-2 animate-on-scroll">
                Tất cả
            </button>
            <button class="color-primary-8 rounded-5 btn-category-news text-md px-3 py-2 me-2 animate-on-scroll">
                Tin tức
            </button>
            <button class="color-primary-8 rounded-5 btn-category-news text-md px-3 py-2 me-2 animate-on-scroll">
                Sự kiện
            </button>

            <div class="position-relative search-box">
                <span class="position-absolute top-50 start-0 translate-middle-y ps-3">
                    <img src="{{ asset('assets/images/svg/search.svg') }}" alt="Search" width="16">
                </span>
                <input type="text" class="form-control rounded-pill ps-5" placeholder="Tìm kiếm">
            </div>
        </div>
    </div>

    <div class="container mt-5">
        @php
            $images = 9;
        @endphp
        <div class="row gx-1 g-3">
            @for ($index = 0; $index < $images; $index++)
                <div class="col-12 col-md-6 col-lg-4">
                    <x-card-news />
                </div>
            @endfor
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
            }

            .btn-category-news:hover {
                background: var(--primary-color-4);
                color: #FFF !important;
            }

            .btn-category-news:hover img {
                filter: invert(1);
            }

            .search-box input {
                border: 1px solid var(--primary-color-5);
                width: 100%;
                padding-left: 40px;
            }

            .search-box input:hover {
                border-color: var(--primary-color-4);
            }
        </style>
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/js/index-slider.js') }}"></script>
    @endpush
@endonce
