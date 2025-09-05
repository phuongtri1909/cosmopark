@props(['gallery', 'index' => 0])

@php
    $isEven = $index % 2 === 0;
    $images = collect([
        $gallery->image_1,
        $gallery->image_2,
        $gallery->image_3,
        $gallery->image_4,
        $gallery->image_5
    ])->filter();
    
    // Prepare data for image-home component
    $mainImage = $images->count() > 0 ? asset('storage/' . $images->first()) : asset('assets/images/dev/image-1.jpg');
    $subImages = $images->skip(1)->take(4)->map(function($image) {
        return asset('storage/' . $image);
    })->toArray();
@endphp

<div class="container py-4 {{ $isEven ? '' : 'flex-row-reverse' }}" data-gallery-id="{{ $gallery->id }}">
    <div class="row g-4 h-100">
        <div class="col-12 col-lg-6">
            <div class="position-relative h-100">
                <img src="{{ $mainImage }}"
                    class="img-fluid w-100 rounded-4 h-100 object-fit-cover animate-on-scroll main-image" 
                    style="min-height:258px; aspect-ratio: 4/3; object-fit:cover; cursor: pointer;" 
                    onclick="openLightbox('{{ $mainImage }}')" 
                    data-gallery-main="{{ $gallery->id }}"
                    data-current-src="{{ $mainImage }}">
            </div>
        </div>
        <div class="col-12 col-lg-6 h-100">
            <div class="row g-4 sub-images-container">
                @foreach($subImages as $subImage)
                <div class="col-6">
                    <img src="{{ $subImage }}" 
                         class="img-fluid w-100 rounded-4 object-fit-cover animate-on-scroll sub-image" 
                         style="aspect-ratio: 4/3; object-fit:cover; cursor: pointer;"
                         onclick="openLightbox('{{ $subImage }}')"
                         data-gallery-sub="{{ $gallery->id }}"
                         data-sub-src="{{ $subImage }}">
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
            .animate-on-scroll { opacity: 0; }
            .animate-on-scroll.animated { opacity: 1; }
            .img-fluid.animate-on-scroll.animated {
                animation: fadeInImgHome 0.9s both;
            }
            /* Stagger effect for grid images */
            .col-lg-6 .row .col-6:nth-child(1) .img-fluid.animate-on-scroll.animated { animation-delay: 0.1s;}
            .col-lg-6 .row .col-6:nth-child(2) .img-fluid.animate-on-scroll.animated { animation-delay: 0.2s;}
            .col-lg-6 .row .col-6:nth-child(3) .img-fluid.animate-on-scroll.animated { animation-delay: 0.3s;}
            .col-lg-6 .row .col-6:nth-child(4) .img-fluid.animate-on-scroll.animated { animation-delay: 0.4s;}
        </style>
    @endpush
@endonce
