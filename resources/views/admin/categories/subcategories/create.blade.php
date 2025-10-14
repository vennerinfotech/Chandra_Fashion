@extends('admin.layouts.app')

@section('content')
<div class="create-form-wrapper">

    <form action="{{ route('admin.subcategories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.categories.subcategories.form')
    </form>

</div>
@endsection
