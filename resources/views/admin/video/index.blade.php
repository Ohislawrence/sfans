@extends('layouts.guest')
@section('title',  'Media' )
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
<main class="main-content">
    <div class="container-fluid">
        <!-- List View -->
        <div class="crud-container">
            @include('layouts.component.alert')
            <div class="crud-header">
                <h2 class="crud-title">Videos</h2>
                <button class="crud-btn" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="fas fa-plus"></i>
                    Import Media from File
                </button>
                <button class="crud-btn" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="fas fa-plus"></i>
                    Add Media
                </button>
            </div>

            <table class="crud-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Channel</th>
                        <th>Media Type</th>
                        <th>category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $videos as $video )
                    <tr>
                        <td>{{ $video->title }}</td>
                        <td>{{ $video->channel }}</td>
                        <td>
                            @if($video->media_type == '')
                            Video
                            @elseif ($video->media_type == '1')
                            short
                            @elseif ($video->media_type == '2')
                            Photo
                            @elseif ($video->media_type == '3')
                            Gif
                            @endif
                        </td>
                        <td>{{ $video->category }}</td>
                        <td>
                            <div class="crud-actions">
                                <button class="crud-action-btn edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $video->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="crud-action-btn delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $video->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @include('admin.video.include')
                    @endforeach
                    
                    
                </tbody>
            </table>
            {{ $videos->links('vendor.pagination.custom') }}
        </div>

        <!-- Empty State Example (commented out) -->
        <!--
        <div class="crud-container">
            <div class="crud-header">
                <h2 class="crud-title">Videos</h2>
                <button class="crud-btn">
                    <i class="fas fa-plus"></i>
                    Add Video
                </button>
            </div>
            <div class="empty-state">
                <i class="fas fa-video-slash"></i>
                <h3>No Videos Found</h3>
                <p>You haven't added any videos yet. Get started by adding your first video.</p>
                <button class="crud-btn">
                    <i class="fas fa-plus"></i>
                    Add Video
                </button>
            </div>
        </div>
        -->
    </div>
</main>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">
                    <i class="fas fa-plus"></i>
                    Add New Media
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.media.store') }}" class="crud-form" method="POST">
                        @csrf
                    <div class="form-group">
                        <label for="videoTitle" class="form-label">Title</label>
                        <input type="text" name="title" class="form-input" id="videoTitle" value="{{ old('title') }}">
                    </div>
                    <div class="form-group">
                        <label for="videoTitle" class="form-label">Link</label>
                        <input type="text" name="link" class="form-input" id="videoTitle" value="{{ old('link') }}">
                    </div>
                    <div class="form-group">
                        <label for="videoTitle" class="form-label">Category</label>
                        <input type="text" name="category" class="form-input" id="videoTitle" value="{{ old('category') }}">
                    </div>
                    <div class="form-group">
                        <label for="videoTitle" class="form-label">Channel</label>
                        <input type="text" name="channel" class="form-input" id="videoTitle" value="{{ old('channel') }}">
                    </div>
                    <div class="form-group">
                        <label for="videoTitle" class="form-label">Duration</label>
                        <input type="text" name="duration" class="form-input" id="videoTitle" value="{{ old('duration') }}">
                    </div>
                    <div class="form-group">
                        <label for="videoTitle" class="form-label">Thumbnail</label>
                        <input type="text" name="thumbnail" class="form-input" id="videoTitle" value="{{ old('thumbnail') }}">
                    </div>
                    <div class="form-group">
                        <label for="videoTitle" class="form-label">Random Number</label>
                        <input type="text" name="numbers" class="form-input" id="videoTitle" value="{{ old('numbers') }}">
                    </div>
                    <div class="form-group">
                        <label for="videoTitle" class="form-label">Quality</label>
                        <input type="text" name="quality" class="form-input" id="videoTitle" value="{{ old('quality') }}">
                    </div>
                    <div class="form-group">
                        <label for="videoTitle" class="form-label">Date</label>
                        <input type="text" name="date" class="form-input" id="videoTitle" value="{{ old('date') }}">
                    </div>
                    <div class="form-group">
                        <label for="videoTitle" class="form-label">Iframe</label>
                        <textarea name="iframe" class="form-input">{{ old('iframe') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="videoTitle" class="form-label">Tags</label>
                        <textarea name="tags" class="form-input">{{ old('tags') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="videoTitle" class="form-label">Pornstar(s)</label>
                        <textarea name="pornstars" class="form-input">{{ old('pornstars') }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="videoChannel" class="form-label">Media Type</label>
                        <select name="media_type" class="form-input" id="videoChannel">
                            <option value="">Select One</option>
                            <option value="">Video</option>
                            <option value="1">Shorts</option>
                            <option value="2">Photos</option>
                            <option value="3">Gifs</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="crud-btn">Save Video</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Create Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">
                    <i class="fas fa-plus"></i>
                    IMport with CSV
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.cvsimport') }}" class="crud-form" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="form-group">
                        <label for="videoTitle" class="form-label">CVS file ONly</label>
                        <input type="file" name="csv_file" class="form-input" accept=".csv" required>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="crud-btn">Import Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection