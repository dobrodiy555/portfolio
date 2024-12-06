@extends('layouts.app')

@section('page_title')
    {{ 'Success stories' }}
@endsection


@section('css')
    <link rel="stylesheet" href="{{ asset('css/success-stories-styles.css') }}">
    <style>
        *::selection {
            background-color: #3d3d3d;
            color: whitesmoke;
        }
    </style>
@endsection

@section('content')
    <main>
        <section class="stories-grid">
            @foreach ($successStories as $story)
                <x-success-story-small-card :story="$story" :counter="$loop->iteration" />
            @endforeach
                <div class="pagination">{{ $successStories->links() }}</div>
        </section>

        @foreach ($successStories as $story)
            <x-success-story-long-card :story="$story" :counter="$loop->iteration" />
        @endforeach

        <section class="share-story">
            <h2>Share Your Story</h2>
            <p>Have you adopted a pet from our shelter? We'd love to hear your story and share it with our
                community.<br />Share now at <a id="slink"
                    href="mailto:shareyourstory@pawfectpawtails.org">shareyourstory@pawfectpawtails.org</a></p>

            @auth
                @if (auth()->user()->is_admin)
                    <a href="/success-stories-add">
                        <button style="margin: 0 auto;">Add Success Story</button>
                    </a>
                @endif
            @endauth
        </section>
    </main>
@endsection
