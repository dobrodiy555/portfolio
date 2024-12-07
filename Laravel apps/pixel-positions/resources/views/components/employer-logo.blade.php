@props(['employer', 'width' => 90])

@if (str_contains($employer->logo, 'placeholder'))
    <img src="http://picsum.photos/seed/{{ rand(1, 10000) }}/{{ $width }}" alt="" class="rounded-xl">
@else
    <img src="{{ asset("storage/" . $employer->logo) }}" width="{{ $width }}" class="rounded-xl" alt="">
@endif


