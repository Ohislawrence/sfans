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
        @foreach($categories as $cat)
            <button class="category-btn" onclick="window.location.href='{{ route('category.video', [ $cat]) }}';">{{ $cat }}</button>
        @endforeach
    </div>
    
    <!-- Shorts Section -->
    <div class="shorts-section">
        <div class="shorts-header">
            <i class="fab fa-youtube"></i>
            <h5>Shorts</h5>
        </div>
        <div class="shorts-container">
            <!-- Short 1 -->
            <div class="short-item">
                <div class="short-thumbnail">
                    <img src="https://via.placeholder.com/180x320" alt="Short video">
                </div>
                <div class="short-info">
                    <h6 class="short-title">Quick coding</h6>
                    <p class="short-views">1.2M views</p>
                </div>
            </div>
            
            <!-- Short 2 -->
            <div class="short-item">
                <div class="short-thumbnail">
                    <img src="https://via.placeholder.com/180x320" alt="Short video">
                </div>
                <div class="short-info">
                    <h6 class="short-title">Amazing CSS</h6>
                    <p class="short-views">850K views</p>
                </div>
            </div>
            
            <!-- Short 3 -->
            <div class="short-item">
                <div class="short-thumbnail">
                    <img src="https://via.placeholder.com/180x320" alt="Short video">
                </div>
                <div class="short-info">
                    <h6 class="short-title">JavaScriptd</h6>
                    <p class="short-views">2.4M views</p>
                </div>
            </div>
            
            <!-- Short 4 -->
            <div class="short-item">
                <div class="short-thumbnail">
                    <img src="https://via.placeholder.com/180x320" alt="Short video">
                </div>
                <div class="short-info">
                    <h6 class="short-title">How to center</h6>
                    <p class="short-views">3.1M views</p>
                </div>
            </div>
            
            <!-- Short 5 -->
            <div class="short-item">
                <div class="short-thumbnail">
                    <img src="https://via.placeholder.com/180x320" alt="Short video">
                </div>
                <div class="short-info">
                    <h6 class="short-title">React hook</h6>
                    <p class="short-views">1.7M views</p>
                </div>
            </div>
            
            <!-- Short 6 -->
            <div class="short-item">
                <div class="short-thumbnail">
                    <img src="https://via.placeholder.com/180x320" alt="Short video">
                </div>
                <div class="short-info">
                    <h6 class="short-title">Bootstrap vs</h6>
                    <p class="short-views">980K views</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Videos Grid -->

    <div class="row">
        <div class="shorts-header">
            <i class="fab fa-youtube"></i>
            <h5>Videos</h5>
        </div>

        @foreach ($videos as $video)
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
        @endforeach
        <div class="mt-6">
            {{ $videos->links() }}
        </div>
        <!-- Ad Banner Section - Place this under the video content -->
        <div class="ad-banner-container mt-5 mb-5">
            <div class="ad-banner">
                <img src="{{ asset('img/2.jpg') }}" alt="Advertisement" class="img-fluid">
            </div>
        </div>
    </div>
</div>
@endsection