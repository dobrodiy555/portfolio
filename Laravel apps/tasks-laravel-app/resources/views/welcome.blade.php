@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="title m-b-md">
            Tasks Laravel App
        </div>

        <!-- Add the registration button here -->
        @guest
            <div class="mt-4">
                <a href="/login" class="btn">Login</a>
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
@endsection
