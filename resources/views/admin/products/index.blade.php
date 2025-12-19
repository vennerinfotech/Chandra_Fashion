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
                <strong>⚠️ Import Failed</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                
                @if(session('validation_details'))
                    <hr>
                    <p class="mb-1"><strong>Error Details:</strong></p>
                    <ul class="mb-0" style="max-height: 200px; overflow-y: auto;">
                        @foreach(session('validation_details') as $detail)
                            <li><small>{{ $detail }}</small></li>
                        @endforeach
                    </ul>
                @endif
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



        {{-- Full Screen Loader with Progress Bar --}}
        <div id="fullScreenLoader">
            {{-- Cancel Button in Top-Left Corner --}}
            <button id="cancelImportBtn" class="cancel-import-btn" title="Cancel Import">
                <i class="fa fa-times"></i>
            </button>
            
            <div class="loader-inner">
                <div class="loader-spinner"></div>
                <p class="loader-text">Importing products, please wait...</p>
                <div class="progress-container" style="width: 80%; max-width: 500px; margin: 20px auto;">
                    <div class="progress" style="height: 30px; background-color: #e9ecef; border-radius: 15px; overflow: hidden;">
                        <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                             role="progressbar" style="width: 0%; font-size: 14px; font-weight: bold; line-height: 30px;">
                            0%
                        </div>
                    </div>
                    <div class="progress-info" style="text-align: center; margin-top: 10px; color: #fff;">
                        <span id="progressText">Preparing import...</span>
                    </div>
                </div>
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
                                            <div class="text-center text-muted">
                                                <i class="fa-solid fa-image fa-2x"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td>{{ $product->category->name ?? '-' }}</td>
                                    <td>{{ $product->subcategory->name ?? '-' }}</td>
                                    <td>{{ $product->price ? '₹' . number_format($product->price, 2) : '-' }}</td>
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

        let progressInterval;

        $("form[action='{{ route('admin.products.import') }}']").on('submit', function () {
            $("#fullScreenLoader").show();
            
            // Start polling for progress - faster interval for real-time updates
            progressInterval = setInterval(updateProgress, 500); // Poll every 0.5 seconds
        });

        function updateProgress() {
            $.ajax({
                url: '{{ route('admin.products.import.progress') }}',
                method: 'GET',
                success: function(data) {
                    if (data.percentage > 0) {
                        $('#progressBar').css('width', data.percentage + '%');
                        $('#progressBar').text(data.percentage.toFixed(1) + '%');
                        
                        // Calculate current batch (2 products per batch)
                        let currentBatch = Math.ceil(data.current / 2);
                        let totalBatches = Math.ceil(data.total / 2);
                        
                        $('#progressText').html(
                            '<strong>Importing:</strong> ' + data.current + ' / ' + data.total + ' products<br>' +
                            '<small>Batch: ' + currentBatch + ' / ' + totalBatches + ' (2 products per batch)</small>'
                        );
                    }
                    
                    // Stop polling when complete
                    if (data.status === 'completed' || data.percentage >= 100) {
                        clearInterval(progressInterval);
                        $('#progressText').html('<strong>✅ Import completed!</strong><br><small>Refreshing page...</small>');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                },
                error: function() {
                    console.error('Failed to fetch progress');
                }
            });
        }

        // Cancel Import Button Handler
        $('#cancelImportBtn').on('click', function() {
            if (confirm('Are you sure you want to cancel the import? Products imported so far will be saved.')) {
                // Call backend to set cancel flag
                $.ajax({
                    url: '{{ route('admin.products.cancel.import') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log('Cancel request sent successfully');
                    },
                    error: function() {
                        console.error('Failed to send cancel request');
                    }
                });
                
                // Stop polling
                clearInterval(progressInterval);
                
                // Update UI immediately
                $('#progressBar').removeClass('bg-success').addClass('bg-danger');
                $('#progressText').html('<strong>⚠️ Cancelling Import...</strong><br><small>Stopping after current product...</small>');
                $('.loader-text').text('Cancelling import...');
                
                // Hide loader and reload page after delay
                setTimeout(function() {
                    $('#fullScreenLoader').hide();
                    location.reload();
                }, 2000);
            }
        });
    </script>
@endpush
