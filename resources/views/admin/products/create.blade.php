@extends('admin.layouts.app')


@section('content')
<div class="container">
    <h1>Add Product</h1>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mb-3">Back</a>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.products.form')
        <button type="submit" class="btn btn-success">Create Product</button>
    </form>
</div>
@endsection
