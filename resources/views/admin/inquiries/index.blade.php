@extends('admin.layouts.app')

@section('content')
    <div class="table-wrapper">


        <div class="d-flex justify-content-between align-items-end mb-3">

            <!-- Left: Page Title -->

            <div class="admin-title m-0">
                <h1>All Inquiries</h1>
            </div>
            <!-- Right Side: Date Filters + Excel Button -->
            <div class="d-flex gap-2">
                <form action="{{ route('admin.inquiries.export') }}" method="GET" class="d-flex gap-2">
                    <div>
                        <label class="small text-muted">From Date</label>
                        <input type="date" name="from_date" class="form-control">
                    </div>

                    <div>
                        <label class="small text-muted">To Date</label>
                        <input type="date" name="to_date" class="form-control">
                    </div>

                    <div class="d-flex align-items-end">
                        <a href="{{ route('admin.inquiries.export') }}" id="exportExcelBtn" class="btn btn-success">
                            <i class="fa fa-file-excel"></i> Download Excel
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table custom-table" id="inquiriesTable">
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

                                            @include('admin.lightbox', ['images' => $inquiry->selected_images])
                                        @endif
                                    </td>

                                    <td>{{ $inquiry->name }}</td>
                                    <td>{{ $inquiry->email }}</td>
                                    <td>{{ $inquiry->phone }}</td>
                                    <td>{{ $inquiry->country->name ?? 'N/A' }}</td>
                                    <td>{{ $inquiry->quantity }}</td>
                                    <td>
                                        <!-- View Button -->
                                        <a href="{{ route('admin.inquiries.show', $inquiry->id) }}" class="btn-action btn-sm"
                                            title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <!-- Delete Form -->
                                        <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Are you sure?')" title="Delete"
                                                class="btn-action btn-sm"><i class="fa-solid fa-trash"></i></button>
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
                    {{-- {{ $inquiries->links() }} --}}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#inquiriesTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [10, 25, 50, 100],
                "ordering": true,
                "searching": true,
                "order": [[0, 'desc']] // Default sorting by ID column (descending order)
            });
        });
    </script>
@endpush
