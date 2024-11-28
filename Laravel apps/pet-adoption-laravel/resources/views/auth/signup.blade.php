@extends('layouts.app')

@section('page_title')
    {{ 'Signin' }}
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
                <h2>Create Your Account</h2>
                <form action="/register" method="post">
                    @csrf
                    <label for="name">Name:</label>
                    <input type="text" id="username" name="username" placeholder="Enter your name" required>
                    <x-form-error name="username" />


                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    <x-form-error name="email" />


                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <x-form-error name="password" />


                    <div class="form-options">
                        <div class="terms-conditions">
                            <input type="checkbox" id="terms" name="terms" required>
                            <label for="terms">I accept the <a href="tos" target="_blank">Terms of
                                    Service</a> & <a href="privacy-policy" target="_blank">Privacy
                                    Policy</a></label>
                        </div>
                    </div>


                    <button type="submit" class="btn">Signup</button>

                </form>

                <div class="login-option">
                    <p>Already have an account? <a href="login">Log In</a></p>
                </div>
            </section>
        </div>
    </main>
@endsection

@section('footer1')
    {{-- to show small footer1 --}}
@endsection
