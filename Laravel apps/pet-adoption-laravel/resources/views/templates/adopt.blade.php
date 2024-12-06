@extends('layouts.app')

@section('page_title')
    {{ 'Adopt' }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adopt-styles.css') }}">
    <style>
        *::selection {
            background-color: #3d3d3d;
            color: whitesmoke;
        }
    </style>
@endsection

@section('content')
    <main>
        <section class="adopt-section">
            <h1>Adopt a Pet</h1>
            <p>Give a loving home to a furry companion and change a life forever.</p>

            <div class="adopt-steps">
                <div class="step">
                    <img src="images/browse.png" alt="Browse Icon">
                    <h3>Browse Pets</h3>
                    <p>Search for your perfect match by browsing our available pets.</p>
                    <a href="browse-pets" class="btn">Browse Pets</a>
                </div>
                <div class="step">
                    <img src="images/apply.png" alt="Apply Icon">
                    <h3>Apply to Adopt</h3>
                    <p>Complete our online application form to begin the adoption process.</p>
                    <a href="#adoption-form" class="btn">Apply Now</a>
                </div>
                <div class="step">
                    <h3>Meet and Greet</h3>
                    <p>Schedule a meet-and-greet to ensure a perfect match with your new furry friend.</p>
                    <a href="adoption-process" class="btn">Learn More</a>
                </div>
            </div>

            <div id="adoption-form">
                <h2>Adoption Application</h2>
                <form action="backend/process_adoption.php" method="post">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="pet-type">Type of Pet</label>
                        <select id="pet-type" name="pet-type" required>
                            <option value="">Select a pet type</option>
                            <option value="dog">Dog</option>
                            <option value="cat">Cat</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason for Adoption</label>
                        <textarea id="reason" name="reason" required></textarea>
                    </div>
                    <button type="submit" class="btn">Submit Application</button>
                </form>
            </div>
        </section>
    </main>
@endsection
