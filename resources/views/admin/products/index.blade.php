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


        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Import Failed:</strong>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card shadow p-3 mb-4">
            <h4 class="mb-3">Import Products</h4>

            <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="import-file-main">
                    <div class="import-file-info">
                        <div class="">
                            {{-- <label class="form-label">Select File</label> --}}
                            <input type="file" name="file" class="form-control" required>
                            {{-- <small class="text-muted">Allowed: .csv, .xlsx</small> --}}
                        </div>
                        <button type="submit" class="btn">
                            <i class="fa-solid fa-upload"></i> Import Products
                        </button>
                    </div>
                    <div class="">
                        <a href="{{ route('admin.products.import.format') }}" class="btn">
                            <i class="fa-solid fa-download"></i> Download Template
                        </a>
                    </div>
                </div>


            </form>
        </div>



        {{-- Full Screen Loader --}}
        <div id="fullScreenLoader">
            <div class="loader-inner">
                <div class="loader-spinner"></div>
                <p class="loader-text">Importing products, please wait...</p>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered custom-table" id="productsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Subcategory</th>
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
                                    <td>
                                        @php
                                            $firstImage = $product->image ?? null;
                                            if (!$firstImage) {
                                                foreach ($product->variants as $variant) {
                                                    $images = is_array($variant->images) ? $variant->images : json_decode($variant->images, true);
                                                    if (!empty($images)) {
                                                        $firstImage = $images[0];
                                                        break;
                                                    }
                                                }
                                            }
                                        @endphp

                                        @if($firstImage)
                                            {{-- Include Lightbox --}}
                                            @include('admin.lightbox', ['images' => [asset($firstImage)]])
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>

                                    <td>{{ $product->category->name ?? '-' }}</td>
                                    <td>{{ $product->subcategory->name ?? '-' }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->export_ready ? 'Yes' : 'No' }}</td>
                                    <td class="action-btn">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" title="Edit"
                                            class="btn-action btn-sm"><i class="fa-solid fa-pencil"></i></a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
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
                                    <td colspan="6" class="text-center">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- {{ $products->links() }} --}}
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#productsTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [10, 25, 50, 100],
                "ordering": true,
                "searching": true,
                "order": [[0, 'desc']] // Default sorting by ID column (descending order)
            });
        });


        $("form[action='{{ route('admin.products.import') }}']").on('submit', function () {
            $("#fullScreenLoader").show();
        });
    </script>
@endpush
