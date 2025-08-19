@extends('client.layouts.app')
@section('title', 'Project - Cosmopark')
@section('description', 'Project - Cosmopark')
@section('keyword', 'Cosmopark, Project')


@section('content')

    @if ($slug == 'cosmopark-eco-industrial-zone')
        @php
            $reverseRow = false;
            $reverseCol = false;
            $reverseImage = false;
            $title = 'COSMOPARK';
            $subtitle = 'ECO INDUSTRIAL ZONE';
            $desc = __('eco_industrial_zone_desc');
            $number = '822';
            $unit = 'ha';
            $image = asset('assets/images/dev/intro-project.jpg');
            $button = false;
        @endphp
    @elseif($slug == 'cosmopark-convenient')
        @php
            $reverseRow = false;
            $reverseCol = false;
            $reverseImage = false;
            $title = 'COSMOPARK CONVENIENT';
            $subtitle = __('SOCIAL HOUSING');
            $desc = __('convenient_desc');
            $number = '15';
            $unit = 'ha';
            $image = asset('assets/images/dev/hero-slider-1.jpg');
            $button = false;
        @endphp
    @elseif($slug == 'cosmo-solar-park')
        @php
            $reverseRow = false;
            $reverseCol = true;
            $reverseImage = true;
            $title = 'COSMO SOLAR PARK';
            $subtitle = '';
            $desc = __('solar_park_desc');
            $number = '500';
            $unit = 'ha';
            $image = asset('assets/images/dev/hero-slider-2.webp');
            $button = false;
        @endphp
    @elseif($slug == 'san-golf-resort-villa')
        @php
            $reverseRow = false;
            $reverseCol = true;
            $reverseImage = true;
            $title = 'SÂN GOLF, RESORT & VILLA';
            $subtitle = '';
            $desc = __('golf_resort_desc');
            $number = '>120';
            $unit = 'ha';
            $image = asset('assets/images/dev/image-2.jpg');
            $button = true;
        @endphp
    @elseif($slug == 'cosmopark-smart-ai-city')
        @php
            $reverseRow = false;
            $reverseCol = true;
            $reverseImage = true;
            $title = 'COSMOPARK SMART AI CITY';
            $subtitle = '';
            $desc = __('smart_city_desc');
            $number = '>1000';
            $unit = 'ha';
            $image = asset('assets/images/dev/image-1.jpg');
            $button = false;
        @endphp
    @endif

    <x-intro-project :reverseRow="$reverseRow" :reverseCol="$reverseCol" :reverseImage="$reverseImage" :title="$title" :subtitle="$subtitle"
        :desc="$desc" :number="$number" :unit="$unit" :image="$image" :button="$button" />

    <x-media-project :images="[
        asset('assets/images/dev/hero-slider-1.jpg'),
        asset('assets/images/dev/hero-slider-2.webp'),
        asset('assets/images/dev/hero-slider.jpg'),
        asset('assets/images/dev/image-2.jpg'),
        asset('assets/images/dev/image-3.jpg'),
        asset('assets/images/dev/image-4.jpg'),
        asset('assets/images/dev/image-5.jpg'),
    ]" />

    @if ($slug == 'cosmopark-eco-industrial-zone')
        <x-location />
        <x-branch />
    @endif
@endsection

@push('scripts')
@endpush

@push('styles')
@endpush
