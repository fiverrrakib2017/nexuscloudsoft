@extends('Frontend.Layout.App')

@section('title', 'Nexus Cloud Soft | Home')

@section('content')
    <!-- /Hero Section -->
    @include('Frontend.Component.Hero_section');

    <!-- About Section -->
    @include('Frontend.Component.About_section');

    <!-- Values Section -->
    @include('Frontend.Component.Values_section');

    <!-- Stats Section -->
    @include('Frontend.Component.Stats_section');

    <!-- Features Section -->
     @include('Frontend.Component.Features_section');

    <!-- Alt Features Section -->
    @include('Frontend.Component.Alt_features_section');

    <!-- Services Section -->
    @include('Frontend.Component.Services_section');

    <!-- Pricing Section -->
    @include('Frontend.Component.Pricing_section');

    <!-- Faq Section -->
     @include('Frontend.Component.Faq_section');


    <!-- Testimonials Section -->
    @include('Frontend.Component.Testimonials_section');

    <!-- Team Section -->
    @include('Frontend.Component.Team_section');

    <!-- Clients Section -->
    @include('Frontend.Component.Clients_section');

  

    <!-- Contact Section -->
     @include('Frontend.Component.Contact_section');
@endsection