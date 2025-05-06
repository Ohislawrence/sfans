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
    <div class="image-view-container">
        <!-- Main Image View Section -->
        <div class="image-view-main">
            <div class="image-container">
                <img src="img/29268713.jpg" alt="Featured image">
            </div>
            
            <div class="image-info">
                <h1 class="image-title">Beautiful Mountain Landscape at Sunrise</h1>
                
                <div class="image-author">
                    <img src="img/img1.png" alt="Author" class="author-avatar">
                    <div>
                        <div class="fw-bold">Nature Photographer</div>
                        <div class="text-muted small">1.2M followers</div>
                    </div>
                </div>
                
                <div class="image-actions">
                    <button class="image-action-btn">
                        <i class="far fa-heart"></i> 24.5K
                    </button>
                    <button class="image-action-btn">
                        <i class="far fa-comment"></i> 328
                    </button>
                    <button class="image-action-btn">
                        <i class="fas fa-share"></i> Share
                    </button>
                    <button class="image-action-btn">
                        <i class="far fa-bookmark"></i> Save
                    </button>
                </div>
                
                <p class="image-description">
                    Captured this breathtaking view during my hiking trip to the Swiss Alps last summer. 
                    The golden hour light created this magical atmosphere as the sun rose over the peaks. 
                    Shot with Canon EOS R5 at f/8, 1/125s, ISO 100.
                </p>
                
                <div class="image-tags">
                    <a href="#" class="image-tag">#nature</a>
                    <a href="#" class="image-tag">#mountains</a>
                    <a href="#" class="image-tag">#sunrise</a>
                    <a href="#" class="image-tag">#landscape</a>
                    <a href="#" class="image-tag">#photography</a>
                </div>
            </div>
        </div>
        
        <!-- You May Also Like Section -->
        <div class="related-section">
            <h3 class="section-title">
                <i class="fas fa-thumbs-up"></i> You May Also Like
            </h3>
            
            <div class="related-images">
                <!-- Related Image 1 -->
                <a href="view-image.html" class="related-item">
                    <img src="img/21544175.jpg" alt="Related image" class="related-img">
                    <div class="related-info">
                        <h5 class="related-title">Snowy Mountain Peak at Sunset</h5>
                        <div class="related-author">By Mountain Explorer</div>
                    </div>
                </a>
                
                <!-- Related Image 2 -->
                <a href="view-image.html" class="related-item">
                    <img src="img/25400466.jpg" alt="Related image" class="related-img">
                    <div class="related-info">
                        <h5 class="related-title">Forest River in Autumn Colors</h5>
                        <div class="related-author">By Nature Lover</div>
                    </div>
                </a>
                
                <!-- Related Image 3 -->
                <a href="view-image.html" class="related-item">
                    <img src="img/26053888.jpg" alt="Related image" class="related-img">
                    <div class="related-info">
                        <h5 class="related-title">Desert Landscape with Rock Formations</h5>
                        <div class="related-author">By Adventure Photographer</div>
                    </div>
                </a>
                
                <!-- Related Image 4 -->
                <a href="view-image.html" class="related-item">
                    <img src="img/26053888.jpg" alt="Related image" class="related-img">
                    <div class="related-info">
                        <h5 class="related-title">Ocean Waves Crashing on Cliffs</h5>
                        <div class="related-author">By Coastal Images</div>
                    </div>
                </a>
                
                <!-- Related Image 5 -->
                <a href="view-image.html" class="related-item">
                    <img src="img/25933926.jpg" alt="Related image" class="related-img">
                    <div class="related-info">
                        <h5 class="related-title">Misty Morning in the Valley</h5>
                        <div class="related-author">By Foggy Lens</div>
                    </div>
                </a>
                
                <!-- Related Image 6 -->
                <a href="view-image.html" class="related-item">
                    <img src="img/25400466.jpg" alt="Related image" class="related-img">
                    <div class="related-info">
                        <h5 class="related-title">Waterfall in the Jungle</h5>
                        <div class="related-author">By Tropical Shots</div>
                    </div>
                </a>
                
                <!-- Related Image 7 -->
                <a href="view-image.html" class="related-item">
                    <img src="img/25933926.jpg" alt="Related image" class="related-img">
                    <div class="related-info">
                        <h5 class="related-title">Northern Lights Over Lake</h5>
                        <div class="related-author">By Arctic Photographer</div>
                    </div>
                </a>
                
                <!-- Related Image 8 -->
                <a href="view-image.html" class="related-item">
                    <img src="img/22541497.jpg" alt="Related image" class="related-img">
                    <div class="related-info">
                        <h5 class="related-title">Sunset Over Wheat Fields</h5>
                        <div class="related-author">By Countryside Images</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection