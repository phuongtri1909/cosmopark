<div class="branch">
    <div class="col-12 p-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="mb-4 text-center text-md-start">
                        <x-badge-custom badge="Phát triển công nghiệp bền vững" />
                        <h2 class="feature-title animate-on-scroll mb-0 fw-bold">NGÀNH CÔNG NGHIỆP ƯU TIÊN</h2>
                    </div>
                </div>

                <div class="col-12 mt-5 text-center">
                    <div class="row g-5 g-md-3">
                        <div class="col-12 col-lg-6 col-xl-3">
                            <div class="overlap-group animate-on-scroll">

                                <img class="subtract w-100" src="{{ asset('assets/images/svg/branch.svg') }}" />
                                <p class="text-wrapper text-md-1 color-primary-8 fw-semibold">THIẾT BỊ ĐIỆN - ĐIỆN
                                    TỬ</p>


                                <div class="icon-branch bg-primary-6 rounded-circle">
                                    <img class="icon-THIT-b-IN" src="{{ asset('assets/images/svg/branch-1.svg') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-xl-3">
                            <div class="overlap-group animate-on-scroll">

                                <img class="subtract w-100" src="{{ asset('assets/images/svg/branch.svg') }}" />
                                <p class="text-wrapper text-md-1 color-primary-8 fw-semibold">DƯỢC PHẨM</p>

                                <div class="icon-branch bg-primary-6 rounded-circle">
                                    <img class="icon-THIT-b-IN" src="{{ asset('assets/images/svg/branch-2.svg') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-xl-3">
                            <div class="overlap-group animate-on-scroll">

                                <img class="subtract w-100" src="{{ asset('assets/images/svg/branch.svg') }}" />
                                <p class="text-wrapper text-md-1 color-primary-8 fw-semibold">NĂNG LƯỢNG</p>

                                <div class="icon-branch bg-primary-6 rounded-circle">
                                    <img class="icon-THIT-b-IN" src="{{ asset('assets/images/svg/branch-3.svg') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6 col-xl-3">
                            <div class="overlap-group animate-on-scroll">

                                <img class="subtract w-100" src="{{ asset('assets/images/svg/branch.svg') }}" />
                                <p class="text-wrapper text-md-1 color-primary-8 fw-semibold">VÀ CÁC NGÀNH KHÁC</p>

                                <div class="icon-branch bg-primary-6 rounded-circle">
                                    <img class="icon-THIT-b-IN" src="{{ asset('assets/images/svg/branch-4.svg') }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@once
    @push('styles')
        <style>
            .branch .overlap-group {
                position: relative;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100%;
                opacity: 0;
                transform: translateY(40px) scale(0.96);
                transition: all 0.7s cubic-bezier(.39, .575, .565, 1);
                will-change: opacity, transform;
            }

            .branch .overlap-group.animated {
                opacity: 1;
                transform: none;
            }

            .branch .overlap-group:hover {
               
                transform: translateY(-6px) scale(1.03);
                transition: all 0.35s cubic-bezier(.39, .575, .565, 1);
                z-index: 2;
            }

            .branch .icon-branch {
                width: 64px;
                height: 64px;
                aspect-ratio: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                position: absolute;
                left: 50%;
                top: 0;
                transform: translate(-50%, -50%);
                z-index: 3;
                opacity: 0;
                transition: opacity 0.6s cubic-bezier(.39, .575, .565, 1), box-shadow 0.3s;
            }

            .branch .overlap-group.animated .icon-branch {
                opacity: 1;
                animation: branchIconPop 0.7s 0.2s cubic-bezier(.39, .575, .565, 1) both;
            }

            .branch .overlap-group:hover .icon-branch {
                box-shadow: 0 4px 24px 0 rgba(44,62,120,0.18);
                background: #fff;
                transition: box-shadow 0.3s, background 0.3s;
            }

            .branch .icon-THIT-b-IN {
                position: relative;
                width: 36px;
                height: 36px;
                aspect-ratio: 1;
                transition: transform 0.3s;
            }

            .branch .overlap-group:hover .icon-THIT-b-IN {
                transform: rotate(-12deg) scale(1.08);
            }

            .branch .text-wrapper {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: max-content;
                margin: 0;
                z-index: 2;
                text-align: center;
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.6s cubic-bezier(.39, .575, .565, 1);
            }

            .branch .overlap-group.animated .text-wrapper {
                opacity: 1;
                animation: branchTextFadeIn 0.7s 0.3s cubic-bezier(.39, .575, .565, 1) both;
            }

            .branch .overlap-group:hover .text-wrapper {
                text-shadow: 0 2px 12px rgba(44,62,120,0.12);
                color: #17693c;
                transition: text-shadow 0.3s, color 0.3s;
            }

            @keyframes branchIconPop {
                0% { opacity: 0; transform: translate(-50%, -50%) scale(0.7);}
                80% { opacity: 1; transform: translate(-50%, -50%) scale(1.12);}
                100% { opacity: 1; transform: translate(-50%, -50%) scale(1);}
            }
            @keyframes branchTextFadeIn {
                0% { opacity: 0; transform: translate(-50%, -40%) scale(0.96);}
                100% { opacity: 1; transform: translate(-50%, -50%) scale(1);}
            }
        </style>
    @endpush
@endonce
