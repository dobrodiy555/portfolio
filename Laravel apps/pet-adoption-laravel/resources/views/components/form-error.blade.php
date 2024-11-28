@props(['name'])
@error($name)
    <p class="error-field" style="color:red;">{{ $message }}</p>
@enderror
