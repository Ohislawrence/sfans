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
    <div class="users-container">
        <div class="shorts-header">
            <h3>Pornstars</h3>
        </div>
        
        <div class="users-grid">
            @forelse ($pornstars as $pornstar)
            @php
                $profilePhoto = $pornstar->display_photo
                    ? asset('storage/' . $pornstar->display_photo)
                    : asset('img/22541497.jpg');
            @endphp
                <a href="{{ route('profile',[ $pornstar->username]) }}" class="user-card">
                    <img src="{{ $profilePhoto }}" alt="{{ $pornstar->name }}" class="user-avatar">
                    <span class="user-handle">{{ $pornstar->name }}</span>
                </a>
            @empty
                
            @endforelse
            
        </div>
    </div>
</div>
@endsection