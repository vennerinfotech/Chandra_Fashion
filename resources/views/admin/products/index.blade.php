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

            {{-- Skipped Summary --}}
            @if((session('show_import_status') || request('import_completed')) && isset($recentImports) && $recentImports->count() > 0)
                @php $latestImport = $recentImports->first(); @endphp
                @if($latestImport->skipped_rows > 0)
                    <div class="alert alert-warning mt-3 mb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>{{ $latestImport->skipped_rows }} Products Skipped</strong>
                                <small class="text-muted ms-2">(Duplicate product codes)</small>
                            </div>
                            <button class="btn btn-sm btn-outline-dark" type="button" data-bs-toggle="collapse" data-bs-target="#skippedDetails" aria-expanded="false">
                                View Details
                            </button>
                        </div>
                        <div class="collapse mt-2" id="skippedDetails">
                            <div class="card card-body bg-light border-0 p-2" style="max-height: 200px; overflow-y: auto;">
                                <table class="table table-sm table-borderless mb-0" style="font-size: 13px;">
                                    <thead>
                                        <tr>
                                            <th>Row</th>
                                            <th>Product Code</th>
                                            <th>Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($latestImport->skipped_details)
                                            @foreach($latestImport->skipped_details as $skip)
                                                <tr>
                                                    <td>{{ $skip['row'] ?? '-' }}</td>
                                                    <td><code>{{ $skip['product_code'] ?? '-' }}</code></td>
                                                    <td class="text-muted">{{ $skip['reason'] ?? 'Unknown' }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr><td colspan="3">No details available.</td></tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>



        {{-- Small Floating Import Progress Widget --}}
        <div id="importProgressWidget" style="display: none; position: fixed; top: 100px; right: 20px; z-index: 9999; width: 320px; background: white; padding: 15px; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.2); border-left: 5px solid #198754;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-file-import me-2"></i>Importing...</h6>
                <span id="widgetPercentage" class="badge bg-success">0%</span>
            </div>
            
            <div class="progress" style="height: 8px; margin-bottom: 8px; background-color: #e9ecef;">
                <div id="widgetProgressBar" class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                {{-- <small class="text-muted" style="font-size: 12px;">
                    Processed: <strong id="widgetProcessedCount">0</strong> / <span id="widgetTotalCount">0</span>
                </small> --}}
                <div></div> {{-- Spacer to keep Cancel button on right --}}
                <button id="widgetCancelBtn" class="btn btn-sm btn-outline-danger py-0 px-2" style="font-size: 11px;">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
            </div>
            <p id="widgetStatusText" class="mb-0 mt-1 text-muted text-truncate" style="font-size: 11px;">Initializing...</p>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="mb-3 d-none" id="bulkActions">
                    <button class="btn btn-outline-success btn-sm bulk-action" data-status="1">
                        <i class="fa-solid fa-check"></i> Set Active
                    </button>
                    <button class="btn btn-outline-secondary btn-sm bulk-action" data-status="0">
                        <i class="fa-solid fa-ban"></i> Set Draft
                    </button>
                    <span class="ms-2 text-muted" id="selectedCount">0 selected</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered custom-table" id="productsTable">
                        <thead>
                            <tr>
                                <th width="40"><input type="checkbox" id="selectAll" class="form-check-input"></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
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
                                    <td><input type="checkbox" class="product-checkbox form-check-input" value="{{ $product->id }}"></td>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-status" type="checkbox" role="switch" 
                                                data-id="{{ $product->id }}" {{ $product->status ? 'checked' : '' }}>
                                        </div>
                                    </td>
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
                                            <img src="{{ asset('images/cf-logo-1.png') }}" width="50" height="50" class="rounded border">
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
                "order": [[1, 'desc']], // Default sorting by ID column (descending order)
                "columnDefs": [
                    { "orderable": false, "targets": 0 } // Disable sorting on checkbox column
                ]
            });

            // Auto-start widget if import was just queued
            @if(session('show_import_status'))
                $("#importProgressWidget").fadeIn();
                window.importSessionKey = "{{ session('import_key') }}";
                
                if(typeof progressInterval === 'undefined') {
                    progressInterval = setInterval(updateProgress, 1000);
                }
            @endif

            // Status Toggle AJAX
            $(document).on('change', '.toggle-status', function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var productId = $(this).data('id');
                
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('admin.products.toggle-status') }}",
                    data: {
                        'status': status,
                        'id': productId,
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        // console.log(data.message);
                        // Optional: Show toast or alert
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr);
                        alert('Something went wrong!');
                    }
                });
            });

            // Bulk Selection Logic
            $('#selectAll').on('change', function() {
                $('.product-checkbox').prop('checked', $(this).prop('checked'));
                toggleBulkActions();
            });

            $(document).on('change', '.product-checkbox', function() {
                toggleBulkActions();
                // Optionally update selectAll checkbox state
                if ($('.product-checkbox:checked').length == $('.product-checkbox').length) {
                    $('#selectAll').prop('checked', true);
                } else {
                    $('#selectAll').prop('checked', false);
                }
            });

            function toggleBulkActions() {
                var selected = $('.product-checkbox:checked').length;
                if (selected > 0) {
                    $('#bulkActions').removeClass('d-none');
                    $('#selectedCount').text(selected + ' selected');
                } else {
                    $('#bulkActions').addClass('d-none');
                }
            }

            // Bulk Action Click
            $('.bulk-action').on('click', function() {
                var status = $(this).data('status');
                var ids = [];
                $('.product-checkbox:checked').each(function() {
                    ids.push($(this).val());
                });

                if (ids.length === 0) return;

                if (confirm('Are you sure you want to update ' + ids.length + ' products?')) {
                    $.ajax({
                        url: "{{ route('admin.products.bulk-status') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            ids: ids,
                            status: status
                        },
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                alert('Error updating status');
                            }
                        },
                        error: function(xhr) {
                            alert('Something went wrong');
                        }
                    });
                }
            });
        });

        let progressInterval;

        $("form[action='{{ route('admin.products.import') }}']").on('submit', function () {
            // Show new widget
            $("#importProgressWidget").fadeIn();
            
            // Reset values
            $('#widgetProgressBar').css('width', '0%');
            $('#widgetPercentage').text('0%');
            $('#widgetProcessedCount').text('0');
            $('#widgetTotalCount').text('...');
            $('#widgetStatusText').text('Starting upload...');

            // Start polling
            progressInterval = setInterval(updateProgress, 1000); 
        });

        function updateProgress() {
            let url = '{{ route('admin.products.import.progress') }}';
            if (window.importSessionKey) {
                url += '?key=' + window.importSessionKey;
            }

            $.ajax({
                url: url,
                method: 'GET',
                success: function (data) {
                    console.log('Import Progress:', data);
                    
                    let percentage = data.percentage || 0;
                    let current = data.current || 0;
                    let total = data.total || 0;

                    // Update UI
                    $('#widgetProgressBar').css('width', percentage + '%');
                    
                    // Format: 34.52% (58/168)
                    let progressText = percentage.toFixed(2) + '% (' + current + '/' + total + ')';
                    $('#widgetPercentage').text(progressText);
                    
                    $('#widgetProcessedCount').text(current);
                    $('#widgetTotalCount').text(total);

                    // Status text update
                    if (data.status === 'starting' || data.status === 'pending') {
                         $('#widgetStatusText').text('Preparing import...');
                    } else if (data.status === 'processing') {
                         $('#widgetStatusText').text('Processing records...');
                    } else if (data.status === 'completed') {
                         $('#widgetStatusText').text('Import Completed! Reloading...');
                         $('#widgetProgressBar').removeClass('progress-bar-animated');
                         $('#widgetCancelBtn').hide(); // Hide cancel button on success
                    } else if (data.status === 'failed') {
                         $('#widgetStatusText').text('Failed: ' + (data.error || 'Error'));
                         $('#widgetProgressBar').addClass('bg-danger');
                    }

                    // Stop polling when complete or failed
                    if (data.status === 'completed' || data.percentage >= 100) {
                        clearInterval(progressInterval);
                        $('#widgetProgressBar').css('width', '100%');
                        $('#widgetPercentage').text('100%');
                        $('#widgetTotalCount').text(data.total); // Ensure total is accurate
                        setTimeout(function () {
                            // Reload with flag to show summary
                            let currentUrl = new URL(window.location.href);
                            currentUrl.searchParams.set('import_completed', '1');
                            window.location.href = currentUrl.toString();
                        }, 3000); // 3 seconds delay before reload
                    } else if (data.status === 'failed') {
                        clearInterval(progressInterval);
                        setTimeout(function () {
                            location.reload();
                        }, 4000); // 4 seconds delay on failure
                    }
                },
                error: function (xhr, status, error) {
                    // console.error('Failed to fetch progress');
                }
            });
        }

        // Cancel Import Button Handler
        $('#widgetCancelBtn').on('click', function () {
            if (confirm('Are you sure you want to cancel the import?')) {
                $.ajax({
                    url: '{{ route('admin.products.cancel.import') }}',
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (response) {
                        // console.log('Cancelled');
                    }
                });

                clearInterval(progressInterval);
                $('#widgetProgressBar').addClass('bg-danger');
                $('#widgetStatusText').text('Cancelling...');
                
                setTimeout(function () {
                    $('#importProgressWidget').fadeOut();
                    location.reload();
                }, 1500);
            }
        });
    </script>
@endpush