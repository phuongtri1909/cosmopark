@extends('client.layouts.app')
@section('title', 'Project - Cosmopark')
@section('description', 'Project - Cosmopark')
@section('keyword', 'Cosmopark, Project')


@section('content')

    <x-intro-project 
        :reverseRow="$project->reverse_row" 
        :reverseCol="$project->reverse_col" 
        :reverseImage="$project->reverse_image" 
        :title="$project->title" 
        :subtitle="$project->subtitle"
        :desc="$project->description" 
        :number="$project->number" 
        :unit="$project->unit" 
        :image="$project->hero_image_url" 
        :button="$project->show_button" 
        :buttonText="$project->button_text"
        :buttonUrl="$project->button_url"
    />

    <x-media-project :project="$project" />

    @if ($project->slug == 'cosmopark-eco-industrial-zone')
        <x-location :slideLocations="$slideLocations" />
        <x-branch :industries="$industries" />
    @endif
@endsection

@push('scripts')
@endpush

@push('styles')
@endpush
