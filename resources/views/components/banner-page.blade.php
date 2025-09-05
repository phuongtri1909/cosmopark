<div class="banner-page position-relative overflow-hidden bg-banner-page d-flex " 
     @if(isset($bannerPage) && $bannerPage && $bannerPage->image)
         style="background-image: url('{{ $bannerPage->image_url }}');"
     @endif>
    <div class="container position-relative z-2 py-5 mt-5 d-flex align-items-center justify-content-center {{ $alignItemCenter == 'true' ? 'align-items-md-start' : 'd-md-block' }}">
        <h1 class="fw-bold color-primary-4 mt-4 mb-2 animate-on-scroll banner-title text-2xl-4">
            @if(isset($bannerPage) && $bannerPage && $bannerPage->getTranslation('title', app()->getLocale()))
                {{ $bannerPage->getTranslation('title', app()->getLocale()) }}
            @else
                {{ __($title) }}
            @endif
        </h1>
    </div>
</div>

@push('styles')
    <style>
        .banner-page {
            padding-bottom: 60px;
        }

        .bg-banner-page {
            background: url('/assets/images/dev/hero-slider.jpg') center/cover no-repeat;
            min-height: 700px;
        }

        .banner-page-overlay {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.92) 0%, rgba(255, 255, 255, 0.85) 100%);
            z-index: 1;
            pointer-events: none;
        }

        @media (max-width: 991.98px) {
            .bg-banner-page {
                min-height: 500px;
            }

            .banner-page {
                padding-bottom: 30px;
            }
        }

        .banner-page .banner-title {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.7s cubic-bezier(.39, .575, .565, 1);
        }

        .banner-page .banner-title.animated {
            opacity: 1;
            transform: none;
        }
    </style>
@endpush

@push('scripts')
    <script></script>
@endpush
