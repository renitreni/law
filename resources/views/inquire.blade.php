@extends('layouts.guest.index')
@section('title',"Inquire Now | Law Practice Management")
@section('contents')
@include('includes.breadcrumbs',['page'=>"Inquiry"])
<section class="ftco-section contact-section">
    @livewire('send-inquiry-livewire')
</section>
@endsection
