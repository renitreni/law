@extends('layouts.guest.index')
@section('title',"Gallery | Meshari Alhumaidi Law Firm")
@section('styles')
<style>
    .img-container {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        background-color: rgba(0, 0, 0, .8);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 99;
    }

    .img-container .img-header {
        display: flex;
        justify-content: end;
        width: 100%;
    }

    .img-container .img-lightbox {
        max-width: 800px;
        max-height: 600px;
        overflow: scroll;
    }

    .img-container .img-lightbox::-webkit-scrollbar {
        display: none;
    }
</style>
@endsection
@section('contents')
@include('includes.pages-hero-breadcrumbs',['page'=>'Gallery'])
<section x-data="{open:false,imgSrc:''}" class="ftco-section contact-section">
    <div class="container">
        <div class="row text-center text-lg-start">
            @foreach (Storage::files('public/gallery') as $path)
            <div x-on:click="open = true; imgSrc = '{{ Storage::url($path) }}'"
                class="col-lg-3 col-md-4 col-6">
                <div class="d-block mb-4 h-100">
                    <img loading='eager' class="img-fluid img-thumbnail" src="{{ Storage::url($path) }}"
                        alt="{{ basename($path) }}" style="width: 300px;height:300px; object-fit: cover;">
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
                <img class="img-fluid" :src="imgSrc" alt="">
            </figure>
        </div>
    </div>
</section>
@endsection
