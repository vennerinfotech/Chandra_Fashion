@extends('admin.layouts.app')

@section('content')
    {{-- <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mb-3">Back</a> --}}
    <div class="create-form-wrapper">

        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.products.form', ['product' => $product])
            {{-- <button type="submit" class="btn btn-success">Update Product</button> --}}
        </form>
    </div>
    </div>
@endsection
