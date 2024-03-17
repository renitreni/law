@extends('layouts.guest.index')
@section('title',"About | Meshari Alhumaidi Law Firm")
@section('contents')
@include('includes.pages-hero-breadcrumbs',['page'=>"About us","bg"=>asset('images/save2.png')])
@include('includes.section-about')
@endsection
