<!-- Sidebar -->
<div class="sidebar">
    <a href="{{ route('home') }}" class="sidebar-item {{ request()->routeIs('home') ? 'active fw-bold' : '' }}">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </a>
    <a href="{{ route('videos') }}" class="sidebar-item {{ request()->routeIs('videoss') ? 'active fw-bold' : '' }}">
        <i class="fas fa-home"></i>
        <span>Videos</span>
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
    <a href="{{ route('shop') }}" class="sidebar-item {{ request()->routeIs('shop') ? 'active fw-bold' : '' }}">
        <i class="fa-solid fa-store"></i>
        <span>Shop</span>
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
    <a href="{{ route('admin.shop.index') }}" class="sidebar-item">
        <i class="fa-solid fa-shop"></i>
        <span>Shop Items</span>
    </a>
    <a href="{{ route('admin.users.index') }}" class="sidebar-item">
        <i class="fas fa-play-circle"></i>
        <span>Users</span>
    </a>
    <a href="{{ route('admin.media.index') }}" class="sidebar-item">
        <i class="fas fa-history"></i>
        <span>Media</span>
    </a>
    <a href="{{ route('admin.view.slut') }}" class="sidebar-item">
        <i class="fas fa-clock"></i>
        <span>Slut Chat</span>
    </a>
    <a href="{{ route('chat.all') }}" class="sidebar-item">
        <i class="fas fa-clock"></i>
        <span>My Chat</span>
    </a>
    
    
    <div class="sidebar-divider"></div>  
    @endrole
    @role('pornstar')
    @endrole
    @role('fan')
    <a href="{{ route('profile',[auth()->user()->username]) }}" class="sidebar-item">
        <i class="fas fa-play-circle"></i>
        <span>Profile</span>
    </a>
    <a href="{{ route('chat.all') }}" class="sidebar-item">
        <i class="fas fa-clock"></i>
        <span>My Chat</span>
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
    

    <a href="{{ get_affiliate_link('3x3',['creator', 'fans','onlyfans'])->link }}" class="sidebar-item" target="_blank">
        <i class="fa-solid fa-id-badge"></i>
        <span>Free Onlyfans</span>
    </a>
    <a href="{{ get_affiliate_link('3x3',['tube', 'video','tubes'])->link }}" class="sidebar-item" target="_blank">
        <i class="fas fa-film"></i>
        <span>Movies & Shows</span>
    </a>
    <a href="{{ get_affiliate_link('3x3',['games', 'game','sex game'])->link }}" class="sidebar-item" target="_blank">
        <i class="fas fa-gamepad"></i>
        <span>Gaming</span>
    </a>
    <a href="{{ get_affiliate_link('3x3',['cams', 'cam','webcam','cam girls'])->link }}" class="sidebar-item" target="_blank">
        <i class="fas fa-broadcast-tower"></i>
        <span>Live Cam</span>
    </a>
    @auth
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sidebar-item mb-6" style="border: none; background: none; padding: 0; display: flex; align-items: center;">
            <i class="fas fa-thumbs-up"></i>
            <span style="margin-left: 8px;">Sign Out</span>
        </button>
    </form>
    @endauth
    

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