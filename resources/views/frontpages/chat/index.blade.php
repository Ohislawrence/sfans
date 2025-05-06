@extends('layouts.guest')
@section('title',  $botUser->name.' chat' )
@section('type',  'website' )
@section('url',  Request::url() )
@section('image',  asset("images/tracklia-page.jpg") )
@section('description',  'This policy is effective as of 11th November 2024' )
@section('imagealt',  'Refund Policy image' )

@section('header')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">
@endsection

@section('footer')
<script>
    const TYPING_DELAY = 800; // 0.8s before showing "typing..."
    const MIN_RESPONSE_DELAY = 1200; // 1.2s minimum response time
    const MAX_RESPONSE_DELAY = 3000; // 3s max response time
    const botUsername = @json($botUser->username);

    // Modified sendMessage function
function sendMessage() {
    const messageInput = $("#message");
    const message = messageInput.val().trim();
    
    if (!message) return;

    const now = new Date();
    appendDateSeparator(now);
    
    // Add user message immediately
    $("#chat-box").append(`<div class="message message-sent">
                ${message}
                <div class="message-time">${formatTime(now)}</div>
            </div>`);
    messageInput.val('');
    scrollChatToBottom();

    // Add typing delay before showing indicator
    setTimeout(() => {
        showTypingIndicator();
        
        // Calculate random response delay between min and max
        const responseDelay = Math.random() * (MAX_RESPONSE_DELAY - MIN_RESPONSE_DELAY) + MIN_RESPONSE_DELAY;
        
        $.ajax({
            url: `/send/chat/${botUsername}`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            data: { 
                message: message 
            },
            success: function(data) {
                // Wait until minimum delay has passed
                const elapsed = Date.now() - typingStartTime;
                const remainingDelay = Math.max(0, responseDelay - elapsed);
                
                setTimeout(() => {
                    hideTypingIndicator();
                    
                    const now = new Date();
                    appendDateSeparator(now);
                    
                    $("#chat-box").append(`<div class="message message-received">
                        ${data.response}
                        <div class="message-time">${formatTime(now)}</div>
                    </div>`);
                    scrollChatToBottom();
                }, remainingDelay);
            },
            error: function(xhr) {
                hideTypingIndicator();
                // ... (keep your existing error handling)
            }
        });
    }, TYPING_DELAY);
}

// Add this at the top to track timing
let typingStartTime = 0;
    
    // Format time as HH:MM AM/PM
    function formatTime(date) {
        let hours = date.getHours();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12;
        const minutes = date.getMinutes().toString().padStart(2, '0');
        return `${hours}:${minutes} ${ampm}`;
    }
    
    // Format date separator
    function formatDateSeparator(date) {
        const today = new Date();
        const yesterday = new Date(today);
        yesterday.setDate(yesterday.getDate() - 1);
        
        if (date.toDateString() === today.toDateString()) {
            return 'Today';
        } else if (date.toDateString() === yesterday.toDateString()) {
            return 'Yesterday';
        } else {
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        }
    }
    
    // Keep track of last displayed date
    let lastDisplayedDate = null;
    
    function appendDateSeparator(date) {
        const dateStr = formatDateSeparator(date);
        if (lastDisplayedDate !== dateStr) {
            $('#chat-box').append(`<div class="date-separator">${dateStr}</div>`);
            lastDisplayedDate = dateStr;
        }
    }

    // Show typing indicator
    function showTypingIndicator() {
    typingStartTime = Date.now();
    $('#chat-box').append(`
        <div class="typing-indicator" id="typingIndicator">
            <div class="typing-dots">
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            </div>
            <span>Typing...</span>
        </div>
    `);
    scrollChatToBottom();
}

    // Hide typing indicator
    function hideTypingIndicator() {
        $('#typingIndicator').remove();
    }
    
    

    function scrollChatToBottom() {
        const chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    }
    
    // Handle Enter key press
    $('#message').keypress(function(e) {
        if (e.which === 13) { // Enter key
            sendMessage();
        }
    });
    
    // Initialize with today's date
    $(document).ready(function() {
        appendDateSeparator(new Date());
        scrollChatToBottom();
    });
</script>
@endsection

@section('slot')
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
            
            @forelse ($chatlist as $convo)
                <a href="{{ route('chat', $convo->chatbot->user->username) }}" class="user-item {{ $convo->chatbot->user->username == $botUser->username ? 'active-chat' : '' }} d-flex align-items-center">
                    @php
                        $profilePhoto = $convo->chatbot->user->display_photo
                            ? asset('storage/' . $convo->chatbot->user->display_photo)
                            : asset('img/img1.png');
                    @endphp
                    <img src="{{ $profilePhoto }}" alt="Profile" class="user-avatar">
                    <div class="user-info">
                        <h6 class="mb-0">{{ $convo->chatbot->user->username }}</h6>
                        <small>Last message: {{ \Carbon\Carbon::parse($convo->last_updated_at)->diffForHumans() }}</small>
                        <span class="user-status">Online</span>
                    </div>
                    @if($convo->unread_count > 0)
                        <span class="badge bg-danger ms-auto">{{ $convo->unread_count }}</span>
                    @endif
                </a>
            @empty
                <div class="text-center py-4 text-muted">
                    No conversations yet
                </div>
            @endforelse
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
            @php
                $profilePhoto = $botUser->display_photo
                    ? asset('storage/' . $botUser->display_photo)
                    : asset('img/img1.png');
            @endphp
            <img src="{{ $profilePhoto }}" alt="Profile" class="user-avatar me-2">
            <div class="flex-grow-1">
                <h5 class="mb-0">{{ $botUser->name }}</h5>
                <span class="user-status">Online</span>
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
            <div class="messages-container" id="chat-box">
                @guest()
                    <!-- Visitor Notice -->
                    <div class="visitor-notice">
                        You're chatting as a visitor. <a href="{{ route('login') }}" class="login-prompt">Log in</a> to save your chat history.
                    </div>
                @endguest
                
                <!-- Sample chat history would be loaded here -->
            </div>
        </div>
        
        <!-- Chat Input Area -->
        <div class="card-footer">
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-white p-0 me-2">
                    <i class="fas fa-plus"></i>
                </button>
                <input type="text" id="message" autocomplete="off" class="form-control message-input flex-grow-1" placeholder="Type a message..." onkeypress="if(event.keyCode == 13) sendMessage()">
                <button class="btn send-button" id="sendButton" onclick="sendMessage()">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function scrollMessagesToBottom() {
        const container = document.getElementById('chat-box');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }
    
    function loadChatHistory(chatId) {
        $.get(`/chat/history/${botUsername}`, function(messages) {
            let lastDate = null;
            $('#chat-box').empty(); // Clear previous messages if needed
    
            messages.forEach(msg => {
                if (msg.date !== lastDate) {
                    $('#chat-box').append(`<div class="date-separator">${msg.date_display}</div>`);
                    lastDate = msg.date;
                }
    
                $('#chat-box').append(
                    `<div class="message message-sent">
                        ${msg.message}
                        <div class="message-time">${msg.time}</div>
                    </div>
                    <div class="message message-received">
                        ${msg.response}
                        <div class="message-time">${msg.time}</div>
                    </div>`
                );
            });
    
            scrollMessagesToBottom(); // Scroll to bottom after loading all messages
        });
    }
    
    // Initialize on page load
    $(document).ready(function() {
        loadChatHistory({{ $currentChatId ?? 0 }});
    });
    </script>
    

@endsection