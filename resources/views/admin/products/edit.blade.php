@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Edit Product</h1>
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

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.products.form', ['product' => $product])
        <button type="submit" class="btn btn-success">Update Product</button>
    </form>
</div>
@endsection
