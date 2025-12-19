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
                <p class="loader-text" style="font-size: 20px; margin-top: 20px; margin-bottom: 10px;">Importing products,
                    please wait...</p>

                {{-- Large Progress Percentage Display --}}
                <!-- <div style="text-align: center; margin: 20px 0;">
                    <h1 id="largeProgressDisplay"
                        style="color: #fff; font-size: 48px; font-weight: bold; margin: 0; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                        Preparing...
                    </h1>
                </div> -->

                <div class="progress-container" style="width: 80%; max-width: 600px; margin: 20px auto;">
                    <div class="progress"
                        style="height: 35px; background-color: rgba(255,255,255,0.2); border-radius: 15px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.3);">
                        <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                                 role="progressbar" style="width: 0%; font-size: 16px; font-weight: bold; line-height: 35px;">
                                0%
                            </div>
                        <!-- <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                            role="progressbar" style="width: 0%; min-width: 60px;">
                            0%
                        </div> -->

                    </div>
                    <!-- <div class="progress-info" style="text-align: center; margin-top: 15px; color: #fff; font-size: 16px;">
                        <span id="progressText">Preparing import...</span>
                    </div> -->
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
            // Show loader with flex display for proper layout
            $("#fullScreenLoader").css('display', 'flex');

            // Start polling for progress immediately
            updateProgress(); // First update immediately

            // Then continue polling - faster interval for real-time updates
            progressInterval = setInterval(updateProgress, 500); // Poll every 0.5 seconds
        });

        function updateProgress() {
            $.ajax({
                url: '{{ route('admin.products.import.progress') }}',
                method: 'GET',
                success: function (data) {
                    console.log('Progress data:', data); // Debug log

                    // Always update progress bar
                    let percentage = data.percentage || 0;
                    $('#progressBar').css('width', percentage + '%');
                    $('#progressBar').text(percentage.toFixed(1) + '%');

                    // Update progress text based on data
                    if (data.total > 0) {
                        let current = data.current || 0;

                        if (current > 0) {
                            // Calculate current batch (2 products per batch)
                            let currentBatch = Math.ceil(current / 2);
                            let totalBatches = Math.ceil(data.total / 2);

                            $('#progressText').html(
                                '<strong>' + percentage.toFixed(1) + '% - Batch: ' + currentBatch + ' / ' + totalBatches + '</strong><br>' +
                                '<small style="opacity: 0.9;">Products: ' + current + ' / ' + data.total + ' (2 per batch)</small>'
                            );
                        } else {
                            // Starting state - show 0%
                            $('#progressText').html('<strong>Starting import...</strong><br><small>Total: ' + data.total + ' products</small>');
                        }
                    } else {
                        // Preparing/waiting state
                        $('#progressText').html('<strong>Preparing import...</strong><br><small>Please wait</small>');
                    }

                    // Stop polling when complete
                    if (data.status === 'completed' || data.percentage >= 100) {
                        clearInterval(progressInterval);
                        $('#progressBar').css('width', '100%');
                        $('#progressBar').text('100%');
                        $('#progressText').html('<strong>✅ Import completed!</strong><br><small>Refreshing page...</small>');
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Failed to fetch progress:', error);
                    console.error('Response:', xhr.responseText);
                }
            });
        }

        // Cancel Import Button Handler
        $('#cancelImportBtn').on('click', function () {
            if (confirm('Are you sure you want to cancel the import? Products imported so far will be saved.')) {
                // Call backend to set cancel flag
                $.ajax({
                    url: '{{ route('admin.products.cancel.import') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        console.log('Cancel request sent successfully');
                    },
                    error: function () {
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
                setTimeout(function () {
                    $('#fullScreenLoader').css('display', 'none');
                    location.reload();
                }, 2000);
            }
        });
    </script>
@endpush