@extends('layouts.app')

@section('page_title')
    {{ 'Put a Pet' }}
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
        <h2>Put Pet Application</h2>
        <form action="/put-pet" method="post" enctype="multipart/form-data">
        @csrf

            <label for="type">Type of Pet</label>
            <select id="type" name="type" required>
                <option value="dog">Dog</option>
                <option value="cat">Cat</option>
            </select>
            <x-form-error name="type" />

            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter name of the animal" required>
            <x-form-error name="name" />

            <label for="age">Age</label>
            <input type="number" id="age" name="age" min="1" max="25" style="width:50px;height: 20px; margin-bottom: 18px;" required>
           <x-form-error name="age" />

            <label for="breed">Breed</label>
            <input type="text" id="breed" name="breed" placeholder="Enter breed of the animal" required>
            <x-form-error name="breed" />

            <label for="gender">Gender</label>
            <select name="gender" id="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
           <x-form-error name="gender" />

        <div style="margin-bottom: 10px;">
            <label for="featured">Featured</label>
            <input type="checkbox" id="featured" name="featured">
        </div>
         <x-form-error name="featured" />

        <label for="photo">Photo</label>
        <input type="file" id="photo" name="photo" required>
        <x-form-error name="photo" />

        <button type="submit" class="btn">Submit Application</button>
        </form>
    </section>
    </div>
    </main>
@endsection

@section('footer1')
@endsection