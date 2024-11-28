@extends('layouts.app')

@section('page_title')
    {{ 'Login' }}
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
            <section class="login-section">
                <h2>Login to Your Account</h2>
                <form action="/login" method="post">
                    @csrf
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" placeholder="Enter your email" required>

                    <x-form-error name="email" />

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>

                    <x-form-error name="password" />


                    <div class="form-options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember-me" name="remember-me">
                            <label for="remember-me">Remember Me</label>
                        </div>
                        <a href="#">Forgot Password?</a>
                    </div>

                    <button type="submit">Login</button>
                </form>

                <div class="signup-option">
                    <p>Don't have an account? <a href="signup">Sign Up</a></p>
                </div>
            </section>
        </div>
    </main>
@endsection

@section('footer1')
@endsection
