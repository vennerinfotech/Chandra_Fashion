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
                            <td>
                                {{-- Product name --}}
                                {{ $inquiry->product->name ?? 'N/A' }}

                                {{-- Main product image --}}
                                @if($inquiry->product && $inquiry->product->image_url)
                                    <img src="{{ $inquiry->product->image_url }}"
                                        alt="Product Image"
                                        class="img-thumbnail mt-2"
                                        style="max-width: 150px;">
                                @endif

                                {{-- Gallery images --}}
                                @if($inquiry->product && is_array($inquiry->product->gallery))
                                    <div class="d-flex flex-wrap gap-2 mt-2">
                                        @foreach($inquiry->product->gallery as $galleryImage)
                                            <img src="{{ $galleryImage }}"
                                                alt="Gallery Image"
                                                class="img-thumbnail"
                                                style="max-width: 100px;">
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
                                <a href="{{ route('admin.inquiries.show', $inquiry->id) }}"
                                   class="btn-action btn-sm" title="View">
                                   <i class="fa fa-eye"></i>
                                </a>
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
