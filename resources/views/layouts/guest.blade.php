<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') | {{ config('app.name') }}</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
        <style>
            .swal2-container {
                backdrop-filter: blur(8px);
                background: rgba(0, 0, 0, 0.4); /* optional darker shade */
            }
        </style>
        
        @yield('header')
        @include('layouts.meta')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <div class="@if(!session('age_verified') && !request()->cookie('age_verified')) blur @endif">
        @include('layouts.component.nav')
        @include('layouts.component.sidebar')
        @yield('slot')
        <x-age-verification />
        <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/main.js') }}"></script>
    @yield('footer')
    <script>
        function updateVisitorPreferences(newTag) {
            const cookieName = 'visitor_preferences';
            const cookieDays = 365; // 1 year expiration
            const maxTags = 10; // limit to avoid cookie overflow
        
            // Helper: read cookie
            function getCookie(name) {
                const value = `; ${document.cookie}`;
                const parts = value.split(`; ${name}=`);
                if (parts.length === 2) return decodeURIComponent(parts.pop().split(';').shift());
            }
        
            // Helper: set cookie
            function setCookie(name, value, days) {
                const expires = new Date(Date.now() + days * 864e5).toUTCString();
                document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expires}; path=/`;
            }
        
            let visitorPreferences = getCookie(cookieName);
            let preferences = { interests: [] };
        
            if (visitorPreferences) {
                try {
                    preferences = JSON.parse(visitorPreferences);
                } catch (e) {
                    console.error('Error parsing visitor_preferences cookie:', e);
                }
            }
        
            // Add new tag if not already there
            if (!preferences.interests.includes(newTag)) {
                preferences.interests.push(newTag);
        
                // Keep it under the maxTags limit (remove oldest if too many)
                if (preferences.interests.length > maxTags) {
                    preferences.interests.shift();
                }
        
                // Save updated preferences
                setCookie(cookieName, JSON.stringify(preferences), cookieDays);
            }
        }
        </script>
    </body>
</html>
