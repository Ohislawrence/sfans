<div class="gallery-container">
        
    @forelse ( $viewAll as $photo)
    <a href="{{ route('photo.view', $photo->slug) }}" class="gallery-link">
        <div class="gallery-item">
            <img src="{{ $photo->link }}" alt="{{ $photo->slug }}" class="gallery-img" loading="lazy">
            <span class="gallery-title">{{ $photo->title }}</span>
        </div>
    </a>
    @empty
    <h3>No photos</h3>
    @endforelse
    
</div>
<div class="mt-6">
    {{ $viewAll->links('vendor.pagination.custom') }}
</div>
<!-- Ad Banner Section - Place this under the video content -->
@include('frontpages.adspages.bannerbig')