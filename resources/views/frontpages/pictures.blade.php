@extends('layouts.guest')
@section('title',  'Photos' )
@section('type',  'website' )
@section('url',  Request::url() )
@section('image',  asset('storage/' . $photos->random()->thumbnail) )
@section('description',  'Sexy photos' )
@section('imagealt',  '' )


@section('header')
<style>

</style>
@endsection




@section('footer')

@endsection

@section('slot')
<!-- Main Content -->
<div class="main-content">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            Photos
        </h1>
    </div>
    <div class="gallery-container">
        @forelse ($photos as $index => $photo)
            <div class="gallery-item">
                <a href="{{ route('photo.view', $photo->slug) }}" class="gallery-link">
                    <div class="gallery-img-container">
                        <img src="{{ $photo->link }}" alt="{{ $photo->slug }}" class="gallery-img" loading="lazy">
                    </div>
                    <div class="gallery-info">
                        <span class="gallery-title">{{ $photo->title }}</span>
                    </div>
                </a>
            </div>
            @if(($index + 1) % 8 === 0 && !$loop->last)
            @include('frontpages.adspages.photoads')
            @endif
        @empty
            <!-- Empty state -->
            
        @endforelse
    </div>
</div>
    <!-- Ad Banner Section - Place this under the video content -->
    @include('frontpages.adspages.bannerbig')
</div>
@endsection