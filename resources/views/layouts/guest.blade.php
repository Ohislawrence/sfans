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
        <style>
            .fake-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #1f1f1f; /* dark background */
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 9999;
            animation: fadeIn 0.5s ease-out;
            color: rgb(255, 255, 255); /* <- black text */
        }

        .fake-notification img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #4caf50;
        }

        .fake-notification span,
        .fake-notification strong {
            font-size: 14px;
            color: rgb(253, 245, 245); /* <- black text */
        }

        .fake-notification button {
            margin-top: 5px;
            padding: 5px 10px;
            background: #ffffff; /* white button */
            color: black; /* black text */
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }

        .fake-notification button:hover {
            background: #f0f0f0;
        }
        .close-btn {
            background: transparent;
            border: none;
            color: black;
            font-size: 20px;
            cursor: pointer;
            align-self: flex-start;
            margin-left: 10px;
            line-height: 1;
        }
        .close-btn:hover {
            color: red;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(10px);}
            to {opacity: 1; transform: translateY(0);}
        }

        @keyframes fadeOut {
            from {opacity: 1;}
            to {opacity: 0;}
        }
        </style>
        
        @yield('header')
        @include('layouts.meta')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <meta name="juicyads-site-verification" content="297d1fe6d32802a4431b39dd4881e061">
    </head>
    <body>
        <div class="@if(!session('age_verified') && !request()->cookie('age_verified')) blur @endif">
        @include('layouts.component.nav')
        @include('layouts.component.sidebar')
        @yield('slot')
        <div id="notification-container" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2"></div>
        <x-age-verification />
        <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/main.js') }}"></script>
    
    @yield('footer')
    <div id="notification-container"></div>
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

@php
    $excludedRoutes = ['login', 'register', 'password.request','chat.all','chat'];
@endphp

@if (!in_array(Route::currentRouteName(), $excludedRoutes))
    {{-- Notification styles and script --}}

<script>
    function showNotification(data) {
        const container = document.getElementById('notification-container');

        const notification = document.createElement('div');
        notification.className = 'fake-notification';

        notification.innerHTML = `
        <img src="${data.avatar}" alt="${data.name}">
        <div style="flex: 1;">
            <strong>${data.name}</strong><br>
            <span>${data.message}</span><br>
            <button onclick="location.href='${data.link}'" style="margin-top:5px;padding:5px 10px;background:#ffffff;color:black;border:1px solid #ccc;border-radius:5px;cursor:pointer;">Chat now</button>
        </div>
        <button class="close-btn" onclick="this.parentElement.remove()" aria-label="Close">&times;</button>
    `;

        container.appendChild(notification);

        // Auto-remove after 5 seconds
        setTimeout(() => {
            notification.style.animation = 'fadeOut 0.5s ease-out forwards';
            setTimeout(() => notification.remove(), 500);
        }, 10000);
    }

    async function fetchNotification() {
        try {
            const response = await fetch("{{ route('notify') }}");
            if (!response.ok) return;
            const data = await response.json();
            showNotification(data);
        } catch (err) {
            console.error('Notification fetch failed:', err);
        }
    }

    function scheduleNextNotification() {
        const interval = Math.floor(Math.random() * (30000 - 10000 + 1)) + 10000; // 10-30 seconds
        setTimeout(async () => {
            await fetchNotification();
            scheduleNextNotification();
        }, interval);
    }

    // Start the first notification
    document.addEventListener('DOMContentLoaded', () => {
        scheduleNextNotification();
    });
</script>
@endif
    </body>
</html>
