<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'Home - Cosmopark')</title>
    <meta name="description" content="@yield('description', 'Cosmopark')">
    <meta name="keywords" content="@yield('keywords', 'Cosmopark,park')">
    <meta name="author" content="Cosmopark">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Home - Cosmopark')">
    <meta property="og:description" content="@yield('description', '')">
    <meta property="og:url" content="{{ url()->full() }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:locale" content="vi_VN">
    <meta property="og:image" content="{{ asset('assets/images/dev/Thumbnail.png') }}">
    <meta property="og:image:secure_url" content="{{ asset('assets/images/dev/Thumbnail.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="@yield('title', 'Home - Cosmopark')">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Home - Cosmopark')">
    <meta name="twitter:description" content="@yield('description', '')">
    <meta name="twitter:image" content="{{ asset('assets/images/dev/Thumbnail.png') }}">
    <meta name="twitter:image:alt" content="@yield('title', 'Home - Cosmopark')">
    <link rel="icon" href="{{ $faviconPath }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ $faviconPath }}" type="image/x-icon">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta name="google-site-verification" content="" />
    @verbatim
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "url": "{{ url('/') }}",
            "logo": "{{ asset('assets/images/dev/Thumbnail.png') }}"
        }
        </script>
    @endverbatim

    @stack('meta')

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->

    {{-- styles --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    @stack('styles')

    {{-- end styles --}}

    <style>
        /* Language Switcher Styles */
        .language-switcher {
            position: relative;
        }

        .language-flag {
            display: inline-block;
            transition: all 0.3s ease;
            border-radius: 4px;
            overflow: hidden;
        }

        .language-flag:hover {
            transform: scale(1.1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .language-flag img {
            width: 24px;
            height: 16px;
            object-fit: cover;
            border-radius: 2px;
        }

        /* Mobile Language Switcher */
        .mobile-language-switcher {
            margin-bottom: 10px;
        }

        .mobile-language-switcher .language-flag {
            display: inline-block;
            margin-right: 10px;
        }

        .mobile-language-switcher .language-flag img {
            width: 28px;
            height: 18px;
        }

        /* Flag icon existing styles */
        .flag-icon {
            width: 24px;
            height: 16px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <header class="header-main" id="header">
        <div class="container mt-4">
            <div class="header-custom">
                <!-- Logo -->
                <div class="d-flex align-items-center">
                    <img src="{{ $logoPath }}" alt="Logo" style="margin-right: 20px;" height="30px">
                    <div class="header-nav d-none d-xl-flex align-items-end">
                        <a href="{{ route('home') }}"
                            class="text-sm fw-medium {{ Route::currentRouteNamed('home') ? 'active' : '' }}">{{ __('home') }}
                        </a>
                        <a href="{{ route('about') }}"
                            class="text-sm fw-medium {{ Route::currentRouteNamed('about') ? 'active' : '' }}">{{ __('About COSMOPark') }}</a>
                        <div class="dropdown">
                            <a href="#" class="text-sm fw-medium dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                {{ __('Projects') }}
                            </a>
                            <ul class="dropdown-menu pe-4">
                                <li><a class="dropdown-item text-dark text-sm fw-medium"
                                        href="{{ route('projects.show', ['slug' => 'cosmopark-eco-industrial-zone']) }}">COSMOPARK
                                        ECO INDUSTRIAL ZONE</a></li>
                                <li><a class="dropdown-item text-dark text-sm fw-medium"
                                        href="{{ route('projects.show', ['slug' => 'cosmopark-convenient']) }}">COSMOPARK
                                        CONVENIENT</a></li>
                                <li><a class="dropdown-item text-dark text-sm fw-medium"
                                        href="{{ route('projects.show', ['slug' => 'cosmo-solar-park']) }}">COSMO SOLAR
                                        PARK</a></li>
                                <li><a class="dropdown-item text-dark text-sm fw-medium"
                                        href="{{ route('projects.show', ['slug' => 'san-golf-resort-villa']) }}">SÂN
                                        GOLF, RESORT & VILLA</a></li>
                                <li><a class="dropdown-item text-dark text-sm fw-medium"
                                        href="{{ route('projects.show', ['slug' => 'cosmopark-smart-ai-city']) }}">COSMOPARK
                                        SMART AI CITY</a></li>
                            </ul>
                        </div>
                        <a href="#" class="text-sm fw-medium">{{ __('Infomation & Gallery') }}</a>
                        <a href="#" class="text-sm fw-medium">{{ __('Contact') }}</a>
                    </div>
                </div>

                <!-- Call & Button -->
                <div class="d-flex align-items-center d-none d-xl-flex">
                    <!-- Language Switcher -->
                    <div class="language-switcher me-3">
                        @php
                            $currentLocale = App\Http\Controllers\LanguageController::getCurrentLocale();
                        @endphp

                        @if($currentLocale === 'vi')
                            <a href="{{ route('language.switch', 'en') }}" class="language-flag" title="Switch to English">
                                <img src="{{ asset('assets/images/en.webp') }}" alt="English Flag" class="flag-icon">
                            </a>
                        @else
                            <a href="{{ route('language.switch', 'vi') }}" class="language-flag" title="Chuyển sang tiếng Việt">
                                <img src="{{ asset('assets/images/vi.webp') }}" alt="Vietnamese Flag" class="flag-icon">
                            </a>
                        @endif
                    </div>

                    <span class="me-4 text-sm fw-medium">{{ __('Call us') }}: <span class="phone-us">01234567890</span></span>
                    <button class="btn btn-lg border rounded-5 bg-white text-md fw-medium">Nhận thông tin</button>
                </div>

                <div class="d-xl-none">
                    <button class="btn border rounded-circle bg-white" id="mobileMenuToggle">
                        <img src="{{ asset('assets/images/svg/menu.svg') }}" alt="">
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Side Menu Overlay -->
    <div class="mobile-side-menu-overlay" id="mobileMenuOverlay"></div>

    <!-- Mobile Side Menu -->
    <div class="mobile-side-menu" id="mobileSideMenu">
        <div class="mobile-menu-header">
            <img src="{{ $logoPath }}" alt="Logo" height="40px">
            <button class="mobile-menu-close" id="mobileMenuClose">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <ul class="mobile-nav-list">
            <li><a href="{{ route('home') }}"
                    class="text-md fw-medium {{ Route::currentRouteNamed('home') ? 'active' : '' }}">{{ __('home') }}</a>
            </li>
            <li><a href="{{ route('about') }}"
                    class="text-md fw-medium {{ Route::currentRouteNamed('about') ? 'active' : '' }}">{{ __('About COSMOPark') }}</a>
            </li>
            <li>
                <button
                    class="btn w-100 text-md fw-medium d-flex justify-content-between align-items-center text-white"
                    type="button" data-bs-toggle="collapse" data-bs-target="#mobileProjectsMenu"
                    aria-expanded="false" aria-controls="mobileProjectsMenu">
                    {{ __('Projects') }}
                    <i class="fas fa-chevron-down ms-2"></i>
                </button>
                <ul class="collapse ps-3" id="mobileProjectsMenu">
                    <li class="mb-0"><a class="text-md fw-medium"
                            href="{{ route('projects.show', ['slug' => 'cosmopark-eco-industrial-zone']) }}">COSMOPARK
                            ECO INDUSTRIAL ZONE</a></li>
                    <li class="mb-0"><a class="text-md fw-medium"
                            href="{{ route('projects.show', ['slug' => 'cosmopark-convenient']) }}">COSMOPARK
                            CONVENIENT</a></li>
                    <li class="mb-0"><a class="text-md fw-medium"
                            href="{{ route('projects.show', ['slug' => 'cosmo-solar-park']) }}">COSMO SOLAR PARK</a>
                    </li>
                    <li class="mb-0"><a class="text-md fw-medium"
                            href="{{ route('projects.show', ['slug' => 'san-golf-resort-villa']) }}">SAN GOLF RESORT
                            VILLA</a></li>
                    <li class="mb-0"><a class="text-md fw-medium"
                            href="{{ route('projects.show', ['slug' => 'cosmopark-smart-ai-city']) }}">COSMOPARL SMART
                            AI CITY</a></li>

                </ul>
            </li>
            <li><a href="#" class="text-md fw-medium">{{ __('Infomation & Gallery') }}</a></li>
            <li><a href="#" class="text-md fw-medium">{{ __('Contact') }}</a></li>
        </ul>

        <div class="mobile-contact-section">
            <div class="mobile-contact-item">
                <!-- Mobile Language Switcher -->
                <div class="mobile-language-switcher">
                    @php
                        $currentLocale = App\Http\Controllers\LanguageController::getCurrentLocale();
                    @endphp

                    @if($currentLocale === 'vi')
                        <a href="{{ route('language.switch', 'en') }}" class="language-flag" title="Switch to English">
                            <img src="{{ asset('assets/images/en.webp') }}" alt="English Flag" class="flag-icon">
                        </a>
                    @else
                        <a href="{{ route('language.switch', 'vi') }}" class="language-flag" title="Chuyển sang tiếng Việt">
                            <img src="{{ asset('assets/images/vi.webp') }}" alt="Vietnamese Flag" class="flag-icon">
                        </a>
                    @endif
                </div>

                <span class="text-sm fw-medium">{{ __('Call us') }}: <span class="phone-us">0968255399</span></span>
            </div>
            <button class="mobile-cta-button">
                Nhận thông tin
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileSideMenu = document.getElementById('mobileSideMenu');
            const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
            const mobileMenuClose = document.getElementById('mobileMenuClose');

            // Open mobile menu
            mobileMenuToggle.addEventListener('click', function() {
                mobileSideMenu.classList.add('active');
                mobileMenuOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            });

            // Close mobile menu
            function closeMobileMenu() {
                mobileSideMenu.classList.remove('active');
                mobileMenuOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            mobileMenuClose.addEventListener('click', closeMobileMenu);
            mobileMenuOverlay.addEventListener('click', closeMobileMenu);

            // Close menu when clicking on navigation links
            const mobileNavLinks = document.querySelectorAll('.mobile-nav-list a');
            mobileNavLinks.forEach(link => {
                link.addEventListener('click', closeMobileMenu);
            });

            // Close menu on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeMobileMenu();
                }
            });
        });
    </script>
