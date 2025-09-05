@props([
    'main' => null,
    'images' => [],
    'overlay' => 'rgba(24,36,64,0.35)',
    'useAjax' => false
])

<div class="container py-4 py-lg-5" id="image-home-container">
    <div class="row g-4 h-100">
        <div class="col-12 col-lg-6">
            <div class="position-relative h-100">
                <img src="{{ $main ?? asset('assets/images/dev/image-1.jpg') }}"
                    class="img-fluid w-100 rounded-4 h-100 object-fit-cover animate-on-scroll main-image" style="min-height:258px; aspect-ratio: 4/3; object-fit:cover;">
                <div class="rounded-4 position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end align-items-center"
                    style="background:{{ $overlay }};">
                    <h2 class="text-white fw-bold text-center text-md-start text-1lg-3 pb-3 animate-on-scroll main-title" style="line-height:1.2;">
                        {!! __('image_home_title') !!}
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 h-100">
            <div class="row g-4 sub-images-container">
                @foreach($images as $img)
                <div class="col-6">
                    <img src="{{ $img }}" class="img-fluid w-100 rounded-4 object-fit-cover animate-on-scroll sub-image" style="aspect-ratio: 4/3; object-fit:cover;">
                </div>
                @endforeach
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

            /* Image transition effects */
            .image-fade-out {
                opacity: 0;
                transform: scale(0.95);
                transition: all 0.5s ease;
            }

            .image-fade-in {
                opacity: 1;
                transform: scale(1);
                transition: all 0.5s ease;
            }

            .title-fade-out {
                opacity: 0;
                transform: translateY(-20px);
                transition: all 0.5s ease;
            }

            .title-fade-in {
                opacity: 1;
                transform: translateY(0);
                transition: all 0.5s ease;
            }
        </style>
    @endpush

    @if($useAjax)
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    let currentImageIndex = 0;
                    let imageData = [];
                    let isTransitioning = false;

                    // Function to load image data via AJAX
                    async function loadImageData() {
                        try {
                            const response = await fetch('{{ route("image-homes.get") }}');
                            if (response.ok) {
                                const data = await response.json();
                                imageData = data.data || [];
                                if (imageData.length > 0) {
                                    startImageRotation();
                                }
                            }
                        } catch (error) {
                            console.log('Error loading image data:', error);
                        }
                    }

                    // Function to start image rotation
                    function startImageRotation() {
                        if (imageData.length <= 1) return;
                        
                        setInterval(() => {
                            if (!isTransitioning) {
                                changeToNextImage();
                            }
                        }, 5000); // Change every 5 seconds
                    }

                    // Function to change to next image
                    function changeToNextImage() {
                        if (isTransitioning) return;
                        
                        isTransitioning = true;
                        const nextIndex = (currentImageIndex + 1) % imageData.length;
                        const currentImage = imageData[currentImageIndex];
                        const nextImage = imageData[nextIndex];

                        // Fade out current images
                        fadeOutImages();

                        // After fade out, change images and fade in
                        setTimeout(() => {
                            updateImages(nextImage);
                            fadeInImages();
                            currentImageIndex = nextIndex;
                            isTransitioning = false;
                        }, 500);
                    }

                    // Function to fade out images
                    function fadeOutImages() {
                        const mainImage = document.querySelector('.main-image');
                        const mainTitle = document.querySelector('.main-title');
                        const subImages = document.querySelectorAll('.sub-image');

                        if (mainImage) mainImage.classList.add('image-fade-out');
                        if (mainTitle) mainTitle.classList.add('title-fade-out');
                        subImages.forEach(img => img.classList.add('image-fade-out'));
                    }

                    // Function to fade in images
                    function fadeInImages() {
                        const mainImage = document.querySelector('.main-image');
                        const mainTitle = document.querySelector('.main-title');
                        const subImages = document.querySelectorAll('.sub-image');

                        if (mainImage) mainImage.classList.remove('image-fade-out');
                        if (mainTitle) mainTitle.classList.remove('title-fade-out');
                        subImages.forEach(img => img.classList.remove('image-fade-out'));
                    }

                    // Function to update images
                    function updateImages(imageData) {
                        const mainImage = document.querySelector('.main-image');
                        const mainTitle = document.querySelector('.main-title');
                        const subImages = document.querySelectorAll('.sub-image');

                        if (mainImage && imageData.main_image) {
                            mainImage.src = imageData.main_image;
                        }

                        if (mainTitle && imageData.title) {
                            mainTitle.textContent = imageData.title;
                        }

                        if (imageData.sub_images && imageData.sub_images.length > 0) {
                            imageData.sub_images.forEach((subImg, index) => {
                                if (subImages[index]) {
                                    subImages[index].src = subImg.sub_image;
                                }
                            });
                        }
                    }

                    // Load image data and start rotation
                    loadImageData();
                });
            </script>
        @endpush
    @endif
@endonce
