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
                <h2 class="crud-title">Just Slut</h2>
            </div>

            <table class="crud-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Users Engaged</th>
                        <th>Personality</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $sluts as $slut )
                    <tr>
                        <td>{{ $slut->name }}</td>
                        <td>{{ $slut->username }}</td>
                        <td>TBD</td>
                        <td>TBD</td>
                        <td>
                            <div class="crud-actions">
                                <button onclick="location.href='{{ route('admin.bots.train.form', $slut->username) }}'" class="crud-action-btn edit" >
                                    Train
                                </button>
                                <button onclick="location.href='{{ route('chat',['botUserId' => $slut->username]) }}','_blank'" class="crud-action-btn delete" >
                                    Chat
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    
                    
                </tbody>
            </table>
            {{ $sluts->links('vendor.pagination.custom') }}
        </div>
    </div>
</main>



@endsection