<div>
    <input class="form-control" wire:model='keyword'>
    <div class="relative">
        <div class="list-group position-fixed">
            @foreach ($listing as $item)
                <button type="button" wire:click='setValue("{{ $item['value'] }}", "{{ $item['text'] }}")'
                    class="list-group-item list-group-item-action">{{ $item['text'] }}</button>
            @endforeach
        </div>
    </div>
</div>
