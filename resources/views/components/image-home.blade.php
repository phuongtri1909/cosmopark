<div class="container py-4 py-lg-5">
    <div class="row g-4 h-100">
        <div class="col-12 col-lg-6">
            <div class="position-relative h-100">
                <img src="{{ asset('assets/images/dev/image-1.jpg') }}"
                    class="img-fluid w-100 rounded-4 h-100 object-fit-cover animate-on-scroll" style="min-height:258px;">
                <div class="rounded-4 position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end align-items-center"
                    style="background:rgba(24,36,64,0.35); ">
                    <h2 class="text-white fw-bold text-center text-md-start text-1lg-3 pb-3 animate-on-scroll" style="line-height:1.2;">
                        TỪ VÙNG ĐẤT GIÀU TIỀM NĂNG<br>
                        ĐẾN HÌNH MẪU<br>
                        KHU CÔNG NGHIỆP SINH THÁI
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 h-100">
            <div class="row g-4">
                <div class="col-6">
                    <img src="{{ asset('assets/images/dev/image-2.jpg') }}"
                        class="img-fluid w-100 rounded-4 object-fit-cover animate-on-scroll" style="aspect-ratio: 4/3;">
                </div>
                <div class="col-6">
                    <img src="{{ asset('assets/images/dev/image-3.jpg') }}"
                        class="img-fluid w-100 rounded-4 object-fit-cover animate-on-scroll" style="aspect-ratio: 4/3;">
                </div>
                <div class="col-6">
                    <img src="{{ asset('assets/images/dev/image-4.jpg') }}"
                        class="img-fluid w-100 rounded-4 object-fit-cover animate-on-scroll" style="aspect-ratio: 4/3;">
                </div>
                <div class="col-6">
                    <img src="{{ asset('assets/images/dev/image-5.jpg') }}"
                        class="img-fluid w-100 rounded-4 object-fit-cover animate-on-scroll" style="aspect-ratio: 4/3;">
                </div>
            </div>
        </div>
    </div>
</div>
@once
    @push('styles')
        <style>
            @keyframes fadeInImgHome {
                from { opacity: 0; transform: scale(0.92) translateY(40px);}
                to { opacity: 1; transform: scale(1) translateY(0);}
            }
            @keyframes fadeInTitleHome {
                from { opacity: 0; transform: translateY(-30px);}
                to { opacity: 1; transform: none;}
            }
            .animate-on-scroll { opacity: 0; }
            .animate-on-scroll.animated { opacity: 1; }
            .img-fluid.animate-on-scroll.animated {
                animation: fadeInImgHome 0.9s both;
            }
            h2.animate-on-scroll.animated {
                animation: fadeInTitleHome 1s 0.2s both;
            }
            /* Stagger effect for grid images */
            .col-lg-6 .row .col-6:nth-child(1) .img-fluid.animate-on-scroll.animated { animation-delay: 0.1s;}
            .col-lg-6 .row .col-6:nth-child(2) .img-fluid.animate-on-scroll.animated { animation-delay: 0.2s;}
            .col-lg-6 .row .col-6:nth-child(3) .img-fluid.animate-on-scroll.animated { animation-delay: 0.3s;}
            .col-lg-6 .row .col-6:nth-child(4) .img-fluid.animate-on-scroll.animated { animation-delay: 0.4s;}
        </style>
    @endpush
@endonce
