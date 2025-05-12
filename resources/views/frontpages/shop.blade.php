@php
    $product = $products->random();
    $images = explode(',', $product->images);
    $firstImage = $images[0] ?? null;
@endphp
@extends('layouts.guest')
@section('title',  'Shop' )
@section('type',  'website' )
@section('url',  Request::url() )
@section('image',  asset('storage/' . $firstImage))
@section('description',  $products->random()->description )
@section('imagealt',  $products->random()->slug )


@section('header')
<link rel="stylesheet" href="{{ asset('css/shop.css') }}">
@endsection




@section('footer')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Product modal elements
    const productModal = document.getElementById('productModal');
    const modalOverlay = document.querySelector('.modal-overlay');
    const modalCloseBtn = document.querySelector('.modal-close-btn');
    
    // View product buttons
    const viewProductBtns = document.querySelectorAll('.view-product-btn');
    
    // Open modal when view button is clicked
    viewProductBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            loadProductDetails(productId);
            productModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
    });
    
    // Close modal when overlay or close button is clicked
    modalOverlay.addEventListener('click', closeModal);
    modalCloseBtn.addEventListener('click', closeModal);
    
    // Close modal when pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
    
    function closeModal() {
        productModal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    // Function to load product details (simulated with mock data)
    function loadProductDetails(productId) {
    // Show loading state
    document.querySelector('.modal-body').innerHTML = `
        <div class="loading-spinner">
            <div class="spinner"></div>
            <p>Loading product details...</p>
        </div>
    `;

    // Make AJAX request to get product details
    fetch(`/products/${productId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const product = data.product;
                const images = product.images.split(',');
                
                // Generate stars HTML
                let starsHtml = '';
                const fullStars = Math.floor(product.rating);
                const hasHalfStar = product.rating % 1 >= 0.5;
                
                for (let i = 1; i <= 5; i++) {
                    if (i <= fullStars) {
                        starsHtml += '<i class="fas fa-star"></i>';
                    } else if (i === fullStars + 1 && hasHalfStar) {
                        starsHtml += '<i class="fas fa-star-half-alt"></i>';
                    } else {
                        starsHtml += '<i class="far fa-star"></i>';
                    }
                }
                
                // Generate features list HTML if features exist
                let featuresHtml = '';
                if (product.features) {
                    try {
                        // Assuming features is stored as JSON in database
                        const featuresArray = typeof product.features === 'string' 
                            ? JSON.parse(product.features) 
                            : product.features;
                        if (featuresArray && featuresArray.length) {
                            featuresHtml = '<div class="modal-product-features"><h4>Features:</h4><ul>';
                            featuresArray.forEach(feature => {
                                featuresHtml += `<li>${feature}</li>`;
                            });
                            featuresHtml += '</ul></div>';
                        }
                    } catch (e) {
                        console.error('Error parsing features:', e);
                    }
                }

                // Generate image slides HTML
                let slidesHtml = '';
                images.forEach(image => {
                    // Remove any leading/trailing whitespace from image path
                    const trimmedImage = image.trim();
                    slidesHtml += `
                        <div class="slide">
                            <img src="/storage/${trimmedImage}" alt="${product.name}">
                        </div>
                    `;
                });
                
                // Generate navigation dots if more than one image
                let dotsHtml = '';
                if (images.length > 1) {
                    dotsHtml = '<div class="slider-dots">';
                    for (let i = 0; i < images.length; i++) {
                        dotsHtml += `<span class="dot ${i === 0 ? 'active' : ''}" data-slide="${i}"></span>`;
                    }
                    dotsHtml += '</div>';
                }
                
                // Create modal content with real product data
                const modalContent = `
                    <div class="modal-product">
                        <div class="modal-product-image">
                            <div class="modal-slider">
                                ${slidesHtml}
                            </div>
                            ${dotsHtml}
                            ${images.length > 1 ? `
                                <button class="slider-prev"><i class="fas fa-chevron-left"></i></button>
                                <button class="slider-next"><i class="fas fa-chevron-right"></i></button>
                            ` : ''}
                        </div>
                        <div class="modal-product-info">
                            <h2>${product.name}</h2>
                            <div class="modal-product-price">$${parseFloat(product.price).toFixed(2)}</div>
                            <p class="modal-product-description">${product.description}</p>
                            ${featuresHtml}
                            <div class="modal-product-actions">
                                <button class="add-to-cart-btn" onclick=" window.open('${product.url}','_blank')">
                                    <i class="fas fa-shopping-cart"></i> See More Info
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                
                // Insert content into modal
                document.querySelector('.modal-body').innerHTML = modalContent;
                
                // Initialize the slider
                initModalSlider();
                
                
            } else {
                showErrorModal();
            }
        })
        .catch(error => {
            console.error('Error fetching product:', error);
            showErrorModal();
        });
}

function initModalSlider() {
    const modalSlider = document.querySelector('.modal-slider');
    if (!modalSlider) return;

    const slides = modalSlider.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dots .dot');
    const prevBtn = document.querySelector('.slider-prev');
    const nextBtn = document.querySelector('.slider-next');
    
    let currentSlide = 0;
    let slideInterval;
    
    function showSlide(index) {
        // Validate index
        if (index < 0) index = slides.length - 1;
        if (index >= slides.length) index = 0;
        
        // Hide all slides
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        // Show current slide
        slides[index].classList.add('active');
        if (dots.length > 0) {
            dots[index].classList.add('active');
        }
        currentSlide = index;
    }
    
    function nextSlide() {
        showSlide(currentSlide + 1);
    }
    
    function prevSlide() {
        showSlide(currentSlide - 1);
    }
    
    // Initialize
    if (slides.length > 0) {
        showSlide(0);
        
        // Auto-rotate if more than one slide
        if (slides.length > 1) {
            slideInterval = setInterval(nextSlide, 5000);
            
            // Pause on hover
            modalSlider.addEventListener('mouseenter', () => {
                clearInterval(slideInterval);
            });
            
            modalSlider.addEventListener('mouseleave', () => {
                slideInterval = setInterval(nextSlide, 5000);
            });
        }
        
        // Navigation dots
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                clearInterval(slideInterval);
                showSlide(index);
                if (slides.length > 1) {
                    slideInterval = setInterval(nextSlide, 5000);
                }
            });
        });
        
        // Previous/next buttons
        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', () => {
                clearInterval(slideInterval);
                prevSlide();
                if (slides.length > 1) {
                    slideInterval = setInterval(nextSlide, 5000);
                }
            });
            
            nextBtn.addEventListener('click', () => {
                clearInterval(slideInterval);
                nextSlide();
                if (slides.length > 1) {
                    slideInterval = setInterval(nextSlide, 5000);
                }
            });
        }
        
        // Keyboard navigation
        document.addEventListener('keydown', function handleKeydown(e) {
            if (e.key === 'ArrowLeft') {
                clearInterval(slideInterval);
                prevSlide();
                if (slides.length > 1) {
                    slideInterval = setInterval(nextSlide, 5000);
                }
            } else if (e.key === 'ArrowRight') {
                clearInterval(slideInterval);
                nextSlide();
                if (slides.length > 1) {
                    slideInterval = setInterval(nextSlide, 5000);
                }
            }
        });
    }
}

function showErrorModal() {
    document.querySelector('.modal-body').innerHTML = `
        <div class="error-message">
            <i class="fas fa-exclamation-triangle"></i>
            <p>Error loading product details. Please try again.</p>
            <button class="retry-btn" onclick="loadProductDetails(${productId})">
                <i class="fas fa-sync-alt"></i> Retry
            </button>
        </div>
    `;
}
});
    </script>

<script>
    function initSliders() {
    // Initialize thumbnail sliders on product cards
    document.querySelectorAll('.thumbnail-slider').forEach(slider => {
        const slides = slider.querySelectorAll('.slide');
        if (slides.length > 0) {
            let currentSlide = 0;
            slides[0].classList.add('active');
            
            // Auto-rotate slides every 3 seconds
            const slideInterval = setInterval(() => {
                slides[currentSlide].classList.remove('active');
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].classList.add('active');
            }, 3000);
            
            // Pause on hover
            slider.parentElement.addEventListener('mouseenter', () => {
                clearInterval(slideInterval);
            });
            
            slider.parentElement.addEventListener('mouseleave', () => {
                slideInterval = setInterval(() => {
                    slides[currentSlide].classList.remove('active');
                    currentSlide = (currentSlide + 1) % slides.length;
                    slides[currentSlide].classList.add('active');
                }, 3000);
            });
        }
    });
    
    // Initialize modal slider
    const modalSlider = document.querySelector('.modal-slider');
    if (modalSlider) {
        const slides = modalSlider.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.slider-dots .dot');
        const prevBtn = document.querySelector('.slider-prev');
        const nextBtn = document.querySelector('.slider-next');
        
        let currentSlide = 0;
        
        function showSlide(index) {
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            
            slides[index].classList.add('active');
            if (dots.length > 0) {
                dots[index].classList.add('active');
            }
            currentSlide = index;
        }
        
        if (slides.length > 0) {
            showSlide(0);
            
            // Navigation dots
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => showSlide(index));
            });
            
            // Previous/next buttons
            if (prevBtn && nextBtn) {
                prevBtn.addEventListener('click', () => {
                    const newIndex = (currentSlide - 1 + slides.length) % slides.length;
                    showSlide(newIndex);
                });
                
                nextBtn.addEventListener('click', () => {
                    const newIndex = (currentSlide + 1) % slides.length;
                    showSlide(newIndex);
                });
            }
            
            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowLeft') {
                    const newIndex = (currentSlide - 1 + slides.length) % slides.length;
                    showSlide(newIndex);
                } else if (e.key === 'ArrowRight') {
                    const newIndex = (currentSlide + 1) % slides.length;
                    showSlide(newIndex);
                }
            });
        }
    }
}

// Initialize sliders when page loads
document.addEventListener('DOMContentLoaded', initSliders);
</script>
@endsection

@section('slot')
<div class="main-content">
    <div class="page-header">
        <h1 class="page-title">
            <i class="fa-solid fa-shop"></i> Shop
        </h1>
    </div>

    <div class="products-container">
        <div class="products-grid">
            @foreach($products as $product)
            <div class="product-card" data-product-id="{{ $product->id }}">
                @php
                    $images = explode(',', $product->images);
                @endphp
                <div class="product-thumbnail">
                    <div class="thumbnail-slider">
                        @foreach ($images as $image)
                            <div class="slide">
                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}">
                            </div>
                        @endforeach
                    </div>
                    <div class="product-badge">{{ $product->category }}</div>
                </div>
                <div class="product-info">
                    <h3 class="product-title">{{ $product->name }}</h3>
                    <div class="product-price">${{ number_format($product->price, 2) }}</div>
                    <button class="view-product-btn" data-product-id="{{ $product->id }}">
                        <i class="fas fa-eye"></i> View
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Product Modal -->
<div class="product-modal" id="productModal">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <button class="modal-close-btn">
            <i class="fas fa-times"></i>
        </button>
        <div class="modal-body">
            <!-- Product details will be loaded here via JavaScript -->
        </div>
    </div>
</div>
@endsection