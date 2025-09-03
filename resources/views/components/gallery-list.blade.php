<div class="gallery-list feature-gradient-bg feature-rounded-top">
    <div class="p-100">
        <div class="card-gallery-list">
            <button class="btn-category-project rounded-5 active">
                COSMOPARK ECO-INDUSTRIAL ZONE
            </button>
            <button class="btn-category-project rounded-5">
                COSMOPARK ECO-INDUSTRIAL ZONE
            </button>
            <button class="btn-category-project rounded-5">
                COSMOPARK ECO-INDUSTRIAL ZONE
            </button>
            <button class="btn-category-project rounded-5">
                COSMOPARK ECO-INDUSTRIAL ZONE
            </button>
            <button class="btn-category-project rounded-5">
                COSMOPARK ECO-INDUSTRIAL ZONE
            </button>
        </div>

        <div class="gallery-list-content">
            <div class="row g-4 mt-4">
                <div class="col-12 col-lg-6 order-1">
                    <div class="position-relative h-100">
                        <img src="{{ $main ?? asset('assets/images/dev/image-1.jpg') }}"
                            class="img-fluid w-100 rounded-4 h-100 object-fit-cover animate-on-scroll main-image"
                            style="min-height:258px;">
                        
                    </div>
                </div>
                <div class="col-12 col-lg-6 h-100 order-2">
                    <div class="row g-4 sub-images-container">
                        @foreach ($images as $img)
                            <div class="col-6">
                                <img src="{{ $img }}"
                                    class="img-fluid w-100 rounded-4 object-fit-cover animate-on-scroll sub-image"
                                    style="aspect-ratio: 4/3;">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-4">
                <div class="col-12 col-lg-6 order-2">
                    <div class="position-relative h-100">
                        <img src="{{ $main ?? asset('assets/images/dev/image-1.jpg') }}"
                            class="img-fluid w-100 rounded-4 h-100 object-fit-cover animate-on-scroll main-image"
                            style="min-height:258px;">
                        
                    </div>
                </div>
                <div class="col-12 col-lg-6 h-100 order-1">
                    <div class="row g-4 sub-images-container">
                        @foreach ($images as $img)
                            <div class="col-6">
                                <img src="{{ $img }}"
                                    class="img-fluid w-100 rounded-4 object-fit-cover animate-on-scroll sub-image"
                                    style="aspect-ratio: 4/3;">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
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

        /* Tablet Responsive */
        @media (max-width: 768px) {
            .card-gallery-list {
                gap: 15px;
                max-width: 600px;
            }

            .btn-category-project {
                flex: 0 0 250px;
                width: 250px;
                height: 45px;
                font-size: 0.875rem;
                padding: 10px 16px;
            }

            /* Reset margin cho button 4 và 5 trên tablet */
            .btn-category-project:nth-child(4),
            .btn-category-project:nth-child(5) {
                margin-left: 0;
                margin-right: 0;
            }
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

            /* Reset margin cho button 4 và 5 trên mobile */
            .btn-category-project:nth-child(4),
            .btn-category-project:nth-child(5) {
                margin-left: 0;
                margin-right: 0;
            }
        }
    </style>
@endpush

@push('scripts')
@endpush
