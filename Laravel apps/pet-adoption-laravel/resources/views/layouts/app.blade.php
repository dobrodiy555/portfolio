<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title') - Pawfect Pawtrails</title>
    <link rel="icon" type="icon/x-icon" href="images/Pawfect Pawtrails-4.png">
    @unless (\Illuminate\Support\Facades\View::hasSection('header1'))
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @endunless
    @yield('css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

@if (\Illuminate\Support\Facades\View::hasSection('header1'))
    @include('layouts.header1')
@else
    @include('layouts.header')
@endif


@if (\Illuminate\Support\Facades\View::hasSection('header1'))
    <body style="background-color: wheat;">
@else
     <body style="background-color: rgb(251, 245, 235);">
@endif

@yield('content')
</body>

<script src="js/main.js"></script>

@if (\Illuminate\Support\Facades\View::hasSection('footer1'))
    @include('layouts.footer1')
@elseif(\Illuminate\Support\Facades\View::hasSection('footer-none'))
    @include('layouts.footer-none')
@else
    @include('layouts.footer')
@endif

</html>
