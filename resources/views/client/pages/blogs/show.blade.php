@extends('client.layouts.app')
@section('title', $blog->title . ' - Ichor Shop')
@section('description', Str::limit(strip_tags($blog->content), 160))
@section('keywords', implode(', ', $blog->categories->pluck('name')->toArray()) . ', blog, fashion, style')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/styles_blog.css') }}">
    <style>
        /* Mobile sidebar styles */
        @media (max-width: 991.98px) {
            .blog-sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                width: 300px;
                height: 100vh;
                background: white;
                z-index: 1050;
                transition: left 0.3s ease;
                overflow-y: auto;
                padding: 20px;
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            }

            .blog-sidebar.show {
                left: 0;
            }

            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease, visibility 0.3s ease;
            }

            .sidebar-overlay.show {
                opacity: 1;
                visibility: visible;
            }

            .blog-sidebar-toggle {
                width: 45px;
                height: 45px;
                transition: all 0.3s ease;
            }

            .blog-sidebar-toggle:hover {
                background: var(--primary-dark, #0056b3);
                transform: scale(1.1);
            }

            .blog-sidebar-toggle i {
                font-size: 18px;
            }

            .sidebar-close {
                position: absolute;
                top: 15px;
                right: 15px;
                background: none;
                border: none;
                font-size: 24px;
                color: #666;
                cursor: pointer;
                width: 40px;
                height: 40px;
                transition: all 0.3s ease;
            }

            .sidebar-close:hover {
                background: #f5f5f5;
                color: #333;
            }
        }

        /* Desktop - hide mobile elements */
        @media (min-width: 992px) {
            .blog-sidebar-toggle,
            .sidebar-overlay,
            .sidebar-close {
                display: none !important;
            }
        }

        .blog-detail-header {
            margin-bottom: 2rem;
        }

        .blog-detail-title {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .blog-detail-meta {
            display: flex;
            align-items: baseline;
            justify-content: center;
            font-size: 14px;
            color: #777;
            margin-bottom: 20px;
        }

        .blog-detail-meta span {
            margin-right: 20px;
            display: flex;
            align-items: center;
        }

        .blog-detail-meta i {
            margin-right: 5px;
        }

        .blog-detail-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 2rem;
            object-fit: cover;
        }

        .blog-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
        }

        .blog-content p {
            margin-bottom: 1.5rem;
        }

        .blog-content img {
            max-width: 100%;
            height: auto;
            margin: 1.5rem 0;
            border-radius: 5px;
        }

        .blog-content h2,
        .blog-content h3,
        .blog-content h4 {
            font-weight: 600;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .blog-content ul,
        .blog-content ol {
            margin-bottom: 1.5rem;
            padding-left: 1.5rem;
        }

        .blog-content li {
            margin-bottom: 0.5rem;
        }

        .blog-footer {
            margin-top: 2rem;
            padding-top: 2rem;
        }

        .blog-tags {
            margin-bottom: 1.5rem;
        }

        .blog-tag {
            display: inline-block;
            padding: 4px 12px;
            margin-right: 8px;
            margin-bottom: 8px;
            background-color: #f5f5f5;
            border-radius: 4px;
            font-size: 14px;
            color: #555;
            text-decoration: none;
            transition: all 0.2s;
        }

        .blog-tag:hover {
            background-color: #FFE26E;
            color: #000;
        }

        .share-buttons {
            display: flex;
            align-items: center;
        }

        .share-buttons .btn-share {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 10px;
            color: #fff;
            text-decoration: none;
            transition: transform 0.3s;
        }

        .share-buttons .btn-share:hover {
            transform: translateY(-3px);
        }

        .related-posts {
            margin-top: 4rem;
            padding-top: 2rem;
            border-top: 1px solid #eee;
        }

        .related-post-card {
            transition: transform 0.3s;
            border: none;
        }

        .related-post-card:hover {
            transform: translateY(-5px);
        }

        .related-post-card img {
            height: 180px;
            object-fit: cover;
        }

        .comments-section {
            margin-top: 4rem;
            padding-top: 2rem;
            border-top: 1px solid #eee;
        }

        .comment {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #eee;
        }

        .comment:last-child {
            border-bottom: none;
        }

        .comment-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 15px;
        }

        .comment-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .comment-author {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .comment-date {
            color: #777;
            font-size: 14px;
        }

        .comment-reply-btn {
            font-size: 14px;
            color: #555;
            text-decoration: none;
        }

        .comment-reply-btn:hover {
            color: #000;
        }

        .comment-form {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid #eee;
        }

        .comment-form .form-control {
            border-radius: 0;
            padding: 12px 15px;
        }

        .comment-form textarea {
            min-height: 150px;
        }

        .btn-submit-comment {
            padding: 10px 25px;
            background-color: #FFE26E;
            border: none;
            color: #000;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-submit-comment:hover {
            background-color: #FFD700;
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .blog-detail-title {
                font-size: 1.8rem;
            }

            .blog-detail-meta {
                flex-wrap: wrap;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Breadcrumb Section -->
    <x-breadcrumb :items="[
        ['title' => 'Home', 'url' => route('home')],
        ['title' => 'Blog', 'url' => route('blogs.index')],
        ['title' =>  Str::limit($blog->title, 35), 'url' => ''],
    ]" title="{{ $blog->title }}" />

    <!-- Blog Detail Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Desktop Sidebar -->
                <div class="col-lg-3 d-none d-lg-block">
                    @include('client.pages.blogs._sidebar')
                </div>
                
                <!-- Blog Content -->
                <div class="col-lg-9 col-12">
                    <!-- Mobile Sidebar Toggle Button -->
                    <button
                        class="blog-sidebar-toggle d-lg-none btn btn-pry rounded-circle position-fixed bottom-0 start-0 m-4"
                        id="blogSidebarToggle" style="z-index: 1000;">
                        <img src="{{ asset('assets/images/svg/filter-light.svg') }}" alt="">
                    </button>

                    <!-- Blog Header -->
                    <div class="blog-detail-header">
                        <div class="blog-tags text-center">
                            @foreach ($blog->categories as $category)
                                <a href="{{ route('blogs.category', $category->slug) }}"
                                    class="fs-6 badge rounded-pill text-bg-light me-2 text-decoration-none">{{ $category->name }}</a>
                            @endforeach
                        </div>
                        <h2 class="blog-detail-title text-center">{{ $blog->title }}</h2>
                        <div class="blog-detail-meta text-center">
                            <div class="blog-meta d-flex">
                                <span class="me-0">{{ $blog->created_at->format('F d, Y') }}</span>
                                <span class="mx-2">-</span>
                                <span>By <span class="fw-semibold color-primary">{{ $blog->author->full_name }}</span></span>
                            </div>

                            <span><i class="far fa-eye"></i> {{ $blog->views }} Views</span>
                        </div>
                    </div>

                    <!-- Blog Featured Image -->
                    <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}" class="img-fluid">

                    <!-- Blog Content -->
                    <div class="blog-content">
                        {!! $blog->content !!}
                    </div>

                    <!-- Blog Footer: Tags and Share -->
                    <div class="blog-footer">
                        <div class="row align-items-center">
                            <div class="col-md-8">

                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="d-flex align-items-center justify-content-end">
                                    <span class="me-2 fw-bold">Share:</span>
                                    <div class="share-buttons">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                            target="_blank" class="btn-share btn-facebook">
                                            <img src="{{ asset('assets/images/svg/facebook.svg') }}" alt="">
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}"
                                            target="_blank" class="btn-share btn-twitter">
                                            <img src="{{ asset('assets/images/svg/twitter.svg') }}" alt="">
                                        </a>
                                        <a href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}&media={{ urlencode($blog->image_url) }}&description={{ urlencode($blog->title) }}"
                                            target="_blank" class="btn-share btn-pinterest">
                                            <img src="{{ asset('assets/images/svg/pinterest.svg') }}" alt="">
                                        </a>
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                                            target="_blank" class="btn-share btn-linkedin">
                                            <img src="{{ asset('assets/images/svg/in.svg') }}" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Posts -->
                    @if ($relatedPosts && $relatedPosts->count() > 0)
                        <div class="related-posts">
                            <h3 class="mb-4">You may also like this</h3>
                            <div class="row">
                                @foreach ($relatedPosts as $relatedPost)
                                    <div class="col-md-6 mb-4">
                                        <div class="card related-post-card">
                                            <img src="{{ Storage::url($relatedPost->image) }}" class="card-img-top rounded-3"
                                                alt="{{ $relatedPost->title }}">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-2">
                                                    @foreach ($relatedPost->categories as $category)
                                                        <span class="fs-6 badge rounded-pill text-bg-light me-2 text-decoration-none">{{ $category->name }}</span>
                                                    @endforeach
                                                </div>
                                                <h5 class="card-title">
                                                    <a href="{{ route('blogs.show', $relatedPost->slug) }}"
                                                        class="text-decoration-none text-dark">{{ $relatedPost->title }}</a>
                                                </h5>
                                                <div class="blog-meta">
                                                    <span><i class="far fa-calendar"></i>
                                                        {{ $relatedPost->created_at->format('M d, Y') }}</span>
                                                </div>
                                                <a href="{{ route('blogs.show', $relatedPost->slug) }}"
                                                    class="btn btn-pry mt-2">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile Sidebar -->
    <div class="blog-sidebar d-lg-none" id="blogSidebar">
        <button class="sidebar-close" id="sidebarClose">
            <i class="fas fa-times"></i>
        </button>
        @include('client.pages.blogs._sidebar')
    </div>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay d-lg-none" id="sidebarOverlay"></div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle functionality
            const sidebarToggle = document.getElementById('blogSidebarToggle');
            const sidebar = document.getElementById('blogSidebar');
            const sidebarClose = document.getElementById('sidebarClose');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            // Open sidebar
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.add('show');
                    sidebarOverlay.classList.add('show');
                    document.body.style.overflow = 'hidden'; // Prevent body scroll
                });
            }

            // Close sidebar
            function closeSidebar() {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
                document.body.style.overflow = ''; // Restore body scroll
            }

            if (sidebarClose) {
                sidebarClose.addEventListener('click', closeSidebar);
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebar);
            }

            // Close sidebar when clicking on sidebar links (for better UX)
            sidebar.addEventListener('click', function(e) {
                if (e.target.tagName === 'A') {
                    setTimeout(closeSidebar, 200); // Small delay for smooth transition
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    closeSidebar();
                }
            });

            // Handle escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebar.classList.contains('show')) {
                    closeSidebar();
                }
            });

            // Social share buttons
            const shareButtons = document.querySelectorAll('.btn-share');
            shareButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.open(this.href, 'share-window', 'width=650, height=450');
                });
            });
        });
    </script>
@endpush
