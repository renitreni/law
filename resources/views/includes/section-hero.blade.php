<div class="hero-section keen-slider" id="keen_slider">
    @php
        $links = [
            "https://images.unsplash.com/photo-1481151500463-1fa2dd2d5dbe?q=80&w=1651&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
            "https://images.unsplash.com/photo-1505664194779-8beaceb93744?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
            "https://images.unsplash.com/photo-1509964199763-e8c2f6549853?q=80&w=1476&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
        ]
    @endphp
    @foreach ($links as $link )
    <img class="keen-slider__slide" src="{{ $link }}" alt="hero-bg">
    @endforeach
    <div class="hero-color-bg"></div>

    <!-- content -->
    <div class="hero-content">
        <div>
            <h4> MESHARI ALHUMAIDI LAW FIRM</h4>
            <!-- <h6> LAW FIRM </h6> -->
            <p>We have help thousands of people to get relief from national wide fights wrongfull denials. Now they
                trusted legalcare attorneys.</p>

            <div data-aos="fade-up" class="call-to-action">
                <a class="btn btn-primary" href="{{ route('inquire',['lang'=>$lang]) }}">
                    <span>INQUIRE NOW</span>
                    <!-- <i class='bx bx-chevron-right'></i>  -->
                </a>
                <a class="btn btn-primary" href="{{ route('services',['lang'=>$lang]) }}">
                    <span>SERVICES</span>
                    <!-- <i class='bx bxs-briefcase bx-xs'></i> -->
                </a>
            </div>
        </div>
    </div>
</div>
