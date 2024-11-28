@extends('layouts.app')

@section('page_title')
    {{ 'Success' }}
@endsection


@section('css')
    <link rel="stylesheet" href="{{ asset('css/signin-styles.css') }}">
    <style>
        img {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .success-section {
            justify-content: center;
            text-align: center;
            align-items: center;
        }

        .success-section h2 {
            margin-top: 30px;
            font-size: 38px;
            color: #8B0000;
            margin-bottom: 10px;
        }

        .success-section p {
            margin-top: 40px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .success-section a {
            color: #8B0000;
            text-decoration: none;
        }
    </style>
@endsection

@section('header1')
    {{-- inlcluded this to show different headers in app.blade.php --}}
@endsection

@section('content')
    <main>
        <div>
            <section class="success-section">
                <h2>Your Application Was Received!</h2>
                <p>Return back to <a href="home">Home Page</a></p>
            </section>
        </div>
    </main>
@endsection

@section('footer-none')
    {{-- empty footer --}}
@endsection
