@extends('admin.layouts.app')

@section('content')
<div class="table-wrapper">
    <div class="admin-title">
        <h1>SubCategories</h1>
        <a href="{{ route('admin.subcategories.create') }}" class="btn">
            <i class="fa-solid fa-plus"></i>Add SubCategory
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
                            <th>SubCategory Name</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($subcategories as $subcategory)
                        <tr>
                            <td>{{ $subcategory->id }}</td>
                            <td>{{ $subcategory->name }}</td>
                            <td>{{ $subcategory->category->name ?? 'N/A' }}</td>
                            <td>
                                @if($subcategory->image)
                                    <img src="{{ asset('images/subcategories/' . $subcategory->image) }}"
                                         width="50" height="50" class="rounded">
                                @endif
                            </td>
                            <td>{{ $subcategory->status ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <a href="{{ route('admin.subcategories.edit', $subcategory->id) }}" title="Edit" class="btn-action btn-sm">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <form action="{{ route('admin.subcategories.destroy', $subcategory->id) }}"
                                      method="POST" style="display:inline-block;">
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
                            <td colspan="6" class="text-center">No subcategories found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{ $subcategories->links() }}
</div>
@endsection
