@extends('layouts.guest')
@section('title',  'Refund Policy' )
@section('type',  'website' )
@section('url',  Request::url() )
@section('image',  asset("images/tracklia-page.jpg") )
@section('description',  'This policy is effective as of 11th November 2024' )
@section('imagealt',  'Refund Policy image' )


@section('header')

@endsection




@section('footer')

@endsection

@section('slot')
<!-- Main Content -->
<div class="main-content">
    <!-- Categories -->
    <div class="tags-container">
        @php
            // Sort categories so active category is first
            $sortedCategories = $categories->sortByDesc(function($cat) use ($slug) {
                return $cat == $slug ? 1 : 0;
            });
        @endphp

        @foreach($sortedCategories as $cat)
            <button class="category-btn @if($cat == $slug) active @endif" onclick="window.location.href='{{ route('category.video', [ $cat]) }}';">{{ $cat }}</button>
        @endforeach
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ request()->is('category/*/videos') ? 'active' : '' }}" id="videos-tab" data-bs-toggle="tab" data-bs-target="#videos" type="button" role="tab">
                <i class="fas fa-play me-1"></i> Videos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="playlists-tab" data-bs-toggle="tab" data-bs-target="#playlists" type="button" role="tab">
                <i class="fa-solid fa-image"></i> Photos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="channels-tab" data-bs-toggle="tab" data-bs-target="#channels" type="button" role="tab">
                <i class="fa-solid fa-images"></i> Gifs
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button" role="tab">
                <i class="fa-solid fa-video"></i> Cam Girls
            </button>
        </li>
    </ul>
    
    <!-- Page Header -->
    <div class="page-header">
        
    </div>
    <!-- Videos Grid -->
    <div class="row">
        @forelse ( $videos as $video)
            <!-- Video 1 -->
            <div class="col-lg-3 col-md-4 col-sm-6 video-card" onclick="window.location.href='{{ route('video.view',['category' => $video->category ,'slug'=>$video->slug ]) }}'">
                <div class="video-thumbnail">
                    <img src="{{ $video->thumbnail }}" alt="{{ $video->slug }}">
                    <div class="play-overlay">
                        <i class="fas fa-play play-icon"></i>
                    </div>
                    <span class="video-duration">{{ gmdate('i:s', $video->duration) }}</span>
                </div>
                <div class="video-info">
                    <div class="d-flex">
                        <div>
                            <h6 class="video-title">{{ $video->title }}</h6>
                            <p class="video-channel">{{ $video->channel }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <h1>No video</h1>
        @endforelse
        <div class="mt-6">
            {{ $videos->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>
@endsection