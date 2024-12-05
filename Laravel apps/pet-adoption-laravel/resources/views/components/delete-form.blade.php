@props(['item', 'type'])
<form action={{ $type === 'pet' ? "/browse-pets/$item->id" : "/success-stories/$item->id" }} method="post">
    @csrf
    @method('delete')
    <button style="background: red; color: white; padding: 5px 7px; font-size: 12px; border: none; cursor:pointer;">
        Delete {{ ucfirst($type) }}
    </button>
</form>


