@extends('layouts.guest.index')
@section('title',"Meshari Alhumaidi Law Firm")
@section('contents')
@include('includes.section-hero')
@include('includes.section-service')
@include('includes.section-about')
@include('includes.section-branches')
@livewire('send-inquiry-livewire')
@endsection
