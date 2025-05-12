@extends('layouts.guest')
@section('title',  'Edit Profile' )
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
    <div class="container-fluid">
        <!-- List View -->
        <div class="crud-container">
            @include('layouts.component.alert')
            <div class="crud-header">
                <h3 class="crud-title">Profile Information</h3>
            </div>
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="container-fluid">
        <!-- List View -->
        <div class="crud-container">
            @include('layouts.component.alert')
            <div class="crud-header">
                <h3 class="crud-title">Update Password</h3>
            </div>
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="container-fluid">
        <!-- List View -->
        <div class="crud-container">
            @include('layouts.component.alert')
            <div class="crud-header">
                <h3 class="crud-title">Delete Account</h3>
            </div>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection