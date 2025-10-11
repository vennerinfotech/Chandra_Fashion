@extends('admin.layouts.app')

@section('content')
<div class="create-form-wrapper">
    {{-- @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    <form action="{{ route('admin.subcategories.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.categories.subcategories.form', ['subcategory' => $subcategory])
    </form>
</div>
@endsection
