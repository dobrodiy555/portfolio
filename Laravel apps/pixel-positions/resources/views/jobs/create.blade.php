<x-layout>
    <x-page-heading>New Job</x-page-heading>
    <x-forms.form method="POST" action="/jobs">

        <x-forms.input label="Title" name="title" placeholder="CEO" />

        <x-forms.input label="Salary" name="salary" placeholder="50 000 USD" />

        <x-forms.input label="Location" name="location" placeholder="NY" />
        <x-forms.select label="Schedule" name="schedule">
            <option class="bg-black/90">Part Time</option>
            <option class="bg-black/90">Full Time</option>
        </x-forms.select>

        <x-forms.input label="URL" name="url" placeholder="https://langblog.org" />

        <x-forms.checkbox label="Feature Job (extra cost)" name="featured" />

        <x-forms.divider />

        <x-forms.input label="Tags (comma separated)" name="tags" placeholder="frontend, backend" />

        <x-forms.button>Publish</x-forms.button>
    </x-forms.form>
</x-layout>