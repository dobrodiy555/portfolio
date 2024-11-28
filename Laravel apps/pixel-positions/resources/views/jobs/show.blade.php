{{--@props(['job'])--}}
<x-layout>
           @can('update', $job)

            <x-forms.form method="POST" action="/jobs/{{ $job->id }}">

                @method('PATCH')

                <x-forms.input label="Title" name="title" value="{{ $job->title  }}" />

                <x-forms.input label="Salary" name="salary" value="{{ $job->salary }}" />

                <x-forms.input label="Location" name="location" value="{{ $job->location }}" />

                <x-forms.select label="Schedule" name="schedule">
                    @php
                      $schedule = $job->schedule;
                    @endphp
                    <option class="bg-black/90" value="Full Time" {{ $schedule === 'Full Time' ? 'selected' : '' }}>Full Time</option>
                    <option class="bg-black/90" value="Part Time" {{ $schedule === 'Part Time' ? 'selected' : '' }}>Part Time</option>
                </x-forms.select>

                <x-forms.input label="URL" name="url" value="{{ $job->url }}" />

                <x-forms.divider />
                

                <x-forms.checkbox label="Feature Job (extra cost)" name="featured" :checked="$job->featured" />

                @php
                  $tags = '';
                  foreach ($job->tags as $tag) {
                    $tags .= $tag->name . ", ";
                  }
                  $tags = rtrim($tags, ", "); // deletes last comma
                @endphp

                <x-forms.input label="Tags (comma separated)" name="tags" value="{{ $tags }}" />

                <x-forms.button>Save changes</x-forms.button>

            </x-forms.form>
        @endcan

        @can('delete', $job)
            <div style="position:relative;left:47vw;bottom:6vh;">
                <x-forms.delete-form :$job />
            </div>
        @endcan


</x-layout>






