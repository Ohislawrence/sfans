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
                <h2 class="crud-title">Train {{ $bot->username }}</h2>
            </div>
            <form action="{{ route('admin.bots.train.store', $bot->username) }}" id="train" method="POST" enctype="multipart/form-data">
                
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 mb-2" for="training_file">
                        Training Data File (TXT)
                    </label>
                    <input type="file" name="intents" id="training_data" 
                           class="border border-gray-300 rounded-lg p-2 w-full" 
                           accept=".txt" required>
                    <p class="text-sm text-gray-500 mt-1">
                        Upload a text file with questions and answers separated by a delimiter.
                    </p>
                </div>
                
                <button type="submit" class="crud-btn">
                    Train {{ $bot->username }}
                </button>
            </form>
        </div>
    </div>
</main>
@endsection