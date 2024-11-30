<x-layout>
    <div class="space-y-10">

        <section class="text-center pt-6">
            <h1 class="font-bold text-4xl">Let's find your next job</h1>
            {{--<form action="" class="mt-6">--}}
            {{--    <input type="text" placeholder="Web Developer..." class="rounded-xl bg-white/5 border-white/10 px-5 py-4 w-full max-w-xl">--}}
            {{--</form>--}}
            <x-forms.form method="GET" action="/search" class="mt-6">
                <x-forms.input :label="false" name="q" placeholder="Web developer..." />
            </x-forms.form>
        </section>

        <section class="pt-10">
            <x-section-heading>Featured Jobs</x-section-heading>
            <div class="grid lg:grid-cols-3 gap-8 mt-6">
                @foreach($featuredJobs as $job)
                    <x-job-card :$job />
                    {{--<x-job-card />--}}
                @endforeach
            </div>
        </section>

        <section>
            <x-section-heading>Tags</x-section-heading>
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach($tags as $tag)
                    {{--<x-tag :tag="$tag" />--}}
                    <x-tag :$tag /> {{--shorter version of above--}}
                @endforeach
            </div>
        </section>

        <section>
            <x-section-heading>Recent Jobs</x-section-heading>
            <div class="mt-6 space-y-6">
                @foreach($jobs as $job)
                    <x-job-card-wide :$job />
                    {{--<x-job-card-wide />--}}
                @endforeach
            </div>
        </section>

    </div>

</x-layout>
