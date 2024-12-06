@props(['pet', 'counter'])
<div class="pet-card">
    <img src="{{ asset("storage/" . $pet->photo) }}" alt="{{ ucfirst($pet->type) }} {{ $counter }}">
    <h3>{{ $pet->name  }}</h3>
    <p>Age: {{ $pet->age }} years</p>
    <p>Breed: {{ $pet->breed  }}</p>
    <p>Gender: {{ ucfirst($pet->gender)  }}</p>
    <a href="/adopt" class="adopt-btn">Adopt Me</a>
    @can('delete', $pet)
      {{--<x-delete-form :$pet />--}}
        <x-delete-form :item="$pet" type="pet" />
    @endcan
</div>
