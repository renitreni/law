@extends('layouts.guest.index')
@section('title',"Inquire Now | Meshari Alhumaidi Law Firm")
@section('contents')
@include('includes.breadcrumbs',['page'=>"Inquiry"])
<section class="ftco-section contact-section">
    @livewire('send-inquiry-livewire')
</section>
@endsection
