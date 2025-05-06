@extends('layouts.guest')
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
<!-- Main Content -->
<main class="main-content">
    <div class="container-fluid">
        <!-- List View -->
        <div class="crud-container">
            @include('layouts.component.alert')
            <div class="crud-header">
                <h2 class="crud-title">Users</h2>
                <button class="crud-btn" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="fas fa-plus"></i>
                    Create User
                </button>
            </div>

            <table class="crud-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $users as $user )
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->getRoleNames()->first() }}</td>
                        <td>{{ $user->created_at->format('M Y') }}</td>
                        <td>
                            <div class="crud-actions">
                                <button class="crud-action-btn edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="crud-action-btn delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @include('admin.users.include')
                    @endforeach
                    
                    
                </tbody>
            </table>
            {{ $users->links('vendor.pagination.custom') }}
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
                    Create User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.users.store') }}" class="crud-form" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Name</label>
                        <input type="text" name="name" class="form-input" id="" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Email</label>
                        <input type="text" name="email" class="form-input" id="" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Password</label>
                        <input type="text" name="password" class="form-input" id="" value="{{ old('password') }}">
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
                        <label for="videoChannel" class="form-label">Sexual Orientation</label>
                        <select name="sexual_orientation" class="form-input" id="">
                            <option value="" >Select One</option>
                            <option value="gay">Gay</option>
                            <option value="lesbian">Lesbian</option>
                            <option value="straight">Straight</option>
                            <option value="bisexual">Bisexual</option>
                            <option value="asexual">Asexual</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">website</label>
                        <input type="url" name="website" class="form-input" id="" value="{{ old('website') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="form-label">Bio</label>
                        <textarea name="bio" class="form-input">{{ old('bio') }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="form-label">Role</label>
                        <select name="role" class="form-input" id="">
                            @foreach ( $roles as $role )
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Display Photo</label>
                        <input type="file" name="display_photo" class="form-input" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Cover Photo</label>
                        <input type="file" name="cover_photo" class="form-input" accept="image/*">
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="crud-btn">Create USer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection