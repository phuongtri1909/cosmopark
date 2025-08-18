@extends('client.layouts.app')
@section('title', 'About Us Cosmopark')
@section('description',
    'Tìm hiểu về Cosmopark, dự án khu công nghiệp và đô thị xanh tại Việt Nam, với cam kết phát
    triển bền vững và bảo vệ môi trường.')
@section('keyword', 'Cosmopark, khu công nghiệp, đô thị xanh, phát triển bền vững')


@section('content')
    <x-banner-about />

    <x-vision-mission />

    <x-feature-section />

    <x-image-home :main="asset('assets/images/dev/image-1.jpg')" :images="[
        asset('assets/images/dev/image-about-1.jpg'),
        asset('assets/images/dev/image-about-2.jpg'),
        asset('assets/images/dev/image-about-3.jpg'),
        asset('assets/images/dev/image-about-4.jpg'),
    ]" overlay="linear-gradient(0deg, rgba(55, 129, 75, 0.25) 0%, rgba(55, 129, 75, 0.25) 100%)" />

    <x-zone-slider />
    <x-intro-image />


    <x-location />
    <x-branch />
@endsection

@push('scripts')
@endpush

@push('styles')
@endpush
