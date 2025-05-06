<!-- Sidebar -->
<div class="sidebar">
    <a href="{{ route('home') }}" class="sidebar-item {{ request()->routeIs('home') ? 'active fw-bold' : '' }}">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </a>
    <a href="{{ route('short') }}" class="sidebar-item {{ request()->routeIs('short') ? 'active fw-bold' : '' }}">
        <i class="fa-solid fa-circle-play"></i>
        <span>Shorts</span>
    </a>
    <a href="{{ route('categories') }}" class="sidebar-item {{ request()->routeIs('categories') ? 'active fw-bold' : '' }}">
        <i class="fa-solid fa-layer-group"></i>
        <span>Categories</span>
    </a>
    <a href="{{ route('pornstars') }}" class="sidebar-item {{ request()->routeIs('pornstars') ? 'active fw-bold' : '' }}">
        <i class="fa-solid fa-id-card"></i>
        <span>Pornstars</span>
    </a>
    <a href="{{ route('sluts') }}" class="sidebar-item {{ request()->routeIs('sluts') ? 'active fw-bold' : '' }}">
        <i class="fa-solid fa-circle-user"></i>
        <span>Sluts</span>
    </a>
    <a href="{{ route('photos') }}" class="sidebar-item {{ request()->routeIs('photos') ? 'active fw-bold' : '' }}">
        <i class="fa-solid fa-image"></i>
        <span>Photos</span>
    </a>
    <a href="{{ route('gifs') }}" class="sidebar-item {{ request()->routeIs('gifs') ? 'active fw-bold' : '' }}">
        <i class="fa-solid fa-images"></i>
        <span>Gifs</span>
    </a>
    <a href="{{ route('gifs') }}" class="sidebar-item {{ request()->routeIs('gifs') ? 'active fw-bold' : '' }}">
        <i class="fas fa-comments"></i>
        <span>Sex Chat</span>
    </a>
    
    
    <div class="sidebar-divider"></div>
    @auth
    @role('admin')
    <a href="#" class="sidebar-item">
        <i class="fas fa-play-circle"></i>
        <span>Dashboard</span>
    </a>
    <a href="{{ route('admin.affiliatelink.index') }}" class="sidebar-item">
        <i class="fas fa-thumbs-up"></i>
        <span>Affiliate Links</span>
    </a>
    <a href="{{ route('admin.users.index') }}" class="sidebar-item">
        <i class="fas fa-play-circle"></i>
        <span>Users</span>
    </a>
    <a href="{{ route('admin.videos.index') }}" class="sidebar-item">
        <i class="fas fa-history"></i>
        <span>Videos</span>
    </a>
    <a href="{{ route('admin.view.slut') }}" class="sidebar-item">
        <i class="fas fa-clock"></i>
        <span>Slut Chat</span>
    </a>
    
    
    <div class="sidebar-divider"></div>  
    @endrole
    @role('pornstar')
    @endrole
    @role('slut')
    @endrole
    @role('fan')
    <a href="{{ route('profile',[auth()->user()->username]) }}" class="sidebar-item">
        <i class="fas fa-play-circle"></i>
        <span>Profile</span>
    </a>
    <a href="#" class="sidebar-item">
        <i class="fas fa-history"></i>
        <span>History</span>
    </a>
    <a href="#" class="sidebar-item">
        <i class="fas fa-clock"></i>
        <span>Watch Later</span>
    </a>
    <a href="#" class="sidebar-item">
        <i class="fas fa-thumbs-up"></i>
        <span>Liked Videos</span>
    </a>
    
    <div class="sidebar-divider"></div>  
    @endrole
    @endauth
    
    
    
    <a href="#" class="sidebar-item" target="_blank">
        <i class="fa-solid fa-store"></i>
        <span>Store</span>
    </a>
    <a href="#" class="sidebar-item" target="_blank">
        <i class="fas fa-film"></i>
        <span>Movies & Shows</span>
    </a>
    <a href="#" class="sidebar-item" target="_blank">
        <i class="fas fa-gamepad"></i>
        <span>Gaming</span>
    </a>
    <a href="#" class="sidebar-item" target="_blank">
        <i class="fas fa-broadcast-tower"></i>
        <span>Live Cam</span>
    </a>

     <!-- Sidebar Footer -->
     <div class="sidebar-footer">
        <div class="sidebar-footer-links">
            <a href="#" class="text-muted">About</a>
            <a href="#" class="text-muted">Press</a>
            <a href="#" class="text-muted">Copyright</a>
            <a href="#" class="text-muted">Advertise</a>
        </div>
        <div class="sidebar-footer-copyright text-muted">
            © {{ date('Y') }} SluttyFan
        </div>
    </div>
</div>