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
    <div class="shorts-header">
        <h5>Categories</h5>
    </div>
    <div class="categories-container">
        @foreach($categories as $cat)
            <button class="category-btn" onclick="window.location.href='{{ route('category.video', [ $cat]) }}';">{{ $cat }}</button>
        @endforeach
        
    </div>
</div>
@endsection