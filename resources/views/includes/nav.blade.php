<!-- Top Nav -->
<div class="w-100 py-2 bg-dark-blue">
    <div class="container flex-wrap d-flex justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <div>
                <a href=""><i class='bx bxl-twitter'></i></a>
                <a href=""><i class='bx bxl-linkedin-square'></i></a>
            </div>

            <div class="ml-2">
                <span class="text-sm">Law Firm C.R. 7035781330 </span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <div class="lang">
                @if ($lang == "en")
                    <a href="{{ route('welcome',['lang'=>'ar']) }}">Arabic</a>
                @else
                    <a href="{{ route('welcome',['lang'=>'en']) }}">English</a>
                @endif
            </div>
            <div class="lang ml-2">
                <a class="btn btn-primary" href="{{ route('inquire',['lang'=>$lang]) }}">Inquire Now</a>
            </div>
        </div>
    </div>
</div>
<!-- END -->

<!-- NAV -->
<nav class="navbar navbar-expand-lg py-4">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="{{ asset('images/icon.png') }}" width="36" /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarUnderlineExample" aria-controls="navbarExample" aria-expanded="false"
            aria-label="Toggle navigation">
            <i class='bx bx-menu'></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarUnderlineExample">
            <ul class="navbar-nav navbar-nav-underline">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('welcome',['lang'=>$lang]) }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about',['lang'=>$lang]) }}">About</a>
                </li>
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Projects</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('attorneys',['lang'=>$lang]) }}">Attorneys</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('services',['lang'=>$lang]) }}">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('galleries',['lang'=>$lang]) }}">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact',['lang'=>$lang]) }}">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- END -->
