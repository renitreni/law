@extends('layouts.guest.index')
@section('title',"Services | Meshari Alhumaidi Law Firm")
@section('contents')
@include('includes.breadcrumbs',['page'=>"Services"])
{{-- <section class="text-white">
    @php
    $styles = "display:flex;flex-direction:column;justify-content:center;align-items:center;height:500px;width:100%;"
    @endphp
    <div style="{{ $styles }}">
        <h3>This page is under maintenance.</h3>
        <h6>We'll be back soon.</h6>
    </div>
</section> --}}
<section class="container">
    <div data-aos="fade-up" class="row">
        @foreach ($services as $service )
        <div class="card shadow m-1  col-md-3" style="max-width: 17rem;">
            <div class="card-body">
                <h5 class="card-title">{{ $service->service }}</h5>
                <p class="card-text">
                    {{ str($service->content)->limit(55) }}
                </p>
                <a href="{{ route('service',['lang'=>$lang,'service'=>str_replace(' ','-',strtolower($service->service))]) }}" class="btn btn-sm btn-secondary">Read more</a>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection
