@extends('layouts.guest.index')
@section('title',"Services | Meshari Alhumaidi Law Firm")
@section('contents')
@include('includes.pages-hero-breadcrumbs',['page'=>$service->service,'bg'=>'https://images.unsplash.com/photo-1589994965851-a8f479c573a9?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'])
<section class="container p-5">
    <div class="row">
        <div class="col-md-8">
            <p style="text-align: justify;font-size:14px;">{{ $service->content }}</p>
        </div>

        <div class="col-md-4">
            <img style="height: 230px;" class="rounded w-100" src="{{ $service->img_link }}" alt="" class="img-fluid">
        </div>
    </div>
    <div class="d-inline-flex mt-3 mt-md-4">
        <a class="btn btn-sm btn-dark" href="/list-services">Go Back</a>
        <a class="btn btn-sm btn-dark ml-1" href="{{ route('service',['service'=>$service->next]) }}">Next {{ ucwords(str_replace('-', ' ', $service->next))  }} &#10095;</a>
    </div>
</section>
@endsection
