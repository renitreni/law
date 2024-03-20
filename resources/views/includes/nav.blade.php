<nav class="navbar px-md-0 navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <div style="display:flex; align-items:center;">
            <img class="mr-2" style="width: 30px;height:30px;" src="{{ asset('images/icon.png') }}" alt="">
            <a class="navbar-brand" href="{{ url('/') }}">Meshari Alhumaidi <span>Law Firm C.R. 7035781330</span></a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
            aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> &#9776;
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ Request::is('/') ? 'active' : '' }}"><a href="{{ url('/') }}" class="nav-link">Home</a></li>
                <li class="nav-item {{ Request::is('about') ? 'active' : '' }}"><a href="{{ url('/about') }}" class="nav-link">About</a></li>
                <li class="nav-item {{ Request::is('attorneys') ? 'active' : '' }}"><a href="{{ url("/attorneys") }}" class="nav-link">Attorneys</a></li>
                <li class="nav-item {{ Request::is('list-services') ? 'active' : '' }}"><a href="{{ url("/list-services") }}" class="nav-link">Services</a></li>
                <li class="nav-item {{ Request::is('gallery') ? 'active' : '' }}"><a href="{{ url("/gallery") }}" class="nav-link">Gallery</a></li>
                <li class="nav-item {{ Request::is('contact') ? 'active' : '' }}"><a href="{{ url("/contact")}}" class="nav-link">Contact</a></li>
                <li class="nav-item cta "><a href="{{ url("/inquire")}}" class="nav-link">Inquire Now</a></li>
                <li class="nav-item  text-light">
                    <details class="p-2" style="position: absolute;top:5px;">
                        <summary class="nav-link">--</summary>
                        <ul>
                            <li><a class="text-light" href="#">English</a></li>
                            <li><a class="text-light" href="#">Arabic</a></li>
                        </ul>
                    </details>
                </li>
            </ul>
        </div>
    </div>
</nav>
