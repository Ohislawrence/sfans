<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid">
        <button class="mobile-menu-btn me-2">
            <i class="fas fa-bars"></i>
        </button>
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('img/logo.png') }}" class="navbar-logo" alt="logo">
        </a>
        
        <button id="toggleSidebar" class="btn btn-link d-none d-lg-block me-2">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="d-flex align-items-center ms-auto">
            <div class="input-group d-none d-md-flex">
                <input type="text" class="form-control search-bar" placeholder="Search">
                <button class="btn btn-outline-secondary search-btn" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        
        <div class="ms-auto d-flex align-items-center">
            <button class="btn btn-link me-2 d-none d-md-block">
                <i class="fas fa-video"></i>
            </button>
            <button class="btn btn-link me-2 d-none d-md-block">
                <i class="fas fa-bell"></i>
            </button>
            @guest
            <a href="{{ route('login') }}">
            @else
            <a href="{{ route('profile', [ auth()->user()->username]) }}">
            @endguest
            
                <img src="{{ asset('img/img1.png') }}" width="40" class="rounded-circle" alt="Profile">
            </a>
            
        </div>
    </div>
</nav>