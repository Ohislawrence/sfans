@extends('layouts.guest')
@section('title',  'Chat' )
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
                <a href="{{ route('chat', $convo->chatbot->user->username) }}" class="user-item d-flex align-items-center">
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
            <button class="btn btn-danger w-100" onclick="location.href='{{ route('sluts') }}'">
                <i class="fas fa-plus me-2"></i> New Chat
            </button>
        </div>
    </div>
    
    <!-- Chat Card -->
    <div class="chat-card" id="chatCard">
        
    </div>
</div>

    

@endsection