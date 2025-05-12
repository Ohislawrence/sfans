@extends('layouts.guest')
@section('title',  'Gifs' )
@section('type',  'website' )
@section('url',  Request::url() )
@section('image',  asset('storage/' . $gifs->random()->thumbnail)  )
@section('description',  'List of your favorite gifs from around the internet.' )
@section('imagealt',  '' )


@section('header')

@endsection




@section('footer')

@endsection

@section('slot')
<!-- Main Content -->
<div class="main-content">
    <!-- Page Header -->
    <div class="page-header">
        <h3 class="page-title">
            GIF
        </h3>
    </div>
    <div class="gallery-container">
        @forelse ( $gifs as $index => $gif)
        <div class="gallery-item">
            <a href="{{ route('gifs.view', $gif->slug) }}" class="gallery-link">
                <img src="{{ $gif->link }}" alt="{{ $gif->slug }}" class="gallery-img" loading="lazy">
                <span class="gallery-title">{{ $gif->title }}</span>
            </a>
        </div>
        @if(($index + 1) % 8 === 0 && !$loop->last)
            @include('frontpages.adspages.photoads')
        @endif
        @empty
            
        @endforelse
        
    </div>
    <!-- Ad Banner Section - Place this under the video content -->
    @include('frontpages.adspages.bannerbig')
</div>
@endsection