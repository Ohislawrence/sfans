<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-edit"></i>
                    Edit User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.users.update', $user) }}" class="crud-form" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name" class="form-input" id="" value="{{ $user->name }}">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Email</label>
                            <input type="text" name="email" class="form-input" id="" value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Password</label>
                            <input type="text" name="password" class="form-input" id="" value="">
                        </div>
                        <div class="form-group">
                            <label for="videoChannel" class="form-label">Gender</label>
                            <select name="gender" class="form-input" id="">
                                <option value="">Select One</option>
                                <option value="transgender">Transgender</option>
                                <option value="female">Female</option>
                                <option value="male">Male</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="videoChannel" class="form-label">Gender</label>
                            <select name="gender" class="form-input" id="">
                                <option value="">Select One</option>
                                <option value="transgender" @if($user->gender == 'transgender' ) selected @endif>Transgender</option>
                                <option value="female" @if($user->gender == 'female' ) selected @endif>Female</option>
                                <option value="male" @if($user->gender == 'male' ) selected @endif>Male</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="videoChannel" class="form-label">Sexual Orientation</label>
                            <select name="sexual_orientation" class="form-input" id="">
                                <option value="" >Select One</option>
                                <option value="gay" @if($user->sexual_orientation == 'gay' ) selected @endif>gay</option>
                                <option value="lesbian" @if($user->sexual_orientation == 'lesbian' ) selected @endif>lesbian</option>
                                <option value="straight" @if($user->sexual_orientation == 'straight' ) selected @endif>straight</option>
                                <option value="bisexual" @if($user->sexual_orientation == 'bisexual' ) selected @endif>bisexual</option>
                                <option value="asexual" @if($user->sexual_orientation == 'asexual' ) selected @endif>asexual</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">website</label>
                            <input type="url" name="website" class="form-input" id="" value="{{ $user->website }}">
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="form-label">Bio</label>
                            <textarea name="bio" class="form-input">{{ old('bio') }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="form-label">Role</label>
                            <select name="role" class="form-input" id="">
                                @foreach ( $roles as $role )
                                    <option value="{{ $role->name }}" @if($user->getRoleNames()->first() == $role  ) selected @endif>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Display Photo</label>
                            <input type="file" name="display_photo" class="form-input" id="img" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Cover Photo</label>
                            <input type="file" name="cover_photo" class="form-input" id="img" accept="image/*">
                        </div>
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="crud-btn">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-trash"></i>
                    Delete User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete {{ $user->name }}? <b>This action cannot be undone.</b></p>
                <div class="form-actions">
                    <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="crud-btn" style="background-color: #ff4444;">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>