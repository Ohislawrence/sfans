@extends('layouts.guest')
@section('title',  'Categories' )
@section('type',  'website' )
@section('url',  Request::url() )
@section('image',  '' )
@section('description',  'The greatest list of categories.' )
@section('imagealt',  '' )


@section('header')

@endsection




@section('footer')

@endsection

@section('slot')
<!-- Main Content -->
<div class="main-content">
    <!-- Categories -->
    <div class="tags-container">
        @php
            // Sort categories so active category is first
            $sortedCategories = $categories->sortByDesc(function($cat) use ($slug) {
                return $cat == $slug ? 1 : 0;
            });
        @endphp

        @foreach($sortedCategories as $cat)
            <button class="category-btn @if($cat == $slug) active @endif" onclick="window.location.href='{{ route('category.all', [ $cat]) }}';">{{ $cat }}</button>
        @endforeach
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="" role="tablist">
        <li class="nav-item" role="presentation">
            <button onclick="window.location.href='{{ route('category.all', ['tab' => 'videos', 'slug' => $slug]) }}';" class="nav-link {{ $tab === 'videos' ? 'active' : '' }}" >
                <i class="fas fa-play me-1"></i> Videos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button onclick="window.location.href='{{ route('category.all', ['tab' => 'gifs' , 'slug' => $slug]) }}';" class="nav-link {{ $tab  === 'gifs' ? 'active' : '' }}" >
                <i class="fa-solid fa-file-video"></i> Gifs
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button onclick="window.location.href='{{ route('category.all', ['tab' => 'photos', 'slug' => $slug]) }}';" class="nav-link {{ $tab  === 'photos' ? 'active' : '' }}">
                <i class="fa-solid fa-image"></i> Photos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button onclick="window.location.href='{{ route('category.all', ['tab' => 'chats', 'slug' => $slug]) }}';" 
                class="nav-link {{ request('tab') === 'chats' ? 'active' : '' }}">
            <i class="fa-solid fa-comments"></i> Chat Rooms
        </button>
        </li>
    </ul>
    
    <!-- Page Header -->
    <div class="page-header">
        
    </div>
 <!-- Tab Content -->
 <div class="tab-content" id="profileTabsContent">
    @if($tab === null || $tab === 'videos')
        @include('frontpages.categoryview.videos')
    @endif
    @if($tab === 'photos')
        @include('frontpages.categoryview.photos')
    @endif
    @if($tab === 'gifs')
        @include('frontpages.categoryview.gifs')
    @endif
</div>
@endsection