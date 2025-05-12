@php
    $ads = get_affiliate_link('300x900');
@endphp
@if(!$ads)

@else
    <!-- Ad Banner Section - Place this under the video content -->
<div class="ad-banner-container mt-5 mb-5">
    <a href="{{ $ads->link }}" class="" target="_blank">
        <div class="ad-banner">
            <img src="{{ $ads->media }}" alt="Advertisement" class="img-fluid">
        </div>
    </a>
</div>
@endif