<nav class="navbar px-md-0 navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Meshari Alhumaidi <span>Law Firm C.R. 7035781330</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
            aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ Request::is('/') ? 'active' : '' }}"><a href="{{ url('/') }}" class="nav-link">Home</a></li>
                <li class="nav-item {{ Request::is('about') ? 'active' : '' }}"><a href="{{ url('/about') }}" class="nav-link">About</a></li>
                <li class="nav-item {{ Request::is('attorneys') ? 'active' : '' }}"><a href="{{ url("/attorneys") }}" class="nav-link">Attorneys</a></li>
                <li class="nav-item {{ Request::is('gallery') ? 'active' : '' }}"><a href="{{ url("/gallery") }}" class="nav-link">Gallery</a></li>
                <li class="nav-item {{ Request::is('contact') ? 'active' : '' }}"><a href="{{ url("/contact")}}" class="nav-link">Contact</a></li>
                <li class="nav-item cta "><a href="{{ url("/inquire")}}" class="nav-link">Inquire Now</a></li>
            </ul>
        </div>
    </div>
</nav>
