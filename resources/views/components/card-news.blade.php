<div class="card-tin-tc">
    <img class="rectangle rounded-5" src="{{ asset('assets/images/dev/hero-slider-1.jpg') }}" />
    <div class="card-news">
        <div class="div">
            <div class="bg-primary-1 rounded-5 py-2 px-3">
                <div class="text-xs text-white">Giới thiệu vị trí</div>
            </div>
            <span class="line"></span>
            <div class="color-text-secondary text-xs-1">27 tháng 7, 2025</div>
        </div>
        <div class="card-news-2">
            <p class="color-primary-8 text-lg-2 fw-bold">Bảo vệ môi trường không đánh đổi tăng trưởng kinh tế ở Tây Ninh
            </p>
        </div>
    </div>
</div>


@once
    @push('styles')
        <style>
            .card-tin-tc {
                display: flex;
                flex-direction: column;
                width: 100%;
                max-width: 400px;
                align-items: flex-start;
                gap: 12px;
                position: relative;
            }

            .card-tin-tc .rectangle {
                position: relative;
                align-self: stretch;
                width: 100%;
                height: 225px;
                object-fit: cover;
            }

            .card-tin-tc .card-news {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                align-self: stretch;
                width: 100%;
                position: relative;
                flex: 0 0 auto;
            }

            .card-tin-tc .div {
                display: flex;
                align-items: center;
                gap: 12px;
                align-self: stretch;
                width: 100%;
                position: relative;
                flex: 0 0 auto;
            }

            .card-tin-tc .line {
                position: relative;
                flex: 1;
                flex-grow: 1;
                height: 2px;
                width: 59px;
                background: #c6c6c6;
            }

            @media (min-width: 768px) {


                .card-tin-tc .rectangle {
                    height: 300px;
                }
            }
        </style>
@endpush
    @endonce
