<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-edit"></i>
                    Edit Item
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.shop.update', $item) }}" class="crud-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name" class="form-input" id="" value="{{ $item->name }}">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Link</label>
                            <input type="url" name="url" class="form-input" id="" value="{{ $item->url }}">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Images</label>
                            <input type="file" name="images[]" class="form-input" id="" multiple>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Offer By</label>
                            <input type="text" name="offer_by" class="form-input" id="" value="{{ $item->offer_by }}">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Cost</label>
                            <input type="text" name="price" class="form-input" id="" value="{{ $item->cost }}">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Discount</label>
                            <input type="text" name="discount" class="form-input" id="" value="{{ $item->discount }}">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Promote Code</label>
                            <input type="text" name="promo_code" class="form-input" id="" value="{{ $item->promo_code }}">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Countries</label>
                            <textarea name="coutries[]" class="form-input">{{ $item->coutries }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Tags</label>
                            <textarea name="tags[]" class="form-input">{{ $item->tags }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Description</label>
                            <textarea name="description" class="form-input">{{ $item->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Is Tangible</label>
                            <select name="is_tangible" class="form-input" id="">
                                <option value="1" @if($item->is_tangible == 1 ) selected @endif>Yes</option>
                                <option value="0" @if($item->is_tangible == 0 ) selected @endif>No</option>
                            </select>
                        </div>
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="crud-btn">Update Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                <p>Are you sure you want to delete {{ $item->name }}? <b>This action cannot be undone.</b></p>
                <div class="form-actions">
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.shop.destroy', $item) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="crud-btn" style="background-color: #ff4444;">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>