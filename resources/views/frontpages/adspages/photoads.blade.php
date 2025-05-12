@php
    $ads = get_affiliate_link();
@endphp
@if(!$ads)

@else
    <div class="gallery-item">
        <a href="{{ $ads->link }}" class="gallery-link" target="_blank">
            <div class="gallery-img-container">
                <img src="{{ $ads->media }}" alt="adsphoto" class="gallery-img" loading="lazy">
            </div>
            <div class="gallery-info">
                <span class="gallery-title">{{ $ads->offer_name }}</span>
            </div>
        </a>
    </div>
@endif