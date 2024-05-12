<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <a href="#" class="nav_logo">
                <i class='bx bx-layer nav_logo-icon'></i>
                <span class="nav_logo-name">{{ config('app.name') }}</span>
            </a>
            <div class="nav_list">
                <a href="{{ route('timesheet') }}" wire:click="$set('menu', 'timesheet')"
                    class="nav_link @if ($this->menu == 'timesheet') active @endif">
                    <i class='bx bxs-calendar-event nav_icon' title="Timesheet"></i>
                    <span class="nav_name">Timesheet</span>
                </a>
                <a href="{{ route('matters') }}" wire:click="$set('menu', 'matters')"
                    class="nav_link @if ($this->menu == 'matters') active @endif">
                    <i class='bx bx-slider nav_icon' title="Matters"></i>
                    <span class="nav_name">Matters</span>
                </a>
                <a href="{{ route('options') }}" wire:click="$set('menu', 'options')"
                    class="nav_link @if ($this->menu == 'options') active @endif">
                    <i class='bx bx-slider nav_icon' title="Options"></i>
                    <span class="nav_name">Options</span>
                </a>
                <a href="{{ route('case') }}" wire:click="$set('menu', 'case')"
                    class="nav_link @if ($this->menu == 'case') active @endif">
                    <i class='bx bx-copy-alt nav_icon' title="Case"></i>
                    <span class="nav_name">Case</span>
                </a>
                <a href="{{ route('inquiry') }}" wire:click="$set('menu', 'inquiry')"
                    class="nav_link @if ($this->menu == 'inquiry') active @endif">
                    <i class='bx bx-mail-send nav_icon' title="Inquiry"></i>
                    <span class="nav_name">Inquiry</span>
                </a>
                <a href="{{ route('gallery') }}" wire:click="$set('menu', 'gallery')"
                    class="nav_link @if ($this->menu == 'gallery') active @endif">
                    <i class='bx bx-photo-album nav_icon' title="Gallery"></i>
                    <span class="nav_name">Gallery</span>
                </a>
                <a href="{{ route('invoice') }}" wire:click="$set('menu', 'invoice')"
                class="nav_link @if ($this->menu == 'invoice') active @endif">
                <i class='bx bx-receipt nav_icon' title="Invoice"></i>
                <span class="nav_name">Invoice</span>
            </a>
                <a href="{{ route('user') }}" class="nav_link">
                    <i class='bx bx-user nav_icon' title="Users"></i>
                    <span class="nav_name">Users</span>
                </a>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav_link btn btn-link" style="
            text-decoration: none;">
                <i class='bx bx-log-out nav_icon'></i>
                <span class="nav_name">SignOut</span>
            </button>
        </form>
    </nav>
</div>
