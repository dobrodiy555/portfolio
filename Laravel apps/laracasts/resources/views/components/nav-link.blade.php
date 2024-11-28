{{-- <a {{ $attributes }}>{{ $slot }}</a> --}}

@props(['active' => false, 'type' => 'a'])
{{--default type will be 'a' but we can change it if we want--}}

@if ($type === 'a')
    <a class="{{ $active ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium text-white"
        {{ $attributes }} aria-current="{{ $active ? 'page' : 'false' }}">{{ $slot }}</a>
@else
    <button
        class="{{ $active ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium text-white"
        {{ $attributes }} aria-current="{{ $active ? 'page' : 'false' }}">{{ $slot }}</a>
    </button>
@endif
