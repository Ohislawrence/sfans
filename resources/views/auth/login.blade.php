@extends('layouts.authlayout')
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
<div class="auth-container">
    <div class="auth-header">
        <div class="auth-logo">
            <i class="fa-solid fa-venus-mars"></i>
        </div>
        <h1 class="auth-title">Sign in</h1>
        <p class="auth-subtitle">to continue to SluttyFan</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <input type="email" name="email" class="form-control" id="email" placeholder="Email or User Name" :value="old('email')" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required autocomplete="current-password">
           <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <a href="{{ route('password.request') }}" class="auth-link" style="font-size: 0.9rem;">Forgot password?</a>
        </div>
        
        
        <button type="submit" class="btn btn-login mb-3">Sign in</button>
        
        <div class="divider">or</div>
        
        <button onclick="window.location.href='{{ route('socialite.redirect', 'google') }}';" type="button" class="btn btn-google mb-3" >
            <i class="fab fa-google"></i> Sign in with Google
        </button>
    </form>

    <div class="auth-footer">
        <p>Don't have an account? <a href="{{ route('register') }}" class="auth-link">Sign up</a></p>
    </div>
</div>
@endsection
