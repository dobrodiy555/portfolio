@props(['job'])

<x-panel class="flex gap-x-6">
    <div>
        {{--<img src="http://placehold.it/90/90" alt="" class="rounded-xl">--}}
        <x-employer-logo :employer="$job->employer"/>
    </div>

    <div class="flex-1 flex flex-col">
        <a href="#" class="self-start text-sm text-gray-400">{{ $job->employer->name }}</a>
        <h3 class="group-hover:text-blue-600 font-bold text-xl mt-2 transition-colors duration-300">
            <a href="{{ $job->url }}">{{ $job->title }}</a>
        </h3>
        <p class="text-sm text-gray-400 mt-auto">{{ $job->salary }}</p>
    </div>

    <div class="flex flex-wrap gap-2 items-start">
        @foreach($job->tags as $tag)
            <x-tag :$tag />
            {{--<x-tag size="small">Manager</x-tag>--}}
        @endforeach

        @can('update', $job)
                <a href="/jobs/{{ $job->id }}">
                    <x-edit-button>Edit Job</x-edit-button>
                </a>
        @endcan

    </div>
</x-panel>