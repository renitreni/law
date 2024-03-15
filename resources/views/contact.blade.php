@extends('layouts.guest.index')
@section('title',"Contact | Meshari Alhumaidi Law Firm")
@section('contents')
@include('includes.pages-hero-breadcrumbs',['page'=>'Contact','bg'=>asset('images/431531213_1137468827670147_4601469764870642235_n.jpg')])
<section class="ftco-section contact-section">
    <div class="container" x-data="{
                isRiyadh: true,
                isJubali:false,
                isHafr:false}"  class="container">
        <div class=" container">
            <button class="btn btn-primary"
                    x-on:click="isRiyadh = true,isJubali = false,isHafr = false"
                    >Riyadh Head Office
            </button>
            <button class="btn btn-primary"
                    x-on:click="isRiyadh = false,isJubali = true,isHafr = false"
                    >Al Jubali Branch
            </button>
            <button class="btn btn-primary "
                    x-on:click="isRiyadh = false,isJubali = false,isHafr = true"
                    >Hafr Al Batin Branch
            </button>
        </div>
        {{-- Riyadh --}}
        <div x-transition  x-show="isRiyadh">
            <div class="row d-flex my-5 contact-info">
                <div class="col-md-12 mb-4">
                    <h2 class="h3">Riyad Branch Information</h2>
                </div>
                <div class="w-100"></div>
                <div class="col-md-5">
                    <p><span>Address: <br></span> P.O.Box : 2588, <br>Postal
                        Code: 31991, Kingdom of Saudi Arabia.</p>
                </div>
                <div class="col-md-3">
                    <p>
                        <span>Phone Numbers: <br></span>
                        <div>
                            <a href="#" style="color:#619bf9;">
                                <span class="icon icon-phone"></span>
                                <span>0500550113</span>
                            </a><br>
                            <a href="#" style="color:#619bf9;">
                                <span class="icon icon-phone"></span>
                                <span>+966590861892</span>
                            </a>
                        </div>

                    </p>
                </div>
                <div class="col-md-3">
                    @php
                    $emails = [
                        "info@mesharialhumlaw.com",
                    ]
                    @endphp
                    <span>Emails:</span>
                    @foreach ($emails as $email )
                        <p> <a style="color:#619bf9;" href="mailto:{{ $email }}">{{ $email }}</a></p>
                    @endforeach
                </div>
            </div>
            <div class="row block-9 no-gutters">
                <div class="col-lg-6 order-md-last d-flex">
                    <form action="#" class="bg-light p-5 contact-form">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Email">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Subject">
                        </div>
                        <div class="form-group">
                            <textarea name="" id="" cols="30" rows="7" class="form-control"
                                placeholder="Message"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
                        </div>
                    </form>

                </div>

                <div class="col-lg-6 d-flex">
                    <iframe
                        width="600"
                        height="600"
                        style="border:0"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCm0X3ceS1mBnU-Vods3Vy1xSRNSPP8KlE
                                &q=24.7019036,46.665175">
                        </iframe>
                </div>
            </div>
        </div>

        {{-- Jubali --}}
        <div x-transition  x-show="isJubali">
            <div class="row d-flex my-5 contact-info">
                <div class="col-md-12 mb-4">
                    <h2 class="h3">Al Jubali Branch Information</h2>
                </div>
                <div class="w-100"></div>
                <div class="col-md-5">
                    <p><span>Address: <br></span> P.O.Box : 2588, <br>Postal
                        Code: 31991, Kingdom of Saudi Arabia.</p>
                </div>
                <div class="col-md-3">
                    <p>
                        <span>Phone Numbers: <br></span>
                        <div>
                            <a href="#" style="color:#619bf9;">
                                <span class="icon icon-phone"></span>
                                <span>0531113885</span>
                            </a><br>
                            <a href="#" style="color:#619bf9;">
                                <span class="icon icon-phone"></span>
                                <span>0558682149</span>
                            </a>
                        </div>

                    </p>
                </div>
                <div class="col-md-3">
                    @php
                    $emails = [
                        "info@mesharialhumlaw.com",
                    ]
                    @endphp
                    <span>Emails:</span>
                    @foreach ($emails as $email )
                        <p> <a style="color:#619bf9;" href="mailto:{{ $email }}">{{ $email }}</a></p>
                    @endforeach
                </div>
            </div>
            <div class="row block-9 no-gutters">
                <div class="col-lg-6 order-md-last d-flex">
                    <form action="#" class="bg-light p-5 contact-form">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Email">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Subject">
                        </div>
                        <div class="form-group">
                            <textarea name="" id="" cols="30" rows="7" class="form-control"
                                placeholder="Message"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
                        </div>
                    </form>

                </div>

                <div class="col-lg-6 d-flex">
                    <iframe
                        width="600"
                        height="600"
                        style="border:0"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCm0X3ceS1mBnU-Vods3Vy1xSRNSPP8KlE
                                &q=27.0052395,49.6569939">
                        </iframe>
                </div>
            </div>
        </div>

        {{-- Hafr --}}
        <div x-transition  x-show="isHafr">
            <div class="row d-flex my-5 contact-info">
                <div class="col-md-12 mb-4">
                    <h2 class="h3">Hafr Al Batin Branch Information</h2>
                </div>
                <div class="w-100"></div>
                <div class="col-md-5">
                    <p><span>Address: <br></span> P.O.Box : 2588, <br>Postal
                        Code: 31991, Kingdom of Saudi Arabia.</p>
                </div>
                <div class="col-md-3">
                    <p>
                        <span>Phone Numbers: <br></span>
                        <div>
                            <a href="#" style="color:#619bf9;">
                                <span class="icon icon-phone"></span>
                                <span>0500922283</span>
                            </a><br>
                            <a href="#" style="color:#619bf9;">
                                <span class="icon icon-phone"></span>
                                <span>0558682149</span>
                            </a>
                        </div>

                    </p>
                </div>
                <div class="col-md-3">
                    @php
                    $emails = [
                        "info@mesharialhumlaw.com",
                    ]
                    @endphp
                    <span>Emails:</span>
                    @foreach ($emails as $email )
                        <p> <a style="color:#619bf9;" href="mailto:{{ $email }}">{{ $email }}</a></p>
                    @endforeach
                </div>
            </div>
            <div class="row block-9 no-gutters">
                <div class="col-lg-6 order-md-last d-flex">
                    <form action="#" class="bg-light p-5 contact-form">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Your Email">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Subject">
                        </div>
                        <div class="form-group">
                            <textarea name="" id="" cols="30" rows="7" class="form-control"
                                placeholder="Message"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
                        </div>
                    </form>

                </div>

                <div class="col-lg-6 d-flex">
                    <iframe
                        width="600"
                        height="600"
                        style="border:0"
                        loading="lazy"
                        allowfullscreen
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCm0X3ceS1mBnU-Vods3Vy1xSRNSPP8KlE
                                &q=28.415062,45.9701386">
                        </iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

{{--
<div>
    <span>Al Jubali Branch</span><br>
    <a href="#" style="color:#619bf9;">
        <span class="icon icon-phone"></span>
        <span>0531113885</span>
    </a>
</div>
<div>
    <span>Hafr Al Batin Branch</span><br>
    <a href="#" style="color:#619bf9;">
        <span class="icon icon-phone"></span>
        <span>0500922283</span>
    </a>
</div> --}}
