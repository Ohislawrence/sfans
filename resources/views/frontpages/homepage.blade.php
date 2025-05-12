@extends('layouts.guest')
@section('title',  'Welcome Fan!!!' )
@section('type',  'website' )
@section('url',  Request::url() )
@section('image',  asset('storage/' . $videos->random()->thumbnail) )
@section('description',  'See your greatest fanasy come true.' )
@section('imagealt',  '' )


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
            <button class="category-btn" onclick="window.location.href='{{ route('category.all', [ $cat]) }}';">{{ $cat }}</button>
        @endforeach
    </div>
    
    
    
    <!-- Videos Grid -->

    <div class="row">
        <div class="shorts-header">
            <i class="fa-solid fa-video"></i>
            <h5>Videos</h5>
        </div>

        @foreach ($videos as $index => $video)
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
            @if(($index + 1) % 8 === 0 && !$loop->last)
                @include('frontpages.adspages.videoads')
            @endif
        @endforeach
        <div class="mt-6">
            {{ $videos->links('vendor.pagination.custom') }}
        </div>
        <!-- Ad Banner Section - Place this under the video content -->
        @include('frontpages.adspages.bannerbig')
    </div>
</div>
@endsection