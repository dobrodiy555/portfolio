@extends('layouts.app')

@section('page_title')
    {{ 'Add success story' }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/signin-styles.css') }}">
@endsection

@section('header1')
    {{-- inlcluded this to show different headers in app.blade.php --}}
@endsection

@section('content')
    <main>
        <div>
            <section class="signup-section">
                <h2>Add Success Story Form</h2>
                <form action="/success-stories-add" method="post" enctype="multipart/form-data">
                    @csrf

                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter title of the story" required>
                    <x-form-error name="title" />

                    <label for="title">Description</label>
                    <input type="text" id="description" name="description" placeholder="Enter short description of the story" required>
                    <x-form-error name="description" />

                    <label for="text">Text</label>
                    <textarea style="margin-bottom:20px;" id="text" name="text" rows="20" required></textarea>
                    <x-form-error name="text" />

                   <label for="photo">Photo</label>
                    <input type="file" id="photo" name="photo" required>
                    <x-form-error name="photo" />

                    <button type="submit" class="btn">Submit Story</button>
                </form>

            </section>
        </div>
    </main>
@endsection

@section('footer1')
@endsection
