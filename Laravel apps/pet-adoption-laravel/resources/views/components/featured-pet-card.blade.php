@props(['pet'])
<div class="pet-card">
    <a href="/adopt"><img src="{{ asset("storage/" . $pet->photo) }}" alt="Featured Pet"></a>
    <h3>{{ $pet->name  }}</h3>
    <p>{{ $pet->breed  }}</p>
    <a href="/adopt" class="adopt-btn">Adopt Me</a>
    @can('delete', $pet)
        <x-delete-form :item="$pet" type="pet" />
    @endcan
</div>
