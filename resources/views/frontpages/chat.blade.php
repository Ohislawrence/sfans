@extends('layouts.guest')
@section('title',  'Chat' )
@section('type',  'website' )
@section('url',  Request::url() )
@section('image',  asset("images/tracklia-page.jpg") )
@section('description',  'This policy is effective as of 11th November 2024' )
@section('imagealt',  'Refund Policy image' )


@section('header')
<style>
    :root {
        --yt-dark-1: #121212;
        --yt-dark-2: #202020;
        --yt-dark-3: #303030;
        --yt-dark-4: #424242;
        --yt-text-primary: #ffffff;
        --yt-text-secondary: #aaaaaa;
        --yt-red: #ff0000;
    }
    
    body {
        padding-top: 56px;
        margin: 0;
        background-color: var(--yt-dark-1);
        color: var(--yt-text-primary);
        font-family: 'Roboto', Arial, sans-serif;
    }
    
    .navbar {
        background-color: var(--yt-dark-2) !important;
        border-bottom: 1px solid var(--yt-dark-3);
    }
    
    .navbar-brand {
        font-weight: 500;
    }
    
    /* Main layout */
    .main-content {
        height: calc(100vh - 56px);
        overflow: hidden;
    }
    
    /* Cards styling */
    .chat-card {
        background-color: var(--yt-dark-2);
        border-radius: 0;
        border: none;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .card-header, .card-footer {
        background-color: var(--yt-dark-2);
        border-color: var(--yt-dark-3) !important;
        padding: 0.75rem 1rem;
    }
    
    .card-body {
        overflow-y: auto;
        flex: 1;
        padding: 0;
    }
    
    /* Users list */
    .users-card {
        width: 100%;
        height: 100%;
        z-index: 10;
    }
    
    .user-item {
        cursor: pointer;
        transition: background-color 0.2s;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--yt-dark-3);
    }
    
    .user-item:hover, .active-chat {
        background-color: var(--yt-dark-3);
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 0.75rem;
    }
    
    .user-info {
        flex: 1;
        min-width: 0;
    }
    
    .user-info h6 {
        margin-bottom: 0.1rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .user-info small {
        font-size: 0.75rem;
        color: var(--yt-text-secondary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
    }
    
    .user-status {
        font-size: 0.7rem;
        color: var(--yt-text-secondary);
    }
    
    /* Messages */
    .messages-container {
        padding: 0.75rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .message {
        max-width: 85%;
        padding: 0.6rem 0.8rem;
        border-radius: 18px;
        position: relative;
        font-size: 0.9rem;
        line-height: 1.4;
        word-wrap: break-word;
    }
    
    .message-sent {
        align-self: flex-end;
        background-color: var(--yt-red);
        color: white;
        border-bottom-right-radius: 4px;
    }
    
    .message-received {
        align-self: flex-start;
        background-color: var(--yt-dark-3);
        border-bottom-left-radius: 4px;
    }
    
    .message-time {
        font-size: 0.65rem;
        margin-top: 0.2rem;
        text-align: right;
        color: rgba(255, 255, 255, 0.6);
    }
    
    .message-received .message-time {
        color: var(--yt-text-secondary);
    }
    
    /* Input area */
    .message-input {
        background-color: var(--yt-dark-3);
        border: none;
        color: var(--yt-text-primary);
        padding: 0.6rem 1rem;
        border-radius: 20px;
    }
    
    .message-input:focus {
        background-color: var(--yt-dark-3);
        color: var(--yt-text-primary);
        box-shadow: none;
    }
    
    .send-button {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--yt-red);
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 0.5rem;
    }
    
    /* Typing indicator */
    .typing-indicator {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 0.8rem;
        background-color: var(--yt-dark-3);
        border-radius: 18px;
        align-self: flex-start;
        max-width: max-content;
        font-size: 0.8rem;
    }
    
    .typing-dots {
        display: flex;
        gap: 0.2rem;
    }
    
    .typing-dot {
        width: 6px;
        height: 6px;
        background-color: var(--yt-text-secondary);
        border-radius: 50%;
        animation: typingAnimation 1.4s infinite ease-in-out;
    }
    
    .typing-dot:nth-child(1) { animation-delay: 0s; }
    .typing-dot:nth-child(2) { animation-delay: 0.2s; }
    .typing-dot:nth-child(3) { animation-delay: 0.4s; }
    
    @keyframes typingAnimation {
        0%, 60%, 100% { transform: translateY(0); }
        30% { transform: translateY(-3px); }
    }
    
    /* Visitor notice */
    .visitor-notice {
        padding: 0.8rem;
        background-color: var(--yt-dark-3);
        text-align: center;
        margin: 0.75rem;
        border-radius: 8px;
        font-size: 0.85rem;
    }
    
    .login-prompt {
        color: var(--yt-red);
        font-weight: bold;
        text-decoration: none;
    }
    
    /* Mobile specific styles */
    @media (max-width: 767.98px) {
        .users-card {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        .users-card.show {
            transform: translateX(0);
        }
        
        .chat-card {
            width: 100%;
        }
        
        .back-button {
            display: block !important;
        }
        
        .message {
            max-width: 90%;
            font-size: 0.95rem;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
        }
    }
    
    /* Desktop specific styles */
    @media (min-width: 768px) {
        .main-content {
            display: flex;
            gap: 16px;
            padding: 1rem;
        }
        
        .users-card {
            width: 320px;
            flex-shrink: 0;
        }
        
        .chat-card {
            flex-grow: 1;
            border-radius: 12px;
        }
        
        .back-button {
            display: none !important;
        }
    }
    
    /* Scrollbar styling */
    ::-webkit-scrollbar {
        width: 6px;
    }
    
    ::-webkit-scrollbar-track {
        background: var(--yt-dark-2);
    }
    
    ::-webkit-scrollbar-thumb {
        background: var(--yt-dark-4);
        border-radius: 3px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
@endsection




@section('footer')

@endsection

@section
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
        <button class="btn btn-link me-2 p-0 mobile-menu-btn">
            <i class="fas fa-bars"></i>
        </button>
        <a class="navbar-brand" href="index.html">
            <i class="fab fa-youtube text-danger me-1"></i>
            YouTube
        </a>
        
        <div class="d-flex align-items-center ms-auto">
            <div class="input-group d-none d-md-flex">
                <input type="text" class="form-control bg-dark text-white border-dark search-bar" placeholder="Search">
                <button class="btn btn-dark border-dark search-btn" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <button class="btn btn-link text-white ms-2 voice-search">
                <i class="fas fa-microphone"></i>
            </button>
        </div>
        
        <div class="ms-auto d-flex align-items-center">
            <button class="btn btn-link text-white me-2 d-none d-md-block">
                <i class="fas fa-video"></i>
            </button>
            <button class="btn btn-link text-white me-2 d-none d-md-block">
                <i class="fas fa-bell"></i>
            </button>
            <img src="https://via.placeholder.com/30" class="rounded-circle" alt="Profile">
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="main-content">
    <!-- Users Card (Hidden on mobile by default) -->
    <div class="chat-card users-card" id="usersCard">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Messages</h5>
            <button class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-ellipsis-h"></i>
            </button>
        </div>
        
        <div class="card-body">
            <!-- Search -->
            <div class="p-3 border-bottom border-dark">
                <div class="input-group">
                    <span class="input-group-text bg-dark border-dark">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control bg-dark border-dark text-white" placeholder="Search messages">
                </div>
            </div>
            
            <!-- User 1 - Active Chat -->
            <div class="user-item active-chat d-flex align-items-center">
                <img src="https://via.placeholder.com/40" alt="User" class="user-avatar">
                <div class="user-info">
                    <h6 class="mb-0">Jane Smith</h6>
                    <small>Content Creator | 1.2M subscribers</small>
                    <span class="user-status">Last seen 15 minutes ago</span>
                </div>
                <span class="badge bg-danger ms-auto">3</span>
            </div>
            
            <!-- User 2 -->
            <div class="user-item d-flex align-items-center">
                <img src="https://via.placeholder.com/40/008000" alt="User" class="user-avatar">
                <div class="user-info">
                    <h6 class="mb-0">Alex Johnson</h6>
                    <small>Tech Reviewer | 500K subscribers</small>
                    <span class="user-status text-success">Online now</span>
                </div>
            </div>
            
            <!-- User 3 -->
            <div class="user-item d-flex align-items-center">
                <img src="https://via.placeholder.com/40/0000FF" alt="User" class="user-avatar">
                <div class="user-info">
                    <h6 class="mb-0">Maria Garcia</h6>
                    <small>Cooking Channel | 800K subscribers</small>
                    <span class="user-status">Last seen yesterday</span>
                </div>
                <span class="badge bg-danger ms-auto">1</span>
            </div>
            
            <!-- User 4 -->
            <div class="user-item d-flex align-items-center">
                <img src="https://via.placeholder.com/40/FF0000" alt="User" class="user-avatar">
                <div class="user-info">
                    <h6 class="mb-0">David Wilson</h6>
                    <small>Gaming Streamer | 2.4M subscribers</small>
                    <span class="user-status">Last seen 2 hours ago</span>
                </div>
            </div>
            
            <!-- User 5 -->
            <div class="user-item d-flex align-items-center">
                <img src="https://via.placeholder.com/40/FFFF00" alt="User" class="user-avatar">
                <div class="user-info">
                    <h6 class="mb-0">Sarah Lee</h6>
                    <small>Fitness Coach | 350K subscribers</small>
                    <span class="user-status">Last seen 1 week ago</span>
                </div>
            </div>
        </div>
        
        <div class="card-footer">
            <button class="btn btn-danger w-100">
                <i class="fas fa-plus me-2"></i> New Chat
            </button>
        </div>
    </div>
    
    <!-- Chat Card -->
    <div class="chat-card" id="chatCard">
        <!-- Chat Header -->
        <div class="card-header d-flex align-items-center">
            <button class="btn btn-link text-white p-0 me-2 back-button" id="backButton">
                <i class="fas fa-arrow-left"></i>
            </button>
            <img src="https://via.placeholder.com/40" alt="User" class="user-avatar me-2">
            <div class="flex-grow-1">
                <h5 class="mb-0">Jane Smith</h5>
                <span class="user-status">Last seen 15 minutes ago</span>
            </div>
            <div class="d-flex">
                <button class="btn btn-link text-white p-0 me-2">
                    <i class="fas fa-phone"></i>
                </button>
                <button class="btn btn-link text-white p-0 me-2">
                    <i class="fas fa-video"></i>
                </button>
                <button class="btn btn-link text-white p-0">
                    <i class="fas fa-ellipsis-v"></i>
                </button>
            </div>
        </div>
        
        <!-- Messages Container -->
        <div class="card-body">
            <div class="messages-container">
                <!-- Visitor Notice -->
                <div class="visitor-notice">
                    You're chatting as a visitor. <a href="login.html" class="login-prompt">Log in</a> to save your chat history.
                </div>
                
                <!-- Sample Messages -->
                <div class="message message-received">
                    Hey there! How are you doing today?
                    <div class="message-time">10:30 AM</div>
                </div>
                
                <div class="message message-sent">
                    I'm doing great! Just finished watching your latest video.
                    <div class="message-time">10:32 AM</div>
                </div>
                
                <div class="message message-received">
                    That's awesome! Did you like the tutorial? I tried to explain everything clearly.
                    <div class="message-time">10:33 AM</div>
                </div>
                
                <div class="message message-sent">
                    Yes, it was super helpful! I finally understand how to use the new API.
                    <div class="message-time">10:35 AM</div>
                </div>
                
                <div class="typing-indicator">
                    <div class="typing-dots">
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                    </div>
                    <span>typing...</span>
                </div>
            </div>
        </div>
        
        <!-- Chat Input Area -->
        <div class="card-footer">
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-white p-0 me-2">
                    <i class="fas fa-plus"></i>
                </button>
                <input type="text" class="form-control message-input flex-grow-1" placeholder="Type a message...">
                <button class="btn send-button" id="sendButton">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection