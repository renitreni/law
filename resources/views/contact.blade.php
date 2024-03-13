@extends('layouts.guest.index')
@section('title',"Contact | Meshari Alhumaidi Law Firm")
@section('contents')
@include('includes.pages-hero-breadcrumbs',['page'=>'Contact'])
<section class="ftco-section contact-section">
    <div class="container">
        <div class="row d-flex mb-5 contact-info">
            <div class="col-md-12 mb-4">
                <h2 class="h3">Contact Information</h2>
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
                        <span>Riyadh Branch</span><br>
                        <a href="#" style="color:#619bf9;">
                            <span class="icon icon-phone"></span>
                            <span>0500550113</span>
                        </a>
                    </div>
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
                    </div>
                </p>
            </div>
            <div class="col-md-3">
                @php
                $emails = [
                    "atty.mahaaljubaire@mesharialhumlaw.com",
                    "meshari.alhumadi@mesharialhumlaw.com",
                    "info@mesharialhumlaw.com",
                    "majedghnaim@mesharialhumlaw.com"
                ]
                @endphp
                <span>Emails:</span>
                @foreach ($emails as $email )
                    <p> <a href="mailto:{{ $email }}">{{ $email }}</a></p>
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
                <div id="map" class="bg-white"></div>
            </div>
        </div>
    </div>
</section>
@endsection
