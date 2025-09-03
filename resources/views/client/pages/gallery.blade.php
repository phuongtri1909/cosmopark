@extends('client.layouts.app')
@section('title', 'Gallery')
@section('description', 'Gallery')
@section('keyword', 'Gallery')


@section('content')
    <x-banner-page title="Gallery" alignItemCenter="true" />

    <x-gallery-list :main="asset('assets/images/dev/image-1.jpg')" :images="[]" />
@endsection

@push('scripts')
@endpush

@push('styles')
@endpush
