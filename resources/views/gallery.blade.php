@extends('layouts.guest.index')
@section('title',"Gallery | Meshari Alhumaidi Law Firm")
@section('contents')
@include('includes.pages-hero-breadcrumbs',['page'=>'Gallery'])
<section class="ftco-section contact-section">
    <div class="container">
        <div class="row text-center text-lg-start">
            @php
            $imagePaths = glob(public_path('images/*'));
            @endphp
            @foreach ($imagePaths as $path)
            <div class="col-lg-3 col-md-4 col-6">
                <div  class="d-block mb-4 h-100">
                    <img loading='eager' class="img-fluid img-thumbnail" src="{{ asset('images/' . basename($path)) }}" alt="Image">
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
@endsection
