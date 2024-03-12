@extends('layouts.guest.index')
@section('title',"About | Meshari Alhumaidi Law Firm")
@section('contents')
@include('includes.pages-hero-breadcrumbs',['page'=>"About us"])
@include('includes.section-about')
@include('includes.section-testimonials')
@include('includes.section-inquire')
@endsection
