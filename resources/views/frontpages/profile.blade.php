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
    <!-- Profile Header -->
    <div class="profile-header">
        @php
            $coverPhoto = $user->cover_photo
                ? asset('storage/' . $user->cover_photo)
                : null;
        @endphp

        <div class="profile-banner" @if($coverPhoto) style="background-image: url('{{ $coverPhoto }}'); background-size: cover; background-position: center;" @endif>
        </div>
        <div class="profile-avatar-container">
            @php
                $profilePhoto = $user->display_photo
                    ? asset('storage/' . $user->display_photo)
                    : asset('img/img1.png');
            @endphp
            <img src="{{ $profilePhoto }}" alt="Profile" class="profile-avatar">
            <h3 class="profile-name">{{ $user->name }}</h3>
            <div class="profile-handle">{{ '@' .$user->username }}</div>
            
            <div class="profile-actions">
                <button class="btn btn-danger btn-profile-action">
                    <i class="fas fa-bell"></i> 
                </button>
                <button onclick="location.href='{{ route('chat', ['botUserId' => $user->username]) }}'" class="btn btn-outline-light btn-profile-action">
                    <i class="fa-solid fa-comments"></i> Let's Chat
                </button>
            </div>
            
            <p class="profile-bio">{{ $user->bio }}</p>
            
            
        </div>
    </div>
    
    <!-- Tabs -->
    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button onclick="window.location.href='{{ route('profile', ['username' => $user->username, 'tab' => 'videos']) }}';" class="nav-link {{ $tab === 'videos' ? 'active' : '' }}" >
                <i class="fas fa-play me-1"></i> Videos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button onclick="window.location.href='{{ route('profile', ['username' => $user->username, 'tab' => 'shorts']) }}';" class="nav-link {{ request('tab') === 'shorts' ? 'active' : '' }}" >
                <i class="fa-solid fa-file-video"></i> Shorts
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button onclick="window.location.href='{{ route('profile', ['username' => $user->username, 'tab' => 'photos']) }}';" class="nav-link {{ request('tab') === 'photos' ? 'active' : 'photos' }}">
                <i class="fa-solid fa-image"></i> Photos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button onclick="window.location.href='{{ route('profile', ['username' => $user->username, 'tab' => 'chats']) }}';" 
                class="nav-link {{ request('tab') === 'chats' ? 'active' : '' }}">
            <i class="fa-solid fa-comments"></i> Chat Rooms
        </button>
        </li>
    </ul>
    
    <!-- Tab Content -->
    <div class="tab-content" id="profileTabsContent">
        @if(request('tab') === 'videos' || $tab === 'videos')
            @include('frontpages.profiletabs.videos')
        @elseif(request('tab') === 'photos')
            @include('frontpages.profiletabs.photos')
            @elseif(request('tab') === 'shorts')
            @include('frontpages.profiletabs.shorts')
        @endif
    </div>
</div>
@endsection