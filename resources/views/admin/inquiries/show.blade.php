@extends('admin.layouts.app')

@section('content')
         <div class="admin-title">
        <h1>Inquiry Detail</h1>
    </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $inquiry->id }}</td>
                    </tr>

                   <tr>
                        <th>Product</th>
                        <td>
                            {{-- Product Name --}}
                            {{ $inquiry->product->name ?? 'N/A' }}

                            {{-- Selected Images --}}
                            @if(!empty($inquiry->selected_images))
                                <div class="mt-2 d-flex flex-wrap gap-2">
                                    @foreach($inquiry->selected_images as $image)
                                        <img src="{{ asset($image) }}"
                                            alt="{{ $inquiry->product->name }}"
                                            width="80" height="80" class="rounded">
                                    @endforeach
                                </div>
                            @endif
                        </td>
                    </tr>


                    <tr>
                        <th>Name</th>
                        <td>{{ $inquiry->name }}</td>
                    </tr>
                    <tr>
                        <th>Company</th>
                        <td>{{ $inquiry->company }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $inquiry->email }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $inquiry->phone }}</td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td>{{ $inquiry->country->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $inquiry->quantity }}</td>
                    </tr>
                    @if($inquiry->color)
                    <tr>
                        <th>Color</th>
                        <td>{{ $inquiry->color }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Created At</th>
                        <td>{{ $inquiry->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                </table>

                <div class="mt-3">
                    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
