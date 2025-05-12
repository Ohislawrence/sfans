@extends('layouts.guest')
@section('title',  'Sluts' )
@section('type',  'website' )
@section('url',  Request::url() )
@section('image',  asset('storage/' . $sluts->random()->display_photo) )
@section('description',  'Chat with your next jerk mate' )
@section('imagealt',  $sluts->random()->username )


@section('header')

@endsection




@section('footer')

@endsection

@section('slot')
<!-- Main Content -->
<div class="main-content">
    <div class="users-container">
        <div class="shorts-header">
            <h3>Sluts</h3>
        </div>
        
        <div class="users-grid">
            @forelse ( $sluts as $slut )
            @php
                $profilePhoto = $slut->display_photo
                    ? asset('storage/' . $slut->display_photo)
                    : asset('img/22541497.jpg');
            @endphp
                <a href="{{ route('profile',[ 'username' => $slut->username]) }}" class="user-card">
                    <img src="{{ $profilePhoto }}" alt="{{ $slut->name }}" class="user-avatar">
                    <span class="user-handle">{{ $slut->name }}</span>
                </a>
            @empty
                
            @endforelse
            
        </div>
    </div>
    @include('frontpages.adspages.bannerbig')
</div>
@endsection