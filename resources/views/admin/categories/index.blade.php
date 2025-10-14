@extends('admin.layouts.app')

@section('content')
<div class="table-wrapper">
    <div class="admin-title">
        <h1>Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn">
            <i class="fa-solid fa-plus"></i>Add Category
        </a>
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
                            <th>Category Name</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>

                            {{-- Image Column --}}
                            <td>
                                @if($category->image)
                                     @include('admin.lightbox', ['images' => [asset('images/categories/' . $category->image)]])
                                @endif
                            </td>

                            {{-- Status Column --}}
                            <td>{{ $category->status ? 'Active' : 'Inactive' }}</td>

                            {{-- Actions --}}
                            <td>
                                <a href="{{ route('admin.categories.edit', $category->id) }}" title="Edit" class="btn-action btn-sm">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" title="Delete" class="btn-action btn-sm">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No categories found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{ $categories->links() }}
</div>
@endsection
