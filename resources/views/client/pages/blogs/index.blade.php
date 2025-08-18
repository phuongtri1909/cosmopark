@extends('client.layouts.app')
@section('title', 'News - Cosmopark')
@section('description', 'News and articles about Cosmopark, including updates on projects, events, and community
    activities.')
@section('keywords', 'news, articles, Cosmopark')


@section('content')
    <x-banner-news />

    <x-read-recently :latestPost="$latestPost" />

    <x-news-new :newsList="$latestNews" :categories="$categories" />
@endsection

@push('styles')
@endpush


@push('scripts')
@endpush
