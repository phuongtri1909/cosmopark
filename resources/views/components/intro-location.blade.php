<div class="location-frame d-flex flex-column align-items-center position-relative p-100 mt-3 mt-md-0">
    <div class="container">
        <img class="location-bg-vector" src="{{ asset('assets/images/svg/vector-1.svg') }}" />
        <img class="location-bg-img" src="{{ asset('assets/images/svg/vector-2.svg') }}" />
        <div class="row">
            <div class="col-12 col-lg-5 order-2 order-lg-1 d-flex align-items-center justify-content-center">
                <!-- Ảnh -->
                <img class="img-fluid rounded-4 animate-on-scroll" src="{{ asset('assets/images/dev/intro-location.jpg') }}" />
            </div>
            <div class="col-0 col-lg-1 d-none d-lg-block order-3 order-lg-2"></div>
            <div
                class="col-12 col-lg-6 order-1 order-lg-3 d-flex flex-column justify-content-center text-center text-md-start">
                <!-- Thông tin vị trí -->
                <div class="location-badge animate-on-scroll">
                    <x-badge-custom badge="Giới thiệu vị trí" />
                </div>
                <p class="location-title text-2xl-1 fw-bold text-dark animate-on-scroll">TÂY NINH <br />VÙNG KINH TẾ TRỌNG ĐIỂM MỚI</p>
                <p class="text-sm-1 color-text-secondary animate-on-scroll">
                    Thuộc top 10 tỉnh có quy mô kinh tế lớn nhất cả nước, là trung tâm phát triển kinh tế liên vùng và
                    cửa ngõ giao thương quan trọng, kết nối TP. Hồ Chí Minh với Đồng bằng sông Cửu Long và
                    Campuchia.<br />Sở hữu
                    hơn 10 trục động lực phát triển được quy hoạch bài bản, Tây Ninh không chỉ thuận lợi cho giao thương
                    nội
                    địa mà còn giữ vị trí chiến lược trong kết nối khu vực. Với hạ tầng liên vùng đang phát triển, tỉnh
                    đang từng
                    bước khẳng định vai trò trung tâm mới về công nghiệp, logistics và đô thị bền vững tại miền Nam Việt
                    Nam.
                </p>
            </div>
        </div>
        <!-- Số liệu thống kê -->
        <div class="location-stats mt-5 ">
            <div class="row">
                <div class="col-4 text-center">
                    <div class="d-inline-flex align-items-center position-relative">
                        <div class="location-stat-value text-1lg-8 color-primary-4 fw-bold animate-on-scroll" data-target="3.2">3,2</div>
                        <div class="location-stat-unit text-xs-4 color-primary-4">Triệu</div>
                    </div>
                    <div class="location-stat-label text-sm-2 color-text-secondary">Dân số</div>
                </div>
                <div class="col-4 text-center">
                    <div class="d-inline-flex align-items-center position-relative">
                        <div class="location-stat-value text-1lg-8 color-primary-4 fw-bold animate-on-scroll" data-target="13.5">~$13,5</div>
                        <div class="location-stat-unit text-xs-4 color-primary-4">Tỷ</div>
                    </div>
                    <div class="location-stat-label text-sm-2 color-text-secondary">Quy mô kinh tế</div>
                </div>
                <div class="col-4 text-center">
                    <div class="d-inline-flex align-items-center position-relative">
                        <div class="location-stat-value text-1lg-8 color-primary-4 fw-bold animate-on-scroll" data-target="9.63">9,63%</div>
                    </div>
                    <div class="location-stat-label text-sm-2 color-text-secondary">Tỷ lệ tăng trưởng QRDP</div>
                </div>


                <div class="col-4 text-center">
                    <div class="d-inline-flex align-items-center position-relative">
                        <div class="location-stat-value text-1lg-8 color-primary-4 fw-bold animate-on-scroll" data-target="120">120</div>
                        <div class="location-stat-unit text-xs-4 color-primary-4">Triệu</div>
                    </div>
                    <div class="location-stat-label text-sm-2 color-text-secondary">GRDP bình quân đầu người</div>
                </div>
                <div class="col-4 text-center">
                    <div class="d-inline-flex align-items-center position-relative">
                        <div class="location-stat-value text-1lg-8 color-primary-4 fw-bold animate-on-scroll" data-target="24">$24+</div>
                        <div class="location-stat-unit text-xs-4 color-primary-4">Tỷ</div>
                    </div>
                    <div class="location-stat-label text-sm-2 color-text-secondary">FDI</div>
                </div>
                <div class="col-4 text-center">
                    <div class="d-inline-flex align-items-center position-relative">
                        <div class="location-stat-value text-1lg-8 color-primary-4 fw-bold animate-on-scroll" data-target="13.9">$13.9+</div>
                        <div class="location-stat-unit text-xs-4 color-primary-4">Tỷ</div>
                    </div>
                    <div class="location-stat-label text-sm-2 color-text-secondary">Kim ngạch xuất nhập khẩu</div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .location-frame {
            background: linear-gradient(180deg,
                    rgba(242, 246, 252, 0) 0%,
                    rgba(227, 236, 246, 1) 100%);
        }

        .location-frame .location-bg-vector,
        .location-frame .location-bg-img {
            position: absolute;
            left:35%;
            transform: translateX(-50%);
            z-index: 1;
            height: auto;
        }

        .location-frame .location-bg-vector {
            top: 19px;
            width: 180px;
            max-width: 40vw;
        }

        .location-frame .location-bg-img {
            top: 320px;
            width: 220px;
            max-width: 60vw;
        }

        @media (min-width: 992px) {
            .location-frame .location-bg-vector {
                left: auto;
                right: 445px;
                transform: none;
                top: 19px;
                width: 320px;
                max-width: 100%;
            }

            .location-frame .location-bg-img {
                left: auto;
                right: 445px;
                transform: none;
                top: 481px;
                width: 420px;
                max-width: 100%;
            }
        }

        @media (min-width: 1200px) {
            .location-frame .location-bg-vector {
                width: 420px;
            }

            .location-frame .location-bg-img {
                width: 520px;
            }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-40px);}
            to { opacity: 1; transform: none;}
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px);}
            to { opacity: 1; transform: none;}
        }
        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.8);}
            to { opacity: 1; transform: scale(1);}
        }
        .animate-on-scroll { opacity: 0; }
        .animate-on-scroll.animated { opacity: 1; }
        .location-badge.animate-on-scroll.animated { animation: scaleInBadge 0.7s both; }
        .location-title.animate-on-scroll.animated { animation: fadeInDown 0.9s both; }
        .text-sm-1.animate-on-scroll.animated { animation: fadeInUp 1s 0.2s both; }
        .img-fluid.animate-on-scroll.animated { animation: zoomIn 1s 0.3s both; }
        .location-stat-value.animate-on-scroll.animated { animation: fadeInUp 0.8s both; }
        .location-stat-value.animate-on-scroll.animated:nth-of-type(2) { animation-delay: 0.2s;}
        .location-stat-value.animate-on-scroll.animated:nth-of-type(3) { animation-delay: 0.4s;}
        .location-stat-value.animate-on-scroll.animated:nth-of-type(4) { animation-delay: 0.6s;}
        .location-stat-value.animate-on-scroll.animated:nth-of-type(5) { animation-delay: 0.8s;}
        .location-stat-value.animate-on-scroll.animated:nth-of-type(6) { animation-delay: 1s;}
        @keyframes scaleInBadge {
            from { opacity: 0; transform: scale(0.8);}
            to { opacity: 1; transform: scale(1);}
        }
    </style>
@endpush
