@extends('layouts.app')

@section('page_title')
    {{ 'Pets' }}
@endsection


@section('css')
    <link rel="stylesheet" href="{{ asset('css/browse-pets-styles.css') }}">
    <style>
        *::selection {
            background-color: #3d3d3d;
            color: whitesmoke;
        }
    </style>
@endsection

@section('content')
    <main>
        <section class="browse-pets">
            <section class="heroo">
                <div class="hero-container">
                    <h1>Browse Pets</h1>
                    <div class="hero-buttons">
                        <a href="#dogs"><button>Dogs</button></a>
                        <a href="#cats"><button>Cats</button></a>
                    </div>
                </div>
            </section>

            <div class="pet-listings">
                <h2 id="dogs">Dogs</h2>
                <div class="pet-grid">
                    @foreach($dogs as $dog)
                        <x-pet-card :pet="$dog" :counter="$loop->iteration" />
                        @if ($loop->iteration % 3 === 0 && !$loop->last)
                             </div>
                             <div class="pet-grid">
                       @endif
                    @endforeach
                </div>

                <h2 id="cats">Cats</h2>
                <div class="pet-grid">
                    @php $catCounter = 1; @endphp
                    @foreach($cats as $cat)
                        <x-pet-card :pet="$cat" :counter="$loop->iteration" />
                        @if ($loop->iteration % 3 === 0 && !$loop->last)
                            </div>
                            <div class="pet-grid">
                        @endif
                    @endforeach
                </div>

            </div>
        </section>
    </main>
@endsection
