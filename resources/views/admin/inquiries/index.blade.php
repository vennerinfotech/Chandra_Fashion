@extends('admin.layouts.app')

@section('content')
<div class="table-wrapper">
    <div class="admin-title">
        <h1>All Inquiries</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Country</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inquiries as $inquiry)
                        <tr>
                            <td>{{ $inquiry->id }}</td>

                            {{-- Product Name --}}
                            <td>{{ $inquiry->product->name ?? 'N/A' }}</td>

                            {{-- Product Image --}}
                            <td>
                                {{-- Selected Images --}}
                                @if(!empty($inquiry->selected_images))
                                    <div class="mt-2 d-flex flex-wrap gap-2">
                                        @foreach($inquiry->selected_images as $image)
                                            <img src="{{ asset($image) }}"
                                                alt="{{ $inquiry->product->name }}"
                                                width="50" height="50" class="rounded">
                                        @endforeach
                                    </div>
                                @endif
                            </td>

                            <td>{{ $inquiry->name }}</td>
                            <td>{{ $inquiry->email }}</td>
                            <td>{{ $inquiry->phone }}</td>
                            <td>{{ $inquiry->country }}</td>
                            <td>{{ $inquiry->quantity }}</td>
                            <td>
                                <!-- View Button -->
                                <a href="{{ route('admin.inquiries.show', $inquiry->id) }}"
                                class="btn-action btn-sm" title="View">
                                <i class="fa fa-eye"></i>
                                </a>

                                <!-- Delete Form -->
                                <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" title="Delete" class="btn-action btn-sm"><i class="fa-solid fa-trash"></i></button>
                                </form>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No inquiries found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $inquiries->links() }}
            </div>
        </div>
    </div>
</div>
</div>
@endsection
