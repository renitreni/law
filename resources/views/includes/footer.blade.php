<footer class="ftco-footer ftco-bg-dark ftco-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="logo"><a href="#">Meshari Alhumaidi <span>A Law Firm Agency</span></a></h2>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there
                        live the blind texts.</p>
                    <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                        <li class="ftco-animate"><a href="https://www.twitter.com"><span
                                    class="icon-twitter"></span></a></li>
                        <li class="ftco-animate"><a href="https://www.facebook.com"><span
                                    class="icon-facebook"></span></a></li>
                        <li class="ftco-animate"><a href="https://www.instagram.com"><span
                                    class="icon-instagram"></span></a></li>
                        <li class="ftco-animate"><a href="https://www.linkedin.com/company/meshari-alhumaidi-law/"><span
                                    class="icon-linkedin"></span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md">
                <div class="ftco-footer-widget mb-4 ml-md-5">
                    <h2 class="ftco-heading-2">Practice Areas</h2>
                    <ul class="list-unstyled">
                        <li><a href="#" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Family
                                Law</a></li>
                        <li><a href="#" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Business
                                Law</a></li>
                        <li><a href="#" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Insurance
                                Law</a></li>
                        <li><a href="#" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Criminal
                                Law</a></li>
                        <li><a href="#" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Drug
                                Offenses</a></li>
                        <li><a href="#" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Fire
                                Accident</a></li>
                        <li><a href="#" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Employment
                                Law</a></li>
                        <li><a href="#" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Property
                                Law</a></li>

                    </ul>
                </div>
            </div>
            <div class="col-md">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">Have a Questions?</h2>
                    <div class="block-23 mb-3">
                        <ul>
                            <li>
                                <span class="icon icon-map-marker"></span>
                                <span class="text">P.O.Box : 2588, <br>Postal
                                    Code: 31991, Kingdom of Saudi Arabia.
                                </span>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="icon icon-phone"></span>
                                    <span class="text">0558682149</span>
                                </a>
                            </li>
                            <li>
                                <span>Riyadh Branch</span>
                                <a href="#">
                                    <span class="icon icon-phone"></span>
                                    <span class="text">0500550113</span>
                                </a>
                            </li>

                            <li>
                                <span>Al Jubali Branch</span>
                                <a href="#">
                                    <span class="icon icon-phone"></span>
                                    <span class="text">0531113885</span>
                                </a>
                            </li>

                            <li>
                                <span>Hafr Al Batin Branch</span>
                                <a href="#">
                                    <span class="icon icon-phone"></span>
                                    <span class="text">0500922283</span>
                                </a>
                            </li>
                            @php
                            $emails = [
                            "info@mesharialhumlaw.com",
                            ]
                            @endphp
                            @foreach ($emails as $email )
                            <li>
                                <a href="mailTo:{{ $email }}">
                                    <span class="icon icon-envelope"></span>
                                    <span class="text">{{ $email }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">Business Hours</h2>
                    <div class="opening-hours">
                        <h4>Opening Days:</h4>
                        <p class="pl-3">
                            <span>Sunday – Thursday : 9AM to 7PM</span>
                        </p>
                        <h4>Vacations:</h4>
                        <p class="pl-3">
                            <span>Ramadan</span><br>
                            <span>First Shift: 9AM to 1PM</span><br>
                            <span>Second Shift: 8PM to 1AM</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">

                <p>
                    Copyright &copy;<script>
                        document.write(new Date().getFullYear());
                    </script>. Meshari Alhumaidi Law Firm.
                </p>
            </div>
        </div>
    </div>
</footer>



<!-- loader -->
<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
            stroke="#7495ff" />
    </svg>
</div>

<script src="{{ asset('theme/js/jquery.min.js') }}"></script>
<script src="{{ asset('theme/js/jquery-migrate-3.0.1.min.js') }}"></script>
<script src="{{ asset('theme/js/popper.min.js') }}"></script>
<script src="{{ asset('theme/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('theme/js/jquery.easing.1.3.js') }}"></script>
<script src="{{ asset('theme/js/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('theme/js/jquery.stellar.min.js') }}"></script>
<script src="{{ asset('theme/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('theme/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('theme/js/aos.js') }}"></script>
<script src="{{ asset('theme/js/jquery.animateNumber.min.js') }}"></script>
<script src="{{ asset('theme/js/scrollax.min.js') }}"></script>
<script src="{{ asset('theme/js/main.js') }}"></script>
