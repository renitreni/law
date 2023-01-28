<header class="header" id="header">
    <div class="header_toggle">
        <i class='bx bx-menu' id="header-toggle"></i>
    </div>

    <div class="d-flex flex-row">
        <button type="button" wire:click="$set('state', 'month')"
            class="btn {{ $state == 'month' ? 'btn-info text-white' : 'btn-outline-info' }} mx-1">
            Month
        </button>
        <button type="button" wire:click="$set('state', 'week')"
            class="btn {{ $state == 'week' ? 'btn-info text-white' : 'btn-outline-info' }} mx-1">
            Week
        </button>
        <button type="button" wire:click="$set('state', 'day')"
            class="btn {{ $state == 'day' ? 'btn-info text-white' : 'btn-outline-info' }} mx-1">
            Day
        </button>
    </div>

    <div class="header_img"> <img src="https://i.imgur.com/hczKIze.jpg" alt=""> </div>
</header>
