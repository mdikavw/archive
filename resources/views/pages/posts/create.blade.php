@extends('layouts.app')

@section('content')
    <h2>Create a post</h2>
    <form class="create-form" id="post-form" action="/posts/store" method="POST">
        @csrf
        <div class="dropdown">
            <button class="dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown">
                Select a community
            </button>
            <div class="dropdown-menu">
                @foreach (Auth::user()->drawers as $drawer)
                    <div class="dropdown-item" data-value="{{ $drawer->id }}">{{ $drawer->name }}</div>
                @endforeach
            </div>
        </div>
        <input id="post-community" name="post-community" type="hidden">
        <div class="form-floating">
            <input class="form-control" id="post-title" name="title" type="text" placeholder="Enter your title">
            <label for="title">
                Title
            </label>
        </div>
        <textarea class="ck-content" id="post-content" name="post-content"></textarea>
        <button>Submit</button>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.dropdown-item').on('click', function(e) {
                let selectedText = $(this).text()
                let selectedValue = $(this).data('value')
                $('#dropdownMenuButton').text(selectedText)
                $('#post-community').val(selectedValue)
            });
        });
    </script>
@endpush
