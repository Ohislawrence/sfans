@extends('layouts.guest')
@section('title',  'Affiliate Links' )
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
                <h2 class="crud-title">Affiliate Links</h2>
                <button class="crud-btn" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="fas fa-plus"></i>
                    Add Link
                </button>
            </div>

            <table class="crud-table">
                <thead>
                    <tr>
                        <th>Offer Name</th>
                        <th>Link</th>
                        <th>From</th>
                        <th>Smartlink?</th>
                        <th>Tangible?</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $afflinks as $afflink )
                    <tr>
                        <td>{{ $afflink->offer_name  }}</td>
                        <td>{{ $afflink->link }}</td>
                        <td>{{ $afflink->offer_by }}</td>
                        <td>{{ $afflink->is_smartlink }}</td>
                        <td>{{ $afflink->is_tangible }}</td>
                        <td>
                            <div class="crud-actions">
                                <button class="crud-action-btn edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $afflink->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="crud-action-btn delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $afflink->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @include('admin.affiliatelink.include')
                    @endforeach
                    
                    
                </tbody>
            </table>
            {{ $afflinks->links('vendor.pagination.custom') }}
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
                    Add Link
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.affiliatelink.store') }}" class="crud-form" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Name</label>
                        <input type="text" name="offer_name" class="form-input" id="" value="{{ old('offer_name') }}">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Link</label>
                        <input type="url" name="link" class="form-input" id="" value="{{ old('link') }}">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Offer By</label>
                        <input type="text" name="offer_by" class="form-input" id="" value="{{ old('offer_by') }}">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Cost</label>
                        <input type="text" name="cost" class="form-input" id="" value="{{ old('cost') }}">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Media</label>
                        <input type="text" name="media" class="form-input" id="" value="{{ old('media') }}">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Media Dimension</label>
                        <input type="text" name="media_dimension" class="form-input" id="" value="{{ old('media_dimension') }}">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Countries</label>
                        <select name="coutries[]" class="form-input form-select form-select-solid" multiple="" aria-label="Select a country" data-control="select2">
                            @foreach ( $countries as $country)
                            <option value="{{ $country->code }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Tags</label>
                        <textarea name="tags" class="form-input">{{ old('tags') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Is smartlink</label>
                        <select name="is_smartlink" class="form-input" id="">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Is Tangible</label>
                        <select name="is_tangible" class="form-input" id="">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="crud-btn">Add Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection