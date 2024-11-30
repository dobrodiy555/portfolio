@props(['job'])
<x-panel class="flex flex-col text-center">
    <div class="self-start text-sm">{{ $job->employer->name }}</div>

    <div class="py-8">
        <h3 class="group-hover:text-blue-600 text-xl font-bold transition-colors duration-300">
            <a href="{{ $job->url }}">{{ $job->title }}</a>
        </h3>
        <p class="text-sm mt-4">{{ $job->salary }}</p>
    </div>

    <div class="flex justify-between items-center mt-auto">

        <div>
            @foreach($job->tags as $tag)
                <x-tag :$tag size="small" />
             {{--<x-tag size="small">Frontend</x-tag>--}}
            @endforeach
        </div>

        {{--<img src="http://placehold.it/42/42" alt="" class="rounded-xl">--}}
        <div>
            <x-employer-logo :employer="$job->employer" :width="42" />
        </div>

        <div>
         @can('update', $job)
            <a href="/jobs/{{ $job->id }}">
                {{--<x-employer-logo :employer="$job->employer" :width="42" />--}}
                <x-edit-button size="small">Edit Job</x-edit-button>
            </a>
          @endcan
        </div>

    </div>

</x-panel>