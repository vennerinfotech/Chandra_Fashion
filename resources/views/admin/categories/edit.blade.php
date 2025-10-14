@extends('admin.layouts.app')

@section('content')
<div class="create-form-wrapper">

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.categories.form', ['category' => $category])
    </form>

</div>
@endsection
