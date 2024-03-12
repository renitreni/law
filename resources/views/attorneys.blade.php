@extends('layouts.guest.index')
@section('title',"Attorneys | Meshari Alhumaidi Law Firm")
@section('contents')
@include('includes.pages-hero-breadcrumbs',['page'=>"Attorneys"])
<section class="ftco-section">
    <div class="container-fluid px-md-5">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="block-2 ftco-animate">
                    <div class="flipper">
                        <div class="front" style="background-image: url({{ asset('theme/images/person_1.jpg') }});">
                            <div class="box">
                                <h2>Ryan Anderson</h2>
                                <p>Civil Lawyer</p>
                            </div>
                        </div>
                        <div class="back">
                            <!-- back content -->
                            <blockquote>
                                <p>&ldquo;Even the all-powerful Pointing has no control about the blind texts it is an
                                    almost unorthographic life One day however a small line of blind text &rdquo;</p>
                            </blockquote>
                            <div class="author d-flex">
                                <div class="image align-self-center">
                                    <img src="{{ asset('theme/images/person_1.jpg') }}" alt="">
                                </div>
                                <div class="name align-self-center ml-3">Ryan Anderson <span class="position">Civil
                                        Lawyer</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="block-2 ftco-animate">
                    <div class="flipper">
                        <div class="front" style="background-image: url({{ asset('theme/images/person_2.jpg') }});">
                            <div class="box">
                                <h2>Greg Washer</h2>
                                <p>Business Lawyer</p>
                            </div>
                        </div>
                        <div class="back">
                            <!-- back content -->
                            <blockquote>
                                <p>&ldquo;Even the all-powerful Pointing has no control about the blind texts it is an
                                    almost unorthographic life One day however a small line of blind text &rdquo;</p>
                            </blockquote>
                            <div class="author d-flex">
                                <div class="image align-self-center">
                                    <img src="{{ asset('theme/images/person_2.jpg') }}" alt="">
                                </div>
                                <div class="name align-self-center ml-3">Greg Washer<span class="position">Business
                                        Lawyer</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="block-2 ftco-animate">
                    <div class="flipper">
                        <div class="front" style="background-image: url({{ asset('theme/images/person_3.jpg') }});">
                            <div class="box">
                                <h2>Tony Henderson</h2>
                                <p>Criminal Defense</p>
                            </div>
                        </div>
                        <div class="back">
                            <!-- back content -->
                            <blockquote>
                                <p>&ldquo;Even the all-powerful Pointing has no control about the blind texts it is an
                                    almost unorthographic life One day however a small line of blind text &rdquo;</p>
                            </blockquote>
                            <div class="author d-flex">
                                <div class="image align-self-center">
                                    <img src="{{ asset('theme/images/person_3.jpg') }}" alt="">
                                </div>
                                <div class="name align-self-center ml-3">Tony Henderson <span class="position">Criminal
                                        Defense</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="block-2 ftco-animate">
                    <div class="flipper">
                        <div class="front" style="background-image: url({{ asset('theme/images/person_4.jpg') }});">
                            <div class="box">
                                <h2>Jack Smith</h2>
                                <p>Insurance Lawyer</p>
                            </div>
                        </div>
                        <div class="back">
                            <!-- back content -->
                            <blockquote>
                                <p>&ldquo;Even the all-powerful Pointing has no control about the blind texts it is an
                                    almost unorthographic life One day however a small line of blind text &rdquo;</p>
                            </blockquote>
                            <div class="author d-flex">
                                <div class="image align-self-center">
                                    <img src="{{ asset('theme/images/person_4.jpg') }}" alt="">
                                </div>
                                <div class="name align-self-center ml-3">Jack Smith <span class="position">Insurance
                                        Lawyer</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
