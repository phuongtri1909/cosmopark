@extends('client.layouts.app')
@section('title', 'Gallery')
@section('description', 'Gallery')
@section('keyword', 'Gallery')


@section('content')
    <x-banner-page title="Gallery" alignItemCenter="true" />

    <div id="gallery-container">
        <x-gallery-list />
    </div>
@endsection


