@extends('client.layouts.app')
@section('title', 'Home - Cosmopark')
@section('description', 'COSMOPARK là dự án được đầu tư bởi Tập đoàn Hoàng Gia Việt Nam, với quy hoạch tổng thể như một tổ hợp khu công nghiệp và đô thị xanh, tuân thủ các tiêu chuẩn sinh thái, tích hợp sản xuất bền vững, logistics và không gian sống thân thiện với môi trường, với tổng quy mô hơn 2.300 ha.')
@section('keywords', 'Cosmopark')

@section('content')

    <x-hero-slider />

    <x-intro-home />

    <x-intro-location />

    <x-location />

    <x-zone-slider />

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

    <x-intro-image />

    <x-news-home :latestNews="$latestNews" />
@endsection

@push('styles')

@endpush
