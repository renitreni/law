@extends('layouts.guest.index')
@section('title',"Gallery | Meshari Alhumaidi Law Firm")
@section('contents')
@include('includes.pages-hero-breadcrumbs',['page'=>'Gallery'])
<section x-data="{open:false,imgSrc:''}" class="ftco-section contact-section">
    <div class="container">
        <div class="row text-center text-lg-start">
            @php
            $imagePaths = glob(public_path('images/*'));
            @endphp
            @foreach ($imagePaths as $path)
            <div x-on:click="open = true; imgSrc = '{{ asset('images/' . basename($path)) }}'" class="col-lg-3 col-md-4 col-6">
                <div class="d-block mb-4 h-100">
                    <img  loading='eager'
                        class="img-fluid img-thumbnail" src="{{ asset('images/' . basename($path)) }}" alt="Image"
                        style="width: 300px;height:300px; object-fit: cover;">
                </div>
            </div>
            @endforeach
        </div>
    </div>


    <div x-transition x-show="open" class="img-container">
        <div class="img-lightbox">
            <div class="img-header">
                <button x-on:click="open = false,imgSrc=''" type="button" class="btn btn-sm btn-dark">Close</button>
            </div>
            <figure>
                <img class="img-fluid" :src="imgSrc"  alt="">
            </figure>
        </div>
    </div>
</section>
@endsection
