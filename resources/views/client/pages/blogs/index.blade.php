@extends('client.layouts.app')
@section('title', 'Blog - Ichor Shop')
@section('description', 'Explore the latest articles on fashion, style and stay up to date on new trends.')
@section('keywords', 'blog, fashion, style, articles, tips, trends')

@push('styles')
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
    </style>
@endpush

@section('content')
    <!-- Breadcrumb Section -->
    <x-breadcrumb :items="[['title' => 'Home', 'url' => route('home')], ['title' => 'Blog', 'url' => '']]" title="Blog" />

    <!-- Blog Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
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

                    <div class="row">
                        @forelse ($blogs as $blog)
                            <div class="col-md-6 mb-4">
                                <div class="">
                                    <img src="{{ Storage::url($blog->image) }}" class="img-blog" alt="{{ $blog->title }}">
                                    <div class="">
                                        <div class="d-flex align-items-center my-3">
                                            @foreach ($blog->categories as $category)
                                                <a href="{{ route('blogs.category', $category->slug) }}"
                                                    class="fs-6 badge rounded-pill text-bg-light me-2 text-decoration-none">{{ $category->name }}</a>
                                            @endforeach
                                        </div>
                                        <h5 class="card-title mb-3">
                                            <a href="{{ route('blogs.show', $blog->slug) }}"
                                                class="text-decoration-none text-dark fw-bold">{{ $blog->title }}</a>
                                        </h5>
                                        <div class="blog-meta">
                                            <span class="me-0">{{ $blog->created_at->format('F d, Y') }}</span>
                                            -
                                            <span>By <span
                                                    class="fw-semibold color-primary">{{ $blog->author->full_name }}</span></span>
                                        </div>
                                        <p class="card-text">{!! Str::limit(strip_tags($blog->content), 200) !!}</p>

                                        <a href="{{ route('blogs.show', $blog->slug) }}"
                                            class="btn btn-pry rounded-3 mt-3 px-3">Read
                                            More</a>
                                    </div>

                                    <hr class="mt-3">

                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">
                                    No blog posts found.
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $blogs->links('components.paginate') }}
                    </div>
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
        });
    </script>
@endpush
