@props(['job'])
<form method="POST" action="/jobs/{{ $job->id }}" id="delete-form">
    @csrf
    @method('DELETE')
    <x-forms.delete-button>Delete Job</x-forms.delete-button>
</form>