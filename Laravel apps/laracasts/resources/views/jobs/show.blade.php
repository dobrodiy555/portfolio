<x-layout>
    <x-slot:heading>
        Job page
    </x-slot:heading>
    <h1 class='font-bold text-lg'>{{ $job['title'] }}</h1>
    <p>This job pays {{ $job['salary'] }} per year</p>

    {{-- @can('edit-job', $job) for Gate --}}
    @can('edit', $job)
        <x-button class="mt-5" href="/jobs/{{ $job->id }}/edit">Edit Job</x-button>
    @endcan


    {{-- @can('delete', $job) --}}
    <form method="POST" action="/jobs/{{ $job->id }}" id="delete-form" class="mt-5">
        @csrf
        @method('DELETE')
        <x-form-button
            class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete
            Job</x-form-button>
    </form>
    {{-- @endcan --}}

    </div>

</x-layout>
