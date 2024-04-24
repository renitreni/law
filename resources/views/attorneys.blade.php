@extends('layouts.guest.index')
@section('title',"Attorneys | Meshari Alhumaidi Law Firm")
@section('contents')
@include('includes.breadcrumbs',['page'=>'Attorneys'])
<div class="container">
    <div class="row">
        @forelse ($attorneys as $attorney )
        <div data-aos="fade-left" class="card mb-2 shadow" >
            <div class="row g-0">
                <div class="col-md-4" style="max-width: 250px;">
                    <img src="{{ $attorney->photo }}" class="img-fluid rounded-start">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $attorney->name }}</h5>
                        <small class="card-subtitle">{{ $attorney->position_1 }}</small>
                        <p class="card-text">
                            {{ $attorney->description }}
                        </p>
                        <p class="card-text">
                            <small class="text-muted">{{ $attorney->position_2 }}</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <span>No attorneys</span>
        @endforelse
    </div>
</div>
@endsection
