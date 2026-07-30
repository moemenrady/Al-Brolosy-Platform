@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @include('home.sections.hero')
    @include('home.sections.hero2')
    
    @include('home.sections.sectors')
    @include('home.sections.interest')
    @include('home.sections.media-section')
    @include('home.sections.visionaries-section')
    @include('home.sections.join-team')
    @include('home.sections.search')


@endsection
