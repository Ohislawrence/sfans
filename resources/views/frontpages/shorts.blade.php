@extends('layouts.guest')
@section('title', 'Shorts Player')
@section('type', 'website')
@section('url', Request::url())
@section('image', asset("images/shorts-page.jpg"))
@section('description', 'Browse short videos')
@section('imagealt', 'Shorts Player')

@section('header')
<style>
    <style>
        body, html {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    background-color: #000;
    font-family: Arial, sans-serif;
}

.video-container {
    position: relative;
    width: 100%;
    max-width: 500px;
    margin: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}

.video-player {
    width: 100%;
    height: 100vh;
    max-height: 100vh;
    object-fit: cover;
    border-radius: 0;
    background-color: black;
}

/* Optional: Title overlay */
.video-title {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 1.2em;
    color: white;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    z-index: 10;
}

.preloader, .error {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 1.2em;
    color: white;
    z-index: 9999;
}
.video-wrapper {
    width: 375px; /* iPhone size */
    height: 667px; /* Portrait height */
    position: relative;
    overflow: hidden;
    border-radius: 16px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

@media (max-width: 768px) {
    .video-wrapper {
        width: 100%;
        height: 100vh;
        border-radius: 0;
    }
}

@media (min-width: 768px) {
    .video-container {
        margin-top: calc(5vh);
    }
}
</style>
<meta name="robots" content="noindex">
<link rel="canonical" href="{{ url()->current() }}">
<!-- Vue JS -->
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.min.js"></script>

<!-- Axios for HTTP Requests -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- Optional: Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@endsection

@section('slot')
<div id="app">
    <div class="video-container" v-if="currentVideo">
        <div class="video-wrapper">
        <video
            class="video-player"
            :src="currentVideo.link"
            autoplay
            muted
            playsinline
            @ended="loadNextVideo"
            playsinline
        ></video>
        </div>
        <h2 class="video-title">@{{ currentVideo.title }}</h2>
    </div>

    <div v-if="loading" class="preloader">
        <i class="fas fa-spinner fa-spin"></i> Loading...
    </div>

    <div v-if="error" class="error">@{{ error }}</div>
</div>


<script>
    new Vue({
        el: '#app',
        data: {
        currentVideo: {
            slug: '',
            title: '',
            link: '',
            tags: ''
        },
        loading: false,
        error: '',
        viewedVideos: JSON.parse(localStorage.getItem('viewedVideos')) || [],
    },
        mounted() {
            this.saveCurrentVideoToHistory();
            window.addEventListener('wheel', this.handleScroll);
        },
        methods: {
            saveCurrentVideoToHistory() {
                const slug = this.currentVideo.slug;
                if (!this.viewedVideos.includes(slug)) {
                    this.viewedVideos.push(slug);
                    localStorage.setItem('viewedVideos', JSON.stringify(this.viewedVideos));
                }
            },
            async loadNextVideo() {
                this.loading = true;
    
                try {
                    const res = await axios.get('/api/next-video', {
                        params: {
                            exclude_slug: this.currentVideo.slug,
                            tags: this.currentVideo.tags
                        }
                    });
    
                    if (res.data) {
                        console.log('API Response:', res.data);
                        this.currentVideo = res.data.video;
                        const newUrl = res.data.url;
    
                        this.saveCurrentVideoToHistory();
                        window.history.pushState({}, '', newUrl); // Update URL without reload
                    } else {
                        alert("No more videos found!");
                    }
                } catch (e) {
                    this.error = "Failed to load next video.";
                    console.error(e);
                } finally {
                    this.loading = false;
                }
            },
            async loadPrevVideo() {
                this.loading = true;
    
                try {
                    const res = await axios.get('/api/prev-video', {
                        params: {
                            exclude_slug: this.currentVideo.slug,
                            viewed_videos: JSON.stringify(this.viewedVideos)
                        }
                    });
    
                    if (res.data) {
                        this.currentVideo = res.data.video;
                        const newUrl = res.data.url;
    
                        this.saveCurrentVideoToHistory();
                        window.history.pushState({}, '', newUrl); // Update URL
                    } else {
                        alert("No previous video found.");
                    }
                } catch (e) {
                    this.error = "Failed to load previous video.";
                    console.error(e);
                } finally {
                    this.loading = false;
                }
            },
            handleScroll(e) {
                e.preventDefault();
    
                if (this.loading) return;
    
                if (e.deltaY > 0) {
                    this.loadNextVideo(); // Scroll down → Next video
                } else {
                    this.loadPrevVideo(); // Scroll up → Previous video
                }
            }
        }
    });
    </script>
@endsection