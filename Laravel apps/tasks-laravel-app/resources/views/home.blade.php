@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('content')
    <div class="flex-center position-ref full-height">

        <div class="content">
            <div class="title m-b-md">
                HOME PAGE
            </div>

            @guest
                <div class="mt-4">
                    <a href="{{ route('login') }}" class="btn">Login</a>
                    <a href="{{ route('register') }}" class="btn">Register</a>
                </div>
            @endguest

            @auth
                <form action="/logout" method="post">
                    @csrf
                    <button>Log Out</button>
                </form>
            @endauth
        </div>
    </div>
@endsection
