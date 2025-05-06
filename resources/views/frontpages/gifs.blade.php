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
        <h3>Gifs</h3>
    </div>
    <div class="gallery-container">
        @forelse ( $gifs as $gif)
            <div class="gallery-item">
                <img src="{{ $gif->link }}" alt="{{ $gif->slug }}" class="gallery-img" loading="lazy">
                <button class="save-btn">
                    <i class="fas fa-bookmark"></i> Save
                </button>
                    <span class="gallery-title">{{ $gif->title }}</span>
            </div>
        @empty
            
        @endforelse
    </div>
</div>
@endsection