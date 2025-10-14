@extends('admin.layouts.app')

@section('content')

    <div class="create-form-wrapper">

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.products.form', ['product' => $product])
        </form>

    </div>
    </div>
@endsection
