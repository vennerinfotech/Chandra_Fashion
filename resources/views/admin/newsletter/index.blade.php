@extends('admin.layouts.app')

@section('content')
    <div class="table-wrapper">
        {{-- <div class="admin-title">
            <h1>Newsletter Subscriptions</h1>
        </div> --}}

        <div class="d-flex justify-content-between align-items-end mb-3">

            <!-- Left: Title -->
            <div class="admin-title m-0">
                <h1>Newsletter Subscriptions</h1>
            </div>

            <!-- Right: Export Filters -->
            <form action="{{ route('admin.newsletters.export') }}" method="GET" class="d-flex gap-2">

                <div>
                    <label class="small text-muted">From Date</label>
                    <input type="date" name="from_date" class="form-control">
                </div>

                <div>
                    <label class="small text-muted">To Date</label>
                    <input type="date" name="to_date" class="form-control">
                </div>

                <div class="d-flex align-items-end">
                    <button class="btn btn-success">
                        <i class="fa fa-file-excel"></i> Download Excel
                    </button>
                </div>

            </form>

        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table custom-table" id="NewslettersTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Mobile Number</th>
                                <th>Subscribed At</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($subscriptions as $index => $subscription)
                                <tr>
                                    <td>{{ $subscription->id }}</td>
                                    <td>{{ $subscription->mobile }}</td>
                                    <td>{{ $subscription->created_at->format('d M Y, h:i A') }}</td>
                                    <td>
                                        <!-- View Button -->
                                        <a href="{{ route('admin.newsletters.show', $subscription->id) }}"
                                            class="btn-action btn-sm" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <!-- Delete Form -->
                                        <form action="{{ route('admin.newsletters.destroy', $subscription->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Are you sure?')" title="Delete"
                                                class="btn-action btn-sm">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $subscriptions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#NewslettersTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [10, 25, 50, 100],
                "ordering": true,
                "searching": true,
                "order": [[0, 'desc']] // Sort by ID descending
            });
        });
    </script>
@endpush
