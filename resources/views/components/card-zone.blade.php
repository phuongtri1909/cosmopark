<article class="card-zone animate-on-scroll h-100">
    <!-- Image Section -->
    <section class="card-image animate-on-scroll">
        <div class="position-relative">
            <div class="bg animate-on-scroll" style="background-image: url('{{ Storage::url($project->hero_image) }}');">

            </div>
            <a href="{{ route('projects.show', ['slug' => $project->slug]) }}" class="action-btn animate-on-scroll">
                <img class="arrow-icon-main" src="{{ asset('assets/images/svg/arrow-left.svg') }}" />
            </a>
        </div>
    </section>

    <!-- Content Section -->
    <section class="card-content animate-on-scroll">
        <div class="zone-name-wrapper">
            <a href="{{ route('projects.show', ['slug' => $project->slug]) }}" class="fw-bold text-lg-2 text-decoration-none text-dark">{{ $project->title }}</a>
        </div>
    </section>
</article>
@once
    @push('styles')
        <style>
            @keyframes fadeInCard {
                from { opacity: 0; transform: translateY(40px) scale(0.96);}
                to { opacity: 1; transform: none;}
            }
            @keyframes zoomInCardImg {
                from { opacity: 0; transform: scale(0.92);}
                to { opacity: 1; transform: scale(1);}
            }
            @keyframes popBtn {
                0% { transform: scale(0.7); opacity: 0;}
                60% { transform: scale(1.1);}
                100% { transform: scale(1); opacity: 1;}
            }
            .card-zone {
                display: flex;
                flex-direction: column;
                background: white;
                border-radius: 24px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                padding: 12px 12px 32px;
                width: 400px;
                max-width: 100%;
                height: 100%;
            }

            .card-image {
                position: relative;
                height: 300px;
                overflow: visible;
                flex-shrink: 0;
            }

            .card-image .bg {
                position: relative;
                background-size: cover;
                background-position: center;
                width: 100%;
                height: 276px;
                border-radius: 16px;

                -webkit-mask: radial-gradient(circle 30px at 85% 100%, transparent 99%, black 100%);
                mask: radial-gradient(circle 30px at 78.5% 100%, transparent 99%, black 100%);
            }

            .action-btn {
                position: absolute;
                bottom: -9%;
                right: 13.5%;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #047857;
                border-radius: 50%;
                cursor: pointer;
                transition: all 0.2s ease-in-out;
                padding: 12px;
                width: 48px;
                height: 48px;
                border: none;
                z-index: 2;
            }

            .action-btn:hover {
                background-color: #065f46;
            }

            .action-btn:focus {
                outline: none;
                box-shadow: 0 0 0 2px #10b981, 0 0 0 4px #fff;
            }

            .action-btn svg {
                width: 24px;
                height: 24px;
                transition: transform 0.2s ease-in-out;
            }

            .action-btn:hover svg {
                transform: translate(2px, -2px);
            }

            .card-content {
                display: flex;
                flex-direction: column;
                flex: 1;
                padding: 0 32px;
                min-height: 80px;
            }

            .zone-name-wrapper {
                display: flex;
                align-items: center;
                height: 100%;
                min-height: 80px;
            }

            .card-content h1 {
                font-size: 1.5rem;
                font-weight: 700;
                color: #111827;
                line-height: 2rem;
            }

            .card-zone.animate-on-scroll { opacity: 0; }
            .card-zone.animate-on-scroll.animated { animation: fadeInCard 0.7s both; opacity: 1; }
            .card-image.animate-on-scroll.animated .bg { animation: zoomInCardImg 0.8s 0.2s both; }
            .action-btn.animate-on-scroll.animated { animation: popBtn 0.6s 0.5s both; }
            .card-content.animate-on-scroll.animated { animation: fadeInCard 0.7s 0.3s both; }

            @media (min-width: 768px) {
                .action-btn {


                right: 15%;

            }
            }

            @media (max-width: 640px) {
                .card-zone {
                    width: 350px;
                }

                .card-image {
                    height: 250px;
                }

                .card-image .bg {
                    height: 226px;
                }

                .action-btn {
                    top: 202px;
                }

                .card-content {
                    padding: 0 20px;
                    min-height: 70px;
                }

                .zone-name-wrapper {
                    min-height: 70px;
                }

                .card-content h1 {
                    font-size: 1.125rem;
                    line-height: 1.25rem;
                }
            }
        </style>
    @endpush
@endonce
