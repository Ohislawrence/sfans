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
    <!-- Page Header -->
    <div class="shorts-header">
            <h3>Photos</h3>
        </div>
    <div class="gallery-container">
        
        @forelse ( $photos as $photo)
            <div class="gallery-item">
                <img src="{{ $photo->link }}" alt="{{ $photo->slug }}" class="gallery-img" loading="lazy">
                <button class="save-btn">
                    <i class="fas fa-bookmark"></i> Save
                </button>
                    <span class="gallery-title">{{ $photo->title }}</span>
            </div>
        @empty
            
        @endforelse
        
    </div>
</div>
@endsection