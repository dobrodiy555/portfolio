@props(['story', 'counter'])
<div class="story-card">
    <img src="{{ asset('storage/' . $story->photo) }}" alt="{{ $story->title }}">
    <div class="story-content">
        <h3>{{ $story->title }}</h3>
        <p>{{ $story->description }}</p>
        <a href="#story{{ $counter }}" class="btn">Read More >></a>
        @can('workWithSuccessStories', $story)
            <x-delete-form :item="$story" type="story" />
        @endcan
    </div>
</div>
