@extends('layouts.guest.index')
@section('title',"Services | Meshari Alhumaidi Law Firm")
@section('contents')
@include('includes.breadcrumbs',['page'=> $service->service,'isService'=>true])
<section class="container">
    <article data-aos="fade-left" class="py-5">
        <h4>{{ $service->service }}</h4>
        <p style="font-weight: 300">{{ $service->content }}</p>
    </article>
    <div data-aos="fade-up">
        <a href="{{ route('services',['lang'=>$lang]) }}" class="btn btn-sm btn-secondary">
            <i class='bx bx-arrow-back'></i>
            <span>Back</span>
        </a>

        <a href="{{ route('service',['lang'=>$lang,'service'=>$service->next]) }}" class="btn btn-sm btn-primary">
            <span>Next: {{ str_replace('-'," ", ucwords($service->next)) }}</span>
        </a>
    </div>
</section>
@endsection
