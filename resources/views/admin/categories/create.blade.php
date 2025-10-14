@extends('admin.layouts.app')

@section('content')
<div class="create-form-wrapper">

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.categories.form')
    </form>

</div>
@endsection
