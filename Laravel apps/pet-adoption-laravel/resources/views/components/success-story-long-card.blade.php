@props(['story', 'counter'])
<div class="long-story-card" id="story{{ $counter }}">
    <div class="long-story-content">
        <h3>{{ $story->title }}</h3>
        @foreach (explode("\n", $story->text) as $line)
            @if (trim($line) !== '')
                <p>{{ strip_tags($line) }}</p>
            @endif
        @endforeach
    </div>
    <img src="{{ asset('storage/' . $story->photo) }}" alt="{{ $story->title }}">
    @if (auth()->user()->is_admin)
        <x-delete-form :item="$story" type="story" />
    @endif
</div>