   <!-- Videos Grid -->
   <div class="row">
    @forelse ( $viewAll as $index=> $video)
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
        @if(($index + 1) % 8 === 0 && !$loop->last)
            @include('frontpages.adspages.videoads')
        @endif
    @empty
        <h3>No videos</h3>
    @endforelse
    <div class="mt-6">
        {{ $viewAll->links('vendor.pagination.custom') }}
    </div>
    <!-- Ad Banner Section - Place this under the video content -->
    @include('frontpages.adspages.bannerbig')
</div>
</div>