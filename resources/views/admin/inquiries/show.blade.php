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

                            {{-- Images --}}
                            @if($inquiry->product)
                                <div class="mt-2">
                                    {{-- Main product image --}}
                                    @if($inquiry->product->image_url)
                                        <img src="{{ asset($inquiry->product->image_url) }}"
                                            alt="Product Image"
                                            class="img-thumbnail mb-2"
                                            style="max-width: 150px;">
                                    @endif

                                    {{-- Gallery images --}}
                                    @if(is_array($inquiry->product->gallery) && count($inquiry->product->gallery) > 0)
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($inquiry->product->gallery as $galleryImage)
                                                <img src="{{ asset ($galleryImage) }}"
                                                    alt="Gallery Image"
                                                    class="img-thumbnail"
                                                    style="max-width: 100px;">
                                            @endforeach
                                        </div>
                                    @endif
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
                        <td>{{ $inquiry->country }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $inquiry->quantity }}</td>
                    </tr>
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
