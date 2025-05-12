<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $video->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-edit"></i>
                    Edit Video
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.media.update', $video) }}" class="crud-form" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="videoTitle" class="form-label">Title</label>
                            <input type="text" name="title" class="form-input" id="videoTitle" value="{{ $video->title }}"">
                        </div>
                        <div class="form-group">
                            <label for="videoTitle" class="form-label">Link</label>
                            <input type="text" name="link" class="form-input" id="videoTitle" value="{{ $video->link }}"">
                        </div>
                        <div class="form-group">
                            <label for="videoTitle" class="form-label">Category</label>
                            <input type="text" name="category" class="form-input" id="videoTitle" value="{{ $video->category}}"">
                        </div>
                        <div class="form-group">
                            <label for="videoTitle" class="form-label">Channel</label>
                            <input type="text" name="channel" class="form-input" id="videoTitle" value="{{ $video->channel }}"">
                        </div>
                        <div class="form-group">
                            <label for="videoTitle" class="form-label">Duration</label>
                            <input type="text" name="duration" class="form-input" id="videoTitle" value="{{ $video->duration }}"">
                        </div>
                        <div class="form-group">
                            <label for="videoTitle" class="form-label">Thumbnail</label>
                            <input type="text" name="thumbnail" class="form-input" id="videoTitle" value="{{ $video->thumbnail}}"">
                        </div>
                        <div class="form-group">
                            <label for="videoTitle" class="form-label">Random Number</label>
                            <input type="text" name="numbers" class="form-input" id="videoTitle" value="{{ $video->numbers }}"">
                        </div>
                        <div class="form-group">
                            <label for="videoTitle" class="form-label">Quality</label>
                            <input type="text" name="quality" class="form-input" id="videoTitle" value="{{ $video->quality }}"">
                        </div>
                        <div class="form-group">
                            <label for="videoTitle" class="form-label">Date</label>
                            <input type="text" name="date" class="form-input" id="videoTitle" value="{{ $video->date }}"">
                        </div>
                        <div class="form-group">
                            <label for="videoTitle" class="form-label">Iframe</label>
                            <textarea name="iframe" class="form-input">{{ old('iframe', $video->iframe) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="videoTitle" class="form-label">Tags</label>
                            <textarea name="tags" class="form-input">{{ old('tags', is_array($video->tags) ? implode(',', $video->tags) : $video->tags) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="videoTitle" class="form-label">Pornstar(s)</label>
                            <textarea name="pornstars" class="form-input">{{ old('pornstars',  is_array($video->pornstars) ? implode(',', $video->pornstars) : $video->pornstars) }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="videoChannel" class="form-label">Media Type</label>
                            <select name="media_type" class="form-input" id="videoChannel">
                                <option value="">Select One</option>
                                <option value="">Video</option>
                                <option value="1" @if($video->media_type == 1 ) selected @endif>Shorts</option>
                                <option value="2" @if($video->media_type == 2 ) selected @endif>Photos</option>
                                <option value="3" @if($video->media_type == 3 ) selected @endif>Gifs</option>
                            </select>
                        </div>
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="crud-btn">Update Video</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal{{ $video->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-trash"></i>
                    Delete Video
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete {{ $video->title }}? <b>This action cannot be undone.</b></p>
                <div class="form-actions">
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.media.destroy', $video) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="crud-btn" style="background-color: #ff4444;">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>