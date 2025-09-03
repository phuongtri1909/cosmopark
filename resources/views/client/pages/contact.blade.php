@extends('client.layouts.app')
@section('title', 'Contact - Cosmopark')
@section('description', 'Contact - Cosmopark')
@section('keyword', 'Contact - Cosmopark')


@section('content')
    <x-banner-page title="Contact" alignItemCenter="false" />
@endsection

@push('scripts')
@endpush

@push('styles')
    <style>
        .bg-banner-page {
            margin-bottom: -80px;
        }

        @media (min-width: 768px) {
            .bg-banner-page {
                margin-bottom: -155px;
            }
        }
    </style>
@endpush
