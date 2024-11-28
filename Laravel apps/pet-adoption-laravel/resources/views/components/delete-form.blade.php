@props(['pet'])
<form action="/browse-pets/{{ $pet->id }}" method="post">
    @csrf
    @method('delete')
    <button style="background: red; color: white; padding: 5px 7px; font-size: 12px; border: none; cursor:pointer;">
        Delete
    </button>
</form>
