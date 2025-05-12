@extends('layouts.guest')
@section('title',  $gif->title )
@section('type',  'website' )
@section('url',  Request::url() )
@section('image',  asset('storage/' . $gif->thumbnail) )
@section('description',  'This policy is effective as of 11th November 2024' )
@section('imagealt',  $gif->slug )


@section('header')

@endsection




@section('footer')

@endsection

@section('slot')
<!-- Main Content -->
<div class="main-content">
    <div class="tags-container">
        @foreach($gif->tags as $cat)
            <button class="category-btn" onclick="window.location.href='{{ route('category.all', [ $cat]) }}';">{{ $cat }}</button>
        @endforeach
    </div>
    <div class="row">
        <!-- Video Player and Info -->
        <div class="col-lg-8">
            <div class="image-view-main">
                <div class="image-container">
                <img src="{{ $gif->link }}" alt="{{ $gif->slug }}" class="gallery-img" loading="lazy">
                </div>
            </div>
            
            <h4 class="mt-3">{{ $gif->title }}</h4>
            
            <div class="d-flex justify-content-between align-items-center mt-2 mb-4">
                <h6 class="mb-0">{{ $gif->channel }}</h6>
                <div class="video-actions">
                    <button><i class="fas fa-thumbs-up"></i> {{ Number::forHumans(rand(10000,10000000)) }}</button>
                    <button><i class="fas fa-thumbs-down"></i> Dislike</button>
                    <button><i class="fas fa-share"></i> Share</button>
                    <button><i class="fas fa-cut"></i> Clip</button>
                    <button><i class="fas fa-plus"></i> Save</button>
                    <button><i class="fas fa-ellipsis-h"></i></button>
                </div>
            </div>
        </div>
        
        <!-- Ads -->
        <div class="col-lg-4">
            <div class="image-view-main">
                <a href="" class="image-container">
                    <img src="{{ asset('img/26053888.jpg') }}" alt="" class="video-ad-img">
                </a>
            </div>
        </div>
            
    </div>
    <div class="row">
        <div class="d-flex justify-content-between mb-3">
            <h4>Related Gifs</h4>
        </div>
        <div class="gallery-container">
        @forelse ( $relatedGifs as $related)
        <a href="{{ route('gifs.view', $related->slug) }}" class="gallery-link">
            <div class="gallery-item">
                <img src="{{ $related->link }}" alt="{{ $related->slug }}" class="gallery-img" loading="lazy">
                <span class="gallery-title">{{ $related->title }}</span>
            </div>
        </a>
        @empty
            <h1>No gif</h1>
        @endforelse
        </div>
        <!-- Ad Banner Section - Place this under the video content -->
        
        @include('frontpages.adspages.bannerbig')
    </div>
</div>
@endsection