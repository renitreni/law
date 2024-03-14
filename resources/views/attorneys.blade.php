@extends('layouts.guest.index')
@section('title',"Attorneys | Meshari Alhumaidi Law Firm")
@section('contents')
@include('includes.pages-hero-breadcrumbs',['page'=>"Attorneys","bg"=>asset('images/save5.png')])
@include('includes.section-attorneys')
@endsection
