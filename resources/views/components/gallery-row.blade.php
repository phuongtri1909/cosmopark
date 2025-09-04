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
@endphp

<div class="row g-4 mt-4 align-items-stretch {{ $isEven ? '' : 'flex-row-reverse' }}" data-gallery-id="{{ $gallery->id }}" style="min-height: 300px; max-height: 500px;">
    <div class="col-12 col-lg-6 order-1 d-flex">
        <div class="position-relative w-100 rounded-4 overflow-hidden" style="aspect-ratio: 4/3;">
            @if($images->count() > 0)
                <img src="{{ asset('storage/' . $images->first()) }}"
                    class="img-fluid w-100 h-100 rounded-4 object-fit-cover animate-on-scroll main-image"
                    style="cursor: pointer;" 
                    onclick="openLightbox('{{ asset('storage/' . $images->first()) }}')" 
                    data-gallery-main="{{ $gallery->id }}"
                    data-current-src="{{ asset('storage/' . $images->first()) }}">
            @else
                <img src="{{ asset('assets/images/dev/image-1.jpg') }}"
                    class="img-fluid w-100 h-100 rounded-4 object-fit-cover animate-on-scroll main-image"
                    style="cursor: pointer;" 
                    onclick="openLightbox('{{ asset('assets/images/dev/image-1.jpg') }}')" 
                    data-gallery-main="{{ $gallery->id }}"
                    data-current-src="{{ asset('assets/images/dev/image-1.jpg') }}">
            @endif
        </div>
    </div>
    <div class="col-12 col-lg-6 order-2 d-flex">
        <div class="row g-4 sub-images-container w-100">
            @if($images->count() > 1)
                @foreach($images->skip(1)->take(4) as $index => $image)
                    <div class="col-6">
                        <div class="position-relative w-100 rounded-4 overflow-hidden" style="aspect-ratio: 4/3;">
                            <img src="{{ asset('storage/' . $image) }}" 
                                 class="img-fluid w-100 h-100 rounded-4 object-fit-cover animate-on-scroll sub-image" 
                                 style="cursor: pointer;"
                                 onclick="openLightbox('{{ asset('storage/' . $image) }}')"
                                 data-gallery-sub="{{ $gallery->id }}"
                                 data-sub-src="{{ asset('storage/' . $image) }}">
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
