@props(['employer', 'width' => 90])
{{--default width for logo will be 90, but if we want to have other, we pass it as a prop eg. <x-employer-logo :width="42" />--}}

@if (str_contains($employer->logo, 'placeholder'))
    <img src="http://picsum.photos/seed/{{ rand(1, 10000) }}/{{ $width }}" alt="" class="rounded-xl">
@else
    <img src="{{ asset("storage/" . $employer->logo) }}" width="{{ $width }}" class="rounded-xl" alt="">
@endif


