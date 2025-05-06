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
    <div class="tags-container">
        @foreach($video->tags as $cat)
            <button class="category-btn" onclick="window.location.href='{{ route('category.video', [ $cat]) }}';">{{ $cat }}</button>
        @endforeach
    </div>
    <div class="row">
        <!-- Video Player and Info -->
        <div class="col-lg-8">
            <div class="video-container">
                {!! $video->iframe !!}
            </div>
            
            <h4 class="mt-3">{{ $video->title }}</h4>
            
            <div class="d-flex justify-content-between align-items-center mt-2 mb-4">
                <h6 class="mb-0">{{ $video->channel }}</h6>
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
        
        <!-- Recommended Videos -->
        <div class="col-lg-4">
            <a href="" class="video-ad-card">
                <img src="{{ asset('img/25933926.jpg') }}" alt="" class="video-ad-img">
            </a>
            <a href="" class="video-ad-card">
                <img src="{{ asset('img/25933926.jpg') }}" alt="" class="video-ad-img">
            </a>
        </div>
            
    </div>
    <div class="row">
        <div class="d-flex justify-content-between mb-3">
            <h4>Related Videos</h4>
        </div>
        @forelse ( $relatedVideos as $related)
            <!-- Video 1 -->
            <div class="col-lg-3 col-md-4 col-sm-6 video-card" onclick="window.location.href='{{ route('video.view',['category' => $related->category ,'slug'=>$related->slug ]) }}'">
                <div class="video-thumbnail">
                    <img src="{{ $related->thumbnail }}" alt="{{ $related->slug }}">
                    <div class="play-overlay">
                        <i class="fas fa-play play-icon"></i>
                    </div>
                    <span class="video-duration">{{ gmdate('i:s', $related->duration) }}</span>
                </div>
                <div class="video-info">
                    <div class="d-flex">
                        <div>
                            <h6 class="video-title">{{ $related->title }}</h6>
                            <p class="video-channel">{{ $related->channel }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <h1>No video</h1>
        @endforelse
    </div>
</div>
@endsection