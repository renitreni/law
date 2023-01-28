<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <a href="#" class="nav_logo">
                <i class='bx bx-layer nav_logo-icon'></i>
                <span class="nav_logo-name">LawFirm Name</span>
            </a>
            <div class="nav_list">
                <a href="#" class="nav_link active">
                    <i class='bx bx-grid-alt nav_icon' title="Timesheet"></i>
                    <span class="nav_name">Timesheet</span>
                </a>
                <a href="#" class="nav_link">
                    <i class='bx bx-user nav_icon' title="Users"></i>
                    <span class="nav_name">Users</span>
                </a>
                <a href="#" class="nav_link">
                    <i class='bx bx-message-square-detail nav_icon' title="Messages"></i>
                    <span class="nav_name">Messages</span>
                </a>
                <a href="#" class="nav_link">
                    <i class='bx bx-bookmark nav_icon' title="Bookmark"></i>
                    <span class="nav_name">Bookmark</span>
                </a>
                <a href="#" class="nav_link">
                    <i class='bx bx-folder nav_icon' title="Files"></i>
                    <span class="nav_name">Files</span>
                </a>
                <a href="#" class="nav_link">
                    <i class='bx bx-bar-chart-alt-2 nav_icon' title="Stats"></i>
                    <span class="nav_name">Stats</span>
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
