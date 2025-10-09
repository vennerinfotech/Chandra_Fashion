@extends('layouts.app')

@section('title', 'All Collection')

@section('content')

    <section class="breadcrumb-wrapper top-section-padding">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Collection</li>
            </ol>
            <h2 class="breadcrumb-title">All Collection</h2>
        </nav>
    </section>

    {{-- <section class="collection-page-wrapper section-padding">
        <div class="container">
            <div class="row">
                @foreach($subcategories as $subcategory)
                <div class="col-md-6 col-lg-3">
                    <div class="collection-item">
                        <a href="#">
                            <img src="{{ $subcategory->image ? asset('images/subcategories/' . $subcategory->image) : asset('images/placeholder.png') }}"
                                alt="{{ $subcategory->name }}" class="img-fluid">

                            <div class="collection-info">
                                <h3>{{ $subcategory->name }}</h3>
                                <p>{{ $subcategory->description ?? '' }}</p>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section> --}}

    <section class="collection-page-wrapper section-padding">
        <div class="container">
            <div class="row">
                @foreach($subcategories as $subcategory)
                    <div class="col-md-6 col-lg-3">
                        <div class="collection-item">
                            <a href="{{ route('products.index', ['subcategory' => $subcategory->id]) }}">
                                <img src="{{ $subcategory->image ? asset('images/subcategories/' . $subcategory->image) : asset('images/placeholder.png') }}"
                                    alt="{{ $subcategory->name }}" class="img-fluid">

                                <div class="collection-info">
                                    <h3>{{ $subcategory->name }}</h3>
                                    <p>{{ $subcategory->description ?? '' }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>



@endsection
