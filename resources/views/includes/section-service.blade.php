<div class="container mt-5">
    <div class="row">
        <div data-aos="fade-up" class="col-md-3 p-3 why-us-card">
            <h4>Why Select Us?</h4>
            <p>Our firm is known for unparalleled legal acumen, dedicated client service, and superior outcomes.</p>

            <div>
                <h6>Need to check more?</h6>
                <a href="{{ route('services',['lang'=>$lang]) }}">Read other services</a>
            </div>
        </div>
        <div class="col-md-9 d-flex flex-column p-3 services-card">
            <div data-aos="fade-up" class="p-2 mt-1 service-content-container">
                <div class="service_img ">
                    <img class="img-fluid"
                        src="{{ asset('images/justice.png') }}"
                        alt="Justice">
                </div>
                <div  class="service_content d-flex flex-column">
                    <h5>Fight for Justice</h5>
                    <small>Pursuing justice globally represents a substantial emotional commitment and investment in
                        answering this vocation.</small>
                </div>
            </div>

            <div data-aos="fade-up" class="p-2 mt-1 service-content-container">
                <div class="service_img ">
                    <img class="img-fluid"
                        src="{{ asset('images/bcs.png') }}"
                        alt="Best Case Strategy">
                </div>
                <div class="service_content d-flex flex-column">
                    <h5>Best Case Strategy</h5>
                    <small>Striving for justice worldwide entails a profound emotional dedication and a significant
                        investment as we heed this calling.</small>
                </div>
            </div>

            <div data-aos="fade-up" class="p-2 mt-1 service-content-container">
                <div class="service_img ">
                    <img class="img-fluid"
                        src="{{ asset('images/attorney.png') }}"
                        alt="Attorney">
                </div>
                <div class="service_content d-flex flex-column">
                    <h5>Experienced Attorney</h5>
                    <small>Pursuing justice globally requires a significant emotional commitment and investment as
                        we respond to this calling.</small>
                </div>
            </div>
        </div>
    </div>
</div>
