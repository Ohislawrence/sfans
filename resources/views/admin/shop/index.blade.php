@extends('layouts.guest')
@section('title',  'Shop Items' )
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
                <h2 class="crud-title">Shop LInks</h2>
                <button class="crud-btn" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="fas fa-plus"></i>
                    Add Item
                </button>
            </div>

            <table class="crud-table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>URL</th>
                        <th>From</th>
                        <th>Cost</th>
                        <th>Tangible?</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $items as $item )
                    <tr>
                        <td>{{ $item->name  }}</td>
                        <td>{{ $item->url }}</td>
                        <td>{{ $item->offer_by }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->is_tangible }}</td>
                        <td>
                            <div class="crud-actions">
                                <button class="crud-action-btn edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="crud-action-btn delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @include('admin.shop.include')
                    @endforeach
                    
                    
                </tbody>
            </table>
            {{ $items->links('vendor.pagination.custom') }}
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
                <form action="{{ route('admin.shop.store') }}" class="crud-form" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Name</label>
                        <input type="text" name="name" class="form-input" id="" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Link</label>
                        <input type="url" name="url" class="form-input" id="" value="{{ old('url') }}">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Images</label>
                        <input type="file" name="images[]" class="form-input" id="" multiple>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Offer By</label>
                        <input type="text" name="offer_by" class="form-input" id="" value="{{ old('offer_by') }}">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Cost</label>
                        <input type="text" name="price" class="form-input" id="" value="{{ old('price') }}">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Discount</label>
                        <input type="text" name="discount" class="form-input" id="" value="{{ old('discount') }}">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Promote Code</label>
                        <input type="text" name="promo_code" class="form-input" id="" value="{{ old('promo_code') }}">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Countries</label>
                        <select name="countries[]" class="form-input form-select form-select-solid" multiple="" aria-label="Select a country" data-control="select2">
                            @foreach ( $countries as $country)
                            <option value="{{ $country->id }}">{{ $country->country }}</option>
                            @endforeach
                        </select>
                        
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Tags</label>
                        <textarea name="tags[]" class="form-input">{{ old('tags') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Description</label>
                        <textarea name="description" class="form-input">{{ old('description') }}</textarea>
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