@extends('admin.layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="admin-title mb-4 d-flex justify-content-between align-items-center">
        <h1>Newsletter Subscription Details</h1>
        <a href="{{ route('admin.newsletters.index') }}" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped custom-table">
                    <tbody>
                        <tr>
                            <th width="25%">ID</th>
                            <td>{{ $subscription->id }}</td>
                        </tr>
                        <tr>
                            <th>Mobile Number</th>
                            <td>{{ $subscription->mobile }}</td>
                        </tr>
                        <tr>
                            <th>Subscribed At</th>
                            <td>{{ $subscription->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <form action="{{ route('admin.newsletters.destroy', $subscription->id) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this subscription?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-trash"></i> Delete Subscription
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .admin-title h1 {
        font-size: 22px;
        font-weight: 600;
    }
    .custom-table th {
        background-color: #f8f9fa;
        width: 25%;
        font-weight: 600;
    }
    .custom-table td {
        background-color: #fff;
    }
    .card {
        border-radius: 10px;
    }
</style>
@endpush
