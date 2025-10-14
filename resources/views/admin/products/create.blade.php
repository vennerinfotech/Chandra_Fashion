@extends('admin.layouts.app')


@section('content')
<div class="create-form-wrapper">

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.products.form')
    </form>

</div>
@endsection
