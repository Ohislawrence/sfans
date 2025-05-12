@php
    $ads = get_affiliate_link();
@endphp
@if(!$ads)

@else
    <div class="col-lg-3 col-md-4 col-sm-6 video-card" onclick="window.open('{{ $ads->link }}', '_blank')">
        <div class="video-thumbnail">
            <img src="{{ $ads->media }}" alt="adspicture">
            <div class="play-overlay">
                <i class="fas fa-play play-icon"></i>
            </div>
            <span class="video-duration">Click Now</span>
        </div>
        <div class="video-info">
            <div class="d-flex">
                <div>
                    <h6 class="video-title">{{ $ads->offer_name}}</h6>
                    <p class="video-channel">{{ $ads->offer_by}}</p>
                </div>
            </div>
        </div>
    </div>
@endif
