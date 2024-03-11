@extends('layouts.guest.index')
@section('title',"About | Meshari Alhumaidi Law Firm")
@section('contents')
<section class="hero-wrap hero-wrap-2" style="background-image: url({{ asset('theme/images/bg_1.jpg') }});"
    data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <h1 class="mb-3 bread">About Us</h1>
                <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/') }}">Home <i
                                class="ion-ios-arrow-forward"></i></a></span> <span>About us <i
                            class="ion-ios-arrow-forward"></i></span></p>
            </div>
        </div>
    </div>
</section>

@include('includes.section-about')

<section class="ftco-consultation ftco-section ftco-no-pt ftco-no-pb img"
    style="background-image: url(images/bg_2.jpg);">
    <div class="overlay"></div>
    <div class="container">
        <div class="row d-md-flex justify-content-end">
            <div class="col-md-6 half p-3 py-5 pl-md-5 ftco-animate heading-section heading-section-white">
                <span class="subheading">Booking an Appointment</span>
                <h2 class="mb-4">Free Consultation</h2>
                <form action="#" class="consultation">
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
                        <input type="submit" value="Send message" class="btn btn-dark py-3 px-4">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


@include('includes.section-testimonials')
@endsection
