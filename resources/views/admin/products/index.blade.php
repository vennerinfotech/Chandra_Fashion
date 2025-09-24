@extends('admin.layouts.app')


@section('content')
<div class="table-wrapper">
    <div class="admin-title">
        <h1>Products</h1>
        <a href="{{ route('admin.products.create') }}" class="btn"><i class="fa-solid fa-plus"></i>Add Product</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


 <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
    <table class="table table-bordered custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Export Ready</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->export_ready ? 'Yes' : 'No' }}</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" title="Edit" class="btn-action btn-sm"><i class="fa-solid fa-pencil"></i></a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Are you sure?')" title="Delete" class="btn-action btn-sm"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No products found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
            </div>
        </div>
 </div>

    {{ $products->links() }}
</div>
@endsection
