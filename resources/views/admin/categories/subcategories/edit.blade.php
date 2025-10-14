@extends('admin.layouts.app')

@section('content')
<div class="create-form-wrapper">

    <form action="{{ route('admin.subcategories.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.categories.subcategories.form', ['subcategory' => $subcategory])
    </form>

</div>
@endsection
