<section class="hero-wrap mb-2 hero-wrap-2" style="background-image: url({{ asset('theme/images/bg_1.jpg') }});"
    data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <h1 class="mb-3 bread">{{ $page }}</h1>
                <p class="breadcrumbs">
                    <span class="mr-2">
                        <a href="{{ url('/') }}">Home
                        <i class="ion-ios-arrow-forward"></i>
                        </a>
                    </span>
                    <span>{{ $page }}
                        {{-- <i class="ion-ios-arrow-forward"></i> --}}
                    </span>
                </p>
            </div>
        </div>
    </div>
</section>
