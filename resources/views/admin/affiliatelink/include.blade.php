<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $afflink->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-edit"></i>
                    Edit Link
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.affiliatelink.update', $afflink) }}" class="crud-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="offer_name" class="form-input" id="" value="{{ $afflink->offer_name }}">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Link</label>
                            <input type="url" name="link" class="form-input" id="" value="{{ $afflink->link }}">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Offer By</label>
                            <input type="text" name="offer_by" class="form-input" id="" value="{{ $afflink->offer_by }}">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Cost</label>
                            <input type="text" name="cost" class="form-input" id="" value="{{ $afflink->cost }}">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Countries</label>
                            <textarea name="coutries" class="form-input">{{ $afflink->coutries }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Tags</label>
                            <textarea name="tags" class="form-input">{{ $afflink->tags }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Is smartlink</label>
                            <select name="is_smartlink" class="form-input" id="">
                                <option value="1" @if($afflink->is_smartlink == 1 ) selected @endif>Yes</option>
                                <option value="0" @if($afflink->is_smartlink == 0 ) selected @endif>No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Media</label>
                            <input type="text" name="media" class="form-input" id="" value="{{ $afflink->media }}">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Media Dimension</label>
                            <input type="text" name="media_dimension" class="form-input" id="" value="{{ $afflink->media_dimension }}">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Is Tangible</label>
                            <select name="is_tangible" class="form-input" id="">
                                <option value="1" @if($afflink->is_tangible == 1 ) selected @endif>Yes</option>
                                <option value="0" @if($afflink->is_tangible == 0 ) selected @endif>No</option>
                            </select>
                        </div>
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="crud-btn">Update Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal{{ $afflink->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-trash"></i>
                    Delete Link
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete {{ $afflink->offer_name }}? <b>This action cannot be undone.</b></p>
                <div class="form-actions">
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.affiliatelink.destroy', $afflink) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="crud-btn" style="background-color: #ff4444;">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>