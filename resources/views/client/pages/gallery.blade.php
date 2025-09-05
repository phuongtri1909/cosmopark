@extends('client.layouts.app')
@section('title', 'Gallery')
@section('description', 'Gallery')
@section('keyword', 'Gallery')


@section('content')
    <x-banner-page title="Gallery" alignItemCenter="true" :bannerPage="$bannerPage" />

    <div id="gallery-container">
        <x-gallery-list />
    </div>
@endsection


