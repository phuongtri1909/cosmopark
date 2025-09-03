<footer class="footer-section">
    <div class="footer-background" style="background-image: url('{{ asset('assets/images/dev/image-footer.jpg') }}');">
        <div class="container footer-content-wrapper position-relative">
            <div class="footer-image-top">
                <img src="{{ asset('assets/images/dev/cosmopark-ft-sm.png') }}" alt="" class="d-lg-none">
                <img src="{{ asset('assets/images/dev/cosmopark-ft.png') }}" alt="" class="d-none d-lg-block">
            </div>
            <div class="footer-content rounded-5 p-3 p-md-5 position-relative">

                <div class="row">
                    <!-- Logo Section -->
                    <div class="col-12 col-lg-6 col-xl-4 mt-0 mb-3">
                        <div class="footer-logo-section">
                            <img src="{{ asset('assets/images/logo/logo-color.png') }}" alt="Cosmopark Logo"
                                class="footer-logo animate-on-scroll">

                            <div class="footer-address animate-on-scroll d-flex align-items-start">

                                <img class="me-2" src="{{ asset('assets/images/svg/map.svg') }}" alt="">
                                <p class="color-text-secondary text-sm-1 text-start mb-0">
                                    Ấp Thanh Sơn, xã Đức Huệ, Tỉnh Tây Ninh, Việt Nam
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Trang chủ Section -->
                    <div class="col-12 col-lg-6 col-xl-4">
                        <div class="footer-address animate-on-scroll d-flex align-items-start">
                            <div class="me-4"></div>
                            <div class="footer-menu animate-on-scroll d-flex flex-column ms-1">
                                <a class="color-text-secondary text-sm-1 text-decoration-none mb-3 mb-md-4"
                                    href="{{ route('home') }}">{{ __('home') }}</a>
                                <a class="color-text-secondary text-sm-1 text-decoration-none mb-3 mb-md-4"
                                    href="{{ route('about') }}">{{ __('About COSMOPark') }}</a>
                                <a class="color-text-secondary text-sm-1 text-decoration-none mb-3 mb-md-4"
                                    href="">{{ __('Projects') }}</a>
                                <a class="color-text-secondary text-sm-1 text-decoration-none mb-3 mb-md-4"
                                    href="{{ route('gallery') }}">{{ __('Infomation & Gallery') }}</a>
                                <a class="color-text-secondary text-sm-1 text-decoration-none mb-3 mb-md-4"
                                    href="{{ route('contact') }}">{{ __('Contact-1') }}</a>
                            </div>
                        </div>

                    </div>

                    <!-- Company Info Section -->
                    <div class="col-12 col-xl-4">
                        <div class="footer-company animate-on-scroll">
                            <h5 class="text-md-1 text-start mb-3 mb-md-4 fw-bold">Văn phòng kinh doanh TP.HCM</h5>
                            <div class="footer-address animate-on-scroll d-flex align-items-start mb-3">

                                <img class="me-2" src="{{ asset('assets/images/svg/map.svg') }}" alt="">
                                <p class="color-text-secondary text-sm-1 text-start mb-0">
                                    600 Đường Điện Biên Phủ, Phường Thạnh Mỹ Tây, TP. Hồ Chí Minh, Việt Nam.
                                    (Địa chỉ cũ: 600 Đường Điện Biên Phủ, Phường 22, Quận Bình Thạnh, TP. Hồ Chí
                                    Minh, Việt Nam)
                                </p>
                            </div>
                            <div class="footer-address animate-on-scroll d-flex align-items-start mb-3">

                                <img class="me-2" src="{{ asset('assets/images/svg/phone.svg') }}" alt="">
                                <p class="color-text-secondary text-sm-1 text-start mb-0 ">
                                    {{ __('Contact-1') }}: <a class="text-decoration-none color-text-secondary"
                                        href="tel:0968255399">0968.255.399</a>
                                </p>
                            </div>
                            <div class="footer-address animate-on-scroll d-flex align-items-start mb-3">

                                <img class="me-2" src="{{ asset('assets/images/svg/mail.svg') }}" alt="">
                                <p class="color-text-secondary text-sm-1 text-start mb-0 text-decoration-none">
                                    Email: <a class="color-text-secondary"
                                        href="mailto:info@cosmopark.vn">info@cosmopark.vn</a>
                                </p>
                            </div>
                        </div>
                        <div class="footer-social animate-on-scroll text-start">
                            <div class="social-icons animate-on-scroll">
                                @forelse($socials as $social)
                                    <a href="{{ $social->url }}" target="_blank" class="social-icon"
                                        aria-label="{{ $social->name }}">
                                        @if (strpos($social->icon, 'custom-') === 0)
                                            <span class="{{ $social->icon }}"></span>
                                        @else
                                            <i class="{{ $social->icon }}"></i>
                                        @endif
                                    </a>
                                @empty
                                    <a href="https://facebook.com" target="_blank" class="social-icon"
                                        aria-label="Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="mailto:contact@pinknovel.com" target="_blank" class="social-icon"
                                        aria-label="Email">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                @endforelse
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
</footer>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
@stack('scripts')

<script>
    // Intersection Observer for footer animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const footerObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.visibility = 'visible';
            }
        });
    }, observerOptions);

    // Observe footer elements
    document.addEventListener('DOMContentLoaded', function() {
        const footerElements = document.querySelectorAll('.footer-content .animate__animated');
        footerElements.forEach(element => {
            element.style.visibility = 'hidden';
            footerObserver.observe(element);
        });

        // Add smooth scroll for footer links
        document.querySelectorAll('.footer-links a').forEach(link => {
            link.addEventListener('click', function(e) {
                // Add click animation
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 150);
            });
        });
    });
</script>

<style>
    /* Footer Animations */
    .footer-section .footer-logo.animate-on-scroll,
    .footer-section .footer-address.animate-on-scroll,
    .footer-section .footer-menu.animate-on-scroll,
    .footer-section .footer-company.animate-on-scroll,
    .footer-section .footer-social.animate-on-scroll {
        opacity: 0;
    }

    .footer-section .animate-on-scroll.animated {
        opacity: 1;
        animation: footerFadeInUp 0.7s both;
    }

    .footer-section .footer-logo.animate-on-scroll.animated {
        animation-delay: 0.1s;
    }

    .footer-section .footer-address.animate-on-scroll.animated {
        animation-delay: 0.2s;
    }

    .footer-section .footer-menu.animate-on-scroll.animated {
        animation-delay: 0.3s;
    }

    .footer-section .footer-company.animate-on-scroll.animated {
        animation-delay: 0.4s;
    }

    .footer-section .footer-social.animate-on-scroll.animated {
        animation-delay: 0.5s;
    }

    @keyframes footerFadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }
</style>
</body>

</html>
