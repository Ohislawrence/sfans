document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar collapse
    const toggleSidebar = document.getElementById('toggleSidebar');
    const sidebar = document.querySelector('.sidebar');
    
    if (toggleSidebar && sidebar) {
        toggleSidebar.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
    
    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileSidebar = document.querySelector('.sidebar');
    
    if (mobileMenuBtn && mobileSidebar) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileSidebar.classList.toggle('show');
        });
    }
    
    // Category buttons active state
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // Hover to play video preview (simulated)
    document.querySelectorAll('.video-thumbnail').forEach(thumbnail => {
        thumbnail.addEventListener('mouseenter', function() {
            // In a real implementation, you would load/play a video preview here
            console.log('Video preview should play now');
        });
        
        thumbnail.addEventListener('mouseleave', function() {
            // Stop video preview
            console.log('Video preview stopped');
        });
    });
    
    // Shorts item click
    document.querySelectorAll('.short-item').forEach(item => {
        item.addEventListener('click', function() {
            window.location.href = 'shorts.html';
        });
    });
});