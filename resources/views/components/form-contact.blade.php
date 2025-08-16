<div class="contact-wrapper">
    <div class="contact-gradient-bg contact-rounded-top">
        <div class="col-12">
            <div class="p-100">
                <div class="align-items-start">
                    <!-- Left Column - Form Header & Form -->
                    <div class="row">
                        <div class="col-12 col-md-5">
                            <!-- Header -->
                            <div class="mb-4 text-center text-md-start">
                                <div class="contact-badge badge rounded-pill mb-3 animate-on-scroll">
                                    Liên hệ
                                </div>
                                <h2 class="contact-title mb-0 animate-on-scroll">NHẬN THÔNG TIN</h2>
                            </div>
                        </div>

                        <div class="col-12 col-md-7">
                            <!-- Form -->
                            <form id="contactForm" action="" method="POST">
                                @csrf
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <input type="text" name="full_name"
                                            class="form-control contact-input rounded-pill animate-on-scroll" placeholder="Họ và tên"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="tel" name="phone"
                                            class="form-control contact-input rounded-pill animate-on-scroll" placeholder="Số điện thoại"
                                            required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <input type="email" name="email" class="form-control contact-input rounded-pill animate-on-scroll"
                                        placeholder="Email liên hệ">
                                </div>

                                <div class="text-center text-md-start">
                                    <button type="submit" class="btn submit-btn-custom rounded-pill p-2 animate-on-scroll">
                                        <span class="submit-text me-2">Xác nhận</span>
                                        <div class="submit-icon">
                                            <img class="arrow-icon-main"
                                                src="{{ asset('assets/images/svg/arrow-left.svg') }}" />
                                        </div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Right Column - Image -->
                    <div class="mt-4">
                        <img src="{{ asset('assets/images/dev/khucongnghiep.jpg') }}" alt="Cosmo Park Project"
                            class=" img-contact">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    /* Contact Form Utility Classes */
    .contact-gradient-bg {
        background: linear-gradient(0deg, var(--color-white) 0%, var(--color-bg-light) 100%);
        background-color: var(--color-bg-light);
    }


    .contact-wrapper {
        position: relative;
        overflow-x: hidden;
    }

    .contact-wrapper::before {
        content: "";
        position: absolute;
        top: 20px;
        left: -14px;
        right: -14px;
        height: 220px;
        background: #2E7D32;
        border-radius: 110px 110px 0 0;
        z-index: 0;
    }

    .contact-rounded-top {
        position: relative;
        background: #F5F7FB;
        border-radius: 100px 100px 50px 50px;
        margin-top: 40px;
        z-index: 1;
    }

    .contact-badge {
        border: 1px solid var(--color-border);
        background-color: transparent;
        color: var(--color-green);
        font-size: var(--font-size-sm);
        font-weight: var(--font-weight-normal);
        padding: var(--spacing-md) var(--spacing-xl);
    }

    .contact-title {
        color: var(--color-primary);
        font-size: 30px;
        font-weight: var(--font-weight-bold);
        letter-spacing: -0.4px;
        line-height: var(--line-height);
    }

    .contact-input {
        background-color: var(--color-light-blue) !important;
        border: none !important;
        color: var(--color-text-secondary);
        font-size: var(--font-size-sm);
        font-weight: var(--font-weight-normal);
        line-height: var(--line-height);
        padding: var(--spacing-lg) var(--spacing-xl) !important;
    }

    .contact-input::placeholder {
        color: var(--color-text-secondary);
    }

    .contact-input:focus {
        background-color: var(--color-white) !important;
        box-shadow: 0 0 0 2px var(--color-primary) !important;
    }

    .img-contact {
        height: 195px;
        width: 100%;
        object-fit: cover;
        border-radius: 2rem;
    }

    /* Animation: Fade in up */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translate3d(0, 40px, 0);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }

    /* Animation: Scale in */
    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.8);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Animation: Slide in from left */
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-60px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Animation cho form-contact */
    .contact-wrapper .contact-badge {
        opacity: 0;
        animation: contactBadgeIn 0.7s 0.1s cubic-bezier(.39, .575, .565, 1) both;
    }

    @keyframes contactBadgeIn {
        from {
            opacity: 0;
            transform: scale(0.8);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .contact-wrapper .contact-title {
        opacity: 0;
        animation: contactTitleIn 0.8s 0.2s cubic-bezier(.39, .575, .565, 1) both;
    }

    @keyframes contactTitleIn {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }

    .contact-wrapper .contact-input {
        opacity: 0;
        animation: contactInputIn 0.7s 0.3s cubic-bezier(.39, .575, .565, 1) both;
    }

    @keyframes contactInputIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }

    .contact-wrapper .img-contact {
        opacity: 0;
        animation: contactImgIn 1s 0.4s cubic-bezier(.39, .575, .565, 1) both;
    }

    @keyframes contactImgIn {
        from {
            opacity: 0;
            transform: translateX(-60px) scale(0.96);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }

    .contact-wrapper .submit-btn-custom {
        opacity: 0;
        animation: contactBtnIn 0.7s 0.5s cubic-bezier(.39, .575, .565, 1) both;
    }

    @keyframes contactBtnIn {
        from {
            opacity: 0;
            transform: scale(0.8);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Example usage for your elements */
    .contact-title {
        animation: fadeInUp 1s cubic-bezier(.39, .575, .565, 1) both;
    }

    .contact-badge {
        animation: scaleIn 0.8s 0.2s cubic-bezier(.39, .575, .565, 1) both;
    }

    .contact-input {
        animation: fadeInUp 1s 0.3s cubic-bezier(.39, .575, .565, 1) both;
    }

    .img-contact {
        animation: slideInLeft 1.2s 0.4s cubic-bezier(.39, .575, .565, 1) both;
    }



    @media (min-width:768px) {
        .contact-title {
            font-size: var(--font-size-4xl);
        }

        .contact-input {
            font-size: var(--font-size-md);
            padding: var(--spacing-xl) var(--spacing-3xl) !important;
        }

        .contact-rounded-top {
            border-radius: 200px 200px 80px 80px;
        }

        .contact-wrapper::before {
            content: "";
            position: absolute;
            top: 20px;
            left: -14px;
            right: -14px;
            height: 220px;
            background: #2E7D32;
            border-radius: 210px 210px 0 0;
            z-index: 0;
        }

        .img-contact {
            height: 600px;
            width: 100%;
            object-fit: cover;
            border-radius: 3rem;
        }
    }

    .contact-badge.animate-on-scroll,
    .contact-title.animate-on-scroll,
    .contact-input.animate-on-scroll,
    .img-contact.animate-on-scroll,
    .submit-btn-custom.animate-on-scroll {
        opacity: 0;
    }

    .animate-on-scroll.animated {
        opacity: 1;
    }

    .contact-input.animate-on-scroll {
        opacity: 0;
        transform: translateY(40px) scale(0.96);
        transition: opacity 0.5s, transform 0.5s;
    }

    .contact-input.animate-on-scroll.animated {
        opacity: 1;
        transform: translateY(0) scale(1);
        transition: opacity 0.5s, transform 0.5s;
    }

    /* Stagger effect cho từng input */
    .row.g-3 .col-md-6:nth-child(1) .contact-input.animate-on-scroll.animated {
        transition-delay: 0.15s;
    }

    .row.g-3 .col-md-6:nth-child(2) .contact-input.animate-on-scroll.animated {
        transition-delay: 0.3s;
    }

    .mb-4 .contact-input.animate-on-scroll.animated {
        transition-delay: 0.45s;
    }
</style>

@push('scripts')
    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validation
            const fullName = this.full_name.value.trim();
            const phone = this.phone.value.trim();
            const email = this.email.value.trim();

            if (!fullName) {
                alert('Vui lòng nhập họ và tên');
                return;
            }

            if (!phone) {
                alert('Vui lòng nhập số điện thoại');
                return;
            }

            // Phone validation (Vietnamese format)
            const phoneRegex = /(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b/;
            if (!phoneRegex.test(phone)) {
                alert('Số điện thoại không đúng định dạng');
                return;
            }

            // Email validation if provided
            if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                alert('Email không đúng định dạng');
                return;
            }

            // Submit form
            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Cảm ơn bạn đã đăng ký! Chúng tôi sẽ liên hệ với bạn sớm nhất.');
                        this.reset();
                    } else {
                        alert('Có lỗi xảy ra, vui lòng thử lại!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra, vui lòng thử lại!');
                });
        });
    </script>
@endpush
