@extends('layouts.guest')
@section('title',  'Category list' )
@section('type',  'website' )
@section('url',  Request::url() )
@section('image',  '' )
@section('description',  'Categoties pick one!' )
@section('imagealt',  '' )


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
            <button class="category-btn" onclick="window.location.href='{{ route('category.all', ['slug' => $cat]) }}';">{{ $cat }}</button>
        @endforeach
    </div>
    <!-- Ad Banner Section - Place this under the video content -->
    @include('frontpages.adspages.bannerbig')
</div>
@endsection