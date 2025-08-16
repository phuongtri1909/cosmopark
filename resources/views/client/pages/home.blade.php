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

    <x-image-home />

    <x-intro-image />

    <x-news-home />
@endsection

@push('styles')

@endpush
