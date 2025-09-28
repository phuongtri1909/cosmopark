@extends('client.layouts.app')
@section('title', 'About Us Cosmopark')
@section('description',
    'Tìm hiểu về Cosmopark, dự án khu công nghiệp và đô thị xanh tại Việt Nam, với cam kết phát
    triển bền vững và bảo vệ môi trường.')
@section('keyword', 'Cosmopark, khu công nghiệp, đô thị xanh, phát triển bền vững')


@section('content')
    <x-banner-about :generalIntroduction="$generalIntroduction" :introFeatures="$introFeatures" :bannerPage="$bannerPage" />

    <x-vision-mission :visionMission="$visionMission" />

    <x-feature-section :features="$features" />

    @if($imageHomes->count() > 0)
        @php
            $firstImageHome = $imageHomes->first();
            $subImages = $firstImageHome->subImages->map(function($subImage) {
                return $subImage->sub_image_url;
            })->toArray();
        @endphp
        
        <x-image-home
            :main="$firstImageHome->main_image_url"
            :images="$subImages"
            :overlay="'rgba(24,36,64,0.35)'"
            :useAjax="true"
        />
    @else
        <x-image-home
            :main="asset('assets/images/dev/image-1.jpg')"
            :images="[
                asset('assets/images/dev/image-2.jpg'),
                asset('assets/images/dev/image-3.jpg'),
                asset('assets/images/dev/image-4.jpg'),
                asset('assets/images/dev/image-5.jpg')
            ]"
            overlay="rgba(24,36,64,0.35)"
        />
    @endif

    <x-zone-slider />

    <x-intro-image :introImage="$introImage" />


    <x-location />
    
    <x-branch :industries="$industries" />
@endsection

@push('scripts')
@endpush

@push('styles')
@endpush
