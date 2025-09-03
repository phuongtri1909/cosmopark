@extends('client.layouts.app')
@section('title', $blog->title . ' - Cosmopark')
@section('description', Str::limit(strip_tags($blog->content), 160))
@section('keywords', $blog->category ? $blog->category->name : 'blog' . ', Cosmopark')

@section('content')
    <section class="pt-5">
        <div class="container py-5 mt-4">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-9 col-12">
                    <div class="d-flex align-items-start flex-column align-items-md-center flex-md-row">
                        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center flex-grow-1">
                            <h1 class="text-1lg-2 text-black fw-bold me-3 mb-2 mb-md-0">{{ $blog->title }}</h1>
                            @if($blog->category)
                                <span class="rounded-5 color-text-secondary bg-primary-11 px-3 py-2 flex-shrink-0">{{ $blog->category->name }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-3 mt-md-4 d-flex justify-content-between align-items-start align-items-md-center flex-column flex-md-row">
                        <div class="d-flex">
                            <img class="avatar me-3" src="{{ $blog->author && $blog->author->avatar ? asset('storage/' . $blog->author->avatar) : asset('assets/images/default/avatar_default.jpg') }}"
                                alt="avatar">
                            <div class="d-flex flex-column">
                                <span class="color-primary-8 text-md fw-semibold">
                                    {{ $blog->author ? $blog->author->name : ($blog->author_name ?: 'Admin') }}
                                </span>
                                <span class="color-text-secondary text-sm">{{ $blog->getReadingTime() }} phút đọc</span>
                            </div>
                        </div>
                        <div class="mt-3 mt-md-0">
                            <span class="rounded-5 color-text-secondary bg-primary-12 px-3 py-1 me-2 text-xs-1">
                                <img src="{{ asset('assets/images/svg/clock.svg') }}" alt="clock">
                                {{ $blog->created_at->diffForHumans() }}
                            </span>
                            <span class="rounded-5 color-text-secondary bg-primary-12 px-3 py-1 text-xs-1">
                                <img src="{{ asset('assets/images/svg/eye.svg') }}" alt="eye">
                                {{ $blog->views }} lượt xem
                            </span>
                        </div>
                    </div>

                    <!-- Mobile Table of Contents -->
                    <div class="d-block d-lg-none mt-4">
                        <h2 class="text-1lg-2 fw-bold color-primary-4 text-center">Mục lục</h2>
                        <div class="toc rounded p-3" id="mobileTableOfContents">
                            <!-- Dynamic TOC will be generated here -->
                        </div>
                    </div>

                    <div class="mt-4">
                        @if($blog->image)
                            <img class="img-fluid rounded-4" src="{{ asset('storage/' . $blog->image) }}"
                                alt="{{ $blog->title }}">
                        @endif

                        <div class="content-news mt-4" id="blogContent">
                            {!! $blog->content !!}
                        </div>
                    </div>
                </div>

                <!-- Desktop Sidebar -->
                <div class="col-lg-3 col-12 d-none d-lg-block">
                    <h2 class="text-1lg-2 fw-bold color-primary-4 text-center text-md-start">Mục lục</h2>

                    <div class="toc rounded p-3" id="tableOfContents">
                        <!-- Dynamic TOC will be generated here -->
                    </div>

                    <!-- Related Posts -->
                    @if($relatedPosts->count() > 0)
                        <div class="mt-4">
                            <h3 class="text-lg fw-bold color-primary-4 text-center text-md-start">Bài viết liên quan</h3>
                            <div class="related-posts mt-3">
                                @foreach($relatedPosts->take(3) as $relatedPost)
                                    <div class="related-post-item mb-3">
                                        <a href="{{ route('news.show', $relatedPost->slug) }}" class="d-flex text-decoration-none">
                                            @if($relatedPost->image)
                                                <img src="{{ asset('storage/' . $relatedPost->image) }}"
                                                     alt="{{ $relatedPost->title }}"
                                                     class="related-post-image me-3">
                                            @endif
                                            <div class="related-post-content">
                                                <h6 class="related-post-title color-primary-8 mb-1">
                                                    {{ Str::limit($relatedPost->title, 60) }}
                                                </h6>
                                                <small class="color-text-secondary">
                                                    {{ $relatedPost->created_at->format('d/m/Y') }}
                                                </small>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Mobile Related Posts Section -->
            @if($relatedPosts->count() > 0)
                <div class="d-block d-lg-none mt-5">
                    <h2 class="text-1lg-2 fw-bold color-primary-4 text-center">Bài viết liên quan</h2>
                    <div class="row gx-1 g-3 mt-4">
                        @foreach($relatedPosts as $relatedPost)
                            <div class="col-12 col-md-6">
                                <x-card-news :news="$relatedPost" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Desktop Related Posts Section -->
            @if($relatedPosts->count() > 0)
                <div class="d-none d-lg-block mt-5">
                    <h2 class="text-1lg-2 fw-bold color-primary-4 text-center text-md-start">Các bài viết khác</h2>
                    <div class="row gx-1 g-3 mt-4">
                        @foreach($relatedPosts as $relatedPost)
                            <div class="col-12 col-md-6 col-lg-4">
                                <x-card-news :news="$relatedPost" />
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        .toc-item {
            margin-bottom: 0.75rem;
            position: relative;
        }

        .toc-item a {
            text-decoration: none;
            color: var(--color-text-secondary);
            display: block;
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            transition: all 0.2s;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .toc-item.active a {
            background: #f1f3f5;
            color: var( --primary-color-4);
            font-weight: 600;
        }

        .toc-item.active a::after {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: var( --primary-color-4);
            border-radius: 2px;
        }

        /* Fix CKEditor content overflow */
        .content-news {
            max-width: 100%;
            overflow-x: hidden;
        }

        .content-news img {
            max-width: 100%;
            height: auto;
        }

        .content-news table {
            max-width: 100%;
            overflow-x: auto;
            display: block;
        }

        .content-news iframe {
            max-width: 100%;
        }

        /* Related Posts Styling */

        .related-post-item {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .related-post-item:last-child {
            margin-bottom: 0;
        }

        .related-post-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            border-color: var(--primary-color-4);
        }

        .related-post-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .related-post-item:hover .related-post-image {
            transform: scale(1.05);
        }

        .related-post-content {
            flex: 1;
            min-width: 0;
        }

        .related-post-title {
            font-size: 0.95rem;
            line-height: 1.4;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .related-post-item:hover .related-post-title {
            color: var(--primary-color-4) !important;
        }

        .related-post-date {
            font-size: 0.8rem;
            color: #6c757d;
        }

        /* Animation for related posts */
        .related-post-item {
            animation: slideInRight 0.6s ease-out;
            animation-fill-mode: both;
        }

        .related-post-item:nth-child(1) { animation-delay: 0.1s; }
        .related-post-item:nth-child(2) { animation-delay: 0.2s; }
        .related-post-item:nth-child(3) { animation-delay: 0.3s; }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .related-posts {
                padding: 1rem;
            }

            .related-post-image {
                width: 60px;
                height: 60px;
            }

            .related-post-item {
                padding: 0.75rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            generateTableOfContents();
            setupTOCNavigation();
            setupScrollSpy();
        });

        // Generate table of contents from content
        function generateTableOfContents() {
            const content = document.getElementById('blogContent');
            const desktopToc = document.getElementById('tableOfContents');
            const mobileToc = document.getElementById('mobileTableOfContents');

            if (!content) return;

            const headings = content.querySelectorAll('h1, h2, h3, h4, h5, h6');

            if (headings.length === 0) {
                const noTocMessage = '<p class="text-muted text-center">Không có mục lục</p>';
                if (desktopToc) desktopToc.innerHTML = noTocMessage;
                if (mobileToc) mobileToc.innerHTML = noTocMessage;
                return;
            }

            let tocHTML = '';
            headings.forEach((heading, index) => {
                const level = parseInt(heading.tagName.charAt(1));
                const text = heading.textContent.trim();
                const id = `heading-${index}`;

                // Add ID to heading for navigation
                heading.id = id;

                const paddingClass = `toc-level-${level}`;
                tocHTML += `
                    <div class="toc-item ${paddingClass}">
                        <a href="#${id}" data-heading-id="${id}">${text}</a>
                    </div>
                `;
            });

            // Update both TOC containers
            if (desktopToc) desktopToc.innerHTML = tocHTML;
            if (mobileToc) mobileToc.innerHTML = tocHTML;
        }

        // Setup TOC navigation with smooth scrolling
        function setupTOCNavigation() {
            const tocLinks = document.querySelectorAll('#tableOfContents a, #mobileTableOfContents a');

            tocLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);

                    if (targetElement) {
                        // Calculate offset for fixed header if any
                        const headerOffset = 100;
                        const elementPosition = targetElement.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });

                        // Update active TOC item
                        updateActiveTOCItem(targetId);
                    }
                });
            });
        }

        // Setup scroll spy to highlight current section
        function setupScrollSpy() {
            const headings = document.querySelectorAll('#blogContent h1, #blogContent h2, #blogContent h3, #blogContent h4, #blogContent h5, #blogContent h6');

            if (headings.length === 0) return;

            const observerOptions = {
                root: null,
                rootMargin: '-20% 0px -80% 0px',
                threshold: 0
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        updateActiveTOCItem(entry.target.id);
                    }
                });
            }, observerOptions);

            headings.forEach(heading => {
                if (heading.id) {
                    observer.observe(heading);
                }
            });
        }

        // Update active TOC item
        function updateActiveTOCItem(activeId) {
            const tocItems = document.querySelectorAll('#tableOfContents .toc-item, #mobileTableOfContents .toc-item');

            tocItems.forEach(item => {
                item.classList.remove('active');
                const link = item.querySelector('a');
                if (link && link.getAttribute('href') === `#${activeId}`) {
                    item.classList.add('active');
                }
            });
        }
    </script>
@endpush

