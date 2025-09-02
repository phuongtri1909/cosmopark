@props(['align' => 'text-center text-md-start', 'introImage', 'images' => null])

<div class="intro-image-wrapper" @if ($images) data-images="{{ json_encode($images) }}" @endif
    @if ($introImage) data-current-image="{{ $introImage->image_url }}" data-current-title="{{ $introImage->title }}" data-current-description="{{ $introImage->description }}" @endif>
    @if ($introImage)
        <img class="img-intro animate-on-scroll" src="{{ $introImage->image_url }}"
            alt="{{ $introImage->getTranslation('title', app()->getLocale()) }}">
        <div class="content-intro-image {{ $align }}">
            <h2 class="text-xl-3 color-primary-4 fw-bold animate-on-scroll">
                {!! $introImage->title !!}
            </h2>
            <p class="color-text-secondary text-sm-2 content animate-on-scroll">
                {!! $introImage->description !!}
            </p>
        </div>
    @else
        <!-- Fallback content -->
        <img class="img-intro animate-on-scroll" src="{{ asset('assets/images/dev/image-6.jpg') }}" alt="COSMOPARK">
        <div class="content-intro-image {{ $align }}">
            <h2 class="text-xl-3 color-primary-4 fw-bold animate-on-scroll">
                COSMOPARK
            </h2>
            <p class="color-text-secondary text-sm-2 content animate-on-scroll">
                {{ __('intro_image_description') }}
            </p>
        </div>
    @endif
</div>

@once
    @push('styles')
        <style>
            .intro-image-wrapper {
                position: relative;
            }

            .img-intro {
                width: 100%;
                min-height: 500px;
                object-fit: cover;
                display: block;
                transition: all 0.6s ease-in-out;
            }

            .img-intro.transitioning-out {
                animation: imageFadeOut 0.6s ease-in-out forwards;
                pointer-events: none;
            }

            .img-intro.transitioning-in {
                animation: imageFadeIn 0.6s ease-in-out forwards;
                pointer-events: none;
            }

            .content-intro-image {
                position: absolute;
                top: 25%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 90%;
                padding: 16px;
                border-radius: 8px;
                transition: all 0.6s ease-in-out;
            }

            .content-intro-image.transitioning-out {
                animation: contentFadeOut 0.6s ease-in-out forwards;
            }

            .content-intro-image.transitioning-in {
                animation: contentFadeIn 0.6s ease-in-out forwards;
            }

            .content-intro-image .content {
                width: auto;
            }

            @media (min-width: 992px) {
                .content-intro-image {
                    top: 100px;
                    left: 100px;
                    transform: none;
                    width: 750px;
                    text-align: left;
                }

                .content-intro-image .content {
                    width: 100%;
                }
            }

            /* Animation keyframes */
            @keyframes fadeInImgIntro {
                from {
                    opacity: 0;
                    transform: scale(0.96) translateY(40px);
                }

                to {
                    opacity: 1;
                    transform: scale(1) translateY(0);
                }
            }

            @keyframes fadeInContentIntro {
                from {
                    opacity: 0;
                    transform: translateY(40px);
                }

                to {
                    opacity: 1;
                    transform: none;
                }
            }

            @keyframes fadeInTitleIntro {
                from {
                    opacity: 0;
                    transform: translateY(-30px);
                }

                to {
                    opacity: 1;
                    transform: none;
                }
            }

            @keyframes fadeInTextIntro {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: none;
                }
            }

            /* Image transition animations */
            @keyframes imageFadeOut {
                from {
                    opacity: 1;
                    transform: scale(1);
                }

                to {
                    opacity: 0;
                    transform: scale(1.05);
                }
            }

            @keyframes imageFadeIn {
                from {
                    opacity: 0;
                    transform: scale(0.95);
                }

                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            @keyframes contentFadeOut {
                from {
                    opacity: 1;
                    transform: translateY(0);
                }

                to {
                    opacity: 0;
                    transform: translateY(-20px);
                }
            }

            @keyframes contentFadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Chỉ áp dụng opacity: 0 cho các thành phần con */
            .img-intro.animate-on-scroll,
            .content-intro-image h2.animate-on-scroll,
            .content-intro-image .content.animate-on-scroll {
                opacity: 0;
            }

            .animate-on-scroll.animated {
                opacity: 1;
            }

            /* Giữ nguyên animation */
            .img-intro.animate-on-scroll.animated {
                animation: fadeInImgIntro 1s both;
            }

            .content-intro-image.animate-on-scroll.animated {
                animation: fadeInContentIntro 1s 0.2s both;
            }

            .content-intro-image h2.animate-on-scroll.animated {
                animation: fadeInTitleIntro 0.8s 0.4s both;
            }

            .content-intro-image .content.animate-on-scroll.animated {
                animation: fadeInTextIntro 0.8s 0.6s both;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const introImageWrapper = document.querySelector('.intro-image-wrapper');
                if (!introImageWrapper) return;

                const imgElement = introImageWrapper.querySelector('.img-intro');
                const contentElement = introImageWrapper.querySelector('.content-intro-image');
                const titleElement = contentElement?.querySelector('h2');
                const descriptionElement = contentElement?.querySelector('.content');

                function changeImageWithAnimation(newImageSrc, newTitle, newDescription) {
                    if (!imgElement || !contentElement) {
                        return;
                    }

                    imgElement.classList.add('transitioning-out');
                    contentElement.classList.add('transitioning-out');

                    setTimeout(() => {
                        imgElement.src = newImageSrc;

                        if (titleElement) titleElement.innerHTML = newTitle;
                        if (descriptionElement) descriptionElement.innerHTML = newDescription;

                        imgElement.classList.remove('transitioning-out');
                        imgElement.classList.add('transitioning-in');
                        contentElement.classList.remove('transitioning-out');
                        contentElement.classList.add('transitioning-in');

                        setTimeout(() => {
                            imgElement.classList.remove('transitioning-in');
                            contentElement.classList.remove('transitioning-in');
                        }, 600);
                    }, 600);
                }

                let currentImageIndex = 0;
                let images = [{
                    src: imgElement?.src || '',
                    title: titleElement?.innerHTML || '',
                    description: descriptionElement?.innerHTML || ''
                }];

                try {
                    const imagesData = introImageWrapper.dataset.images;
                    if (imagesData) {
                        const serverImages = JSON.parse(imagesData);
                        if (Array.isArray(serverImages) && serverImages.length > 0) {
                            images = serverImages;
                        }
                    }
                } catch (e) {
                    console.log('No images data from server');
                }

                function rotateImages() {
                    if (images.length <= 1) return;

                    currentImageIndex = (currentImageIndex + 1) % images.length;
                    const nextImage = images[currentImageIndex];

                    changeImageWithAnimation(
                        nextImage.src,
                        nextImage.title,
                        nextImage.description
                    );
                }

                if (images.length > 1) {
                    setInterval(rotateImages, 8000);
                } else {
                    images = demoImages;
                    setInterval(rotateImages, 5000); 
                }

                const demoImages = [{
                        src: imgElement?.src || '{{ asset('assets/images/dev/image-6.jpg') }}',
                        title: 'COSMOPARK',
                        description: 'Dự án phát triển bền vững'
                    },
                    {
                        src: '{{ asset('assets/images/dev/image-1.jpg') }}',
                        title: 'COSMOPARK',
                        description: 'Không gian sống hiện đại'
                    },
                    {
                        src: '{{ asset('assets/images/dev/image-2.jpg') }}',
                        title: 'COSMOPARK',
                        description: 'Tiện ích đẳng cấp'
                    }
                ];

                const testButton = document.createElement('button');
                testButton.innerHTML = 'Test Animation';
                testButton.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    z-index: 9999;
                    padding: 10px 20px;
                    background: #007bff;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                `;
                testButton.onclick = function() {
                    const randomIndex = Math.floor(Math.random() * demoImages.length);
                    const randomImage = demoImages[randomIndex];
                    changeImageWithAnimation(
                        randomImage.src,
                        randomImage.title,
                        randomImage.description
                    );
                };
                document.body.appendChild(testButton);

                window.changeIntroImage = changeImageWithAnimation;
            });
        </script>
    @endpush
@endonce
