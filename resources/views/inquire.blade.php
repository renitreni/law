@extends('layouts.guest.index')
@section('title',"Inquire Now | Meshari Alhumaidi Law Firm")
@section('contents')
@include('includes.pages-hero-breadcrumbs',['page'=>'Inquire','bg'=>asset('images/431531213_1137468827670147_4601469764870642235_n.jpg')])
<section class="ftco-section contact-section">
    @include('includes.section-inquire')
</section>
@endsection
