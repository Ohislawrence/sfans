function createNotification(profilePic, name, status, message) {
    const container = document.getElementById('notification-container');
    
    const notification = document.createElement('div');
    notification.className = 'notification';
    
    notification.innerHTML = `
        <img src="${profilePic}" alt="${name}" class="notification-avatar">
        <div class="notification-content">
            <div class="notification-name">${name}</div>
            <div class="notification-status">${status}</div>
            <div class="notification-message">${message}</div>
        </div>
        <button class="notification-close">&times;</button>
    `;
    
    // Add close button functionality
    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.addEventListener('click', () => {
        notification.classList.add('hiding');
        setTimeout(() => {
            notification.remove();
        }, 300);
    });
    
    // Auto-remove after 10 seconds
    setTimeout(() => {
        notification.classList.add('hiding');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 10000);
    
    container.appendChild(notification);
    
    return notification;
}

// Function to get random interval between min and max seconds
function getRandomInterval(minSeconds, maxSeconds) {
    return Math.floor(Math.random() * (maxSeconds - minSeconds + 1) + minSeconds) * 1000;
}

// Function to fetch notification data and show notification
async function showRandomNotification() {
    try {
        // Call your controller endpoint to get notification data
        const response = await fetch("{{ route('frontpage.notify') }}");
        const data = await response.json();
        
        if (data.success) {
            createNotification(
                data.profile_pic, 
                data.name, 
                data.status || 'Online', 
                data.message || 'Do you want to chat?'
            );
        }
    } catch (error) {
        console.error('Error fetching notification:', error);
    }
    
    // Schedule next notification
    const nextInterval = getRandomInterval(30, 120); // Between 30 and 120 seconds
    setTimeout(showRandomNotification, nextInterval);
}

// Start the notification cycle when page loads
document.addEventListener('DOMContentLoaded', () => {
    // Initial delay before first notification (5-15 seconds)
    const initialDelay = getRandomInterval(5, 15);
    setTimeout(showRandomNotification, initialDelay);
});