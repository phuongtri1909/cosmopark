<div class="read-recently feature-gradient-bg feature-rounded-top">
    <div class="p-100">
        <div class="card-news-read row gx-5 mt-2 mt-md-0">
            <div class="col-12 col-md-5">
                <img class="rectangle rounded-4"
                    src="{{ $latestPost && $latestPost->image ? Storage::url($latestPost->image) : asset('assets/images/dev/hero-slider-1.jpg') }}" />
            </div>
            <div class="card-news col-12 col-md-7 py-5">
                <div class="div">
                    <div class="bg-primary-1 rounded-5 py-2 px-3">
                        <div class="text-xs text-white">
                            {{ $latestPost && $latestPost->category ? $latestPost->category->name : 'Danh mục' }}
                        </div>
                    </div>
                    <span class="line"></span>
                    <div class="color-text-secondary text-xs-1">
                        @if ($latestPost)
                            {{ $latestPost->created_at->locale(app()->getLocale())->translatedFormat('d F Y') }}
                        @endif
                    </div>
                </div>
                <div class="card-news-2">
                    <p class="color-primary-8 text-1lg-3 fw-bold">
                        {{ $latestPost ? $latestPost->title : '' }}
                    </p>
                </div>
                <p class="text-sm-1 color-text-secondary">
                    {{ cleanDescription($latestPost->content, 300) }}
                </p>
                @if ($latestPost)
                    <a href="{{ route('news.show', $latestPost->slug) }}"
                        class="fw-semibold text-decoration-none continue-reading">Tiếp tục đọc</a>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        /* Feature Form Utility Classes */
        .feature-gradient-bg {
            background-color: white;
        }

        .feature-rounded-top {
            position: relative;
            border-radius: 50px 50px 0 0;
            z-index: 1;
        }

        .read-recently {
            margin-top: -50px;
        }

        .card-news-read {
            min-height: 364px;
        }

        .card-news-read .rectangle {
            position: relative;
            align-self: stretch;
            width: 100%;
            min-height: 225px;
            height: 100%;
            object-fit: cover;
        }

        .card-news-read .div {
            display: flex;
            align-items: center;
            gap: 12px;
            align-self: stretch;
            width: 100%;
            position: relative;
            flex: 0 0 auto;
        }

        .card-news-read .line {
            position: relative;
            flex: 1;
            flex-grow: 1;
            height: 2px;
            width: 59px;
            background: #c6c6c6;
        }

        .continue-reading {
            color: var(--primary-color-8);
            border-bottom: 2px solid var(--color-border);
        }
    </style>
@endpush

@push('scripts')
@endpush
