@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="mb-3">Homepage Settings — Manage All</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- ================= HERO SECTION ================= --}}
            <div class="card mb-3">
                <div class="card-header section-header d-flex justify-content-between align-items-center"
                    data-target="#hero-sections-body">
                    <strong>Hero Sections</strong>
                    <span class="toggle-icon">+</span>
                </div>
                <div class="card-body section-body" id="hero-sections-body">
                    <button type="button" id="add-hero-btn" class="btn btn-sm btn-primary mb-3">Add Hero</button>

                    @forelse($heroSections as $index => $hero)
                        <div class="hero-section mb-3 p-3 border rounded">
                            <input type="hidden" name="hero_id[]" value="{{ $hero->id }}">
                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" name="hero_title[]" class="form-control" value="{{ $hero->title }}">
                            </div>
                            <div class="mb-3">
                                <label>Subtitle</label>
                                <input type="text" name="hero_subtitle[]" class="form-control" value="{{ $hero->subtitle }}">
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Button 1 Text</label>
                                    <input type="text" name="hero_btn1_text[]" class="form-control"
                                        value="{{ $hero->btn1_text }}">
                                </div>
                                <div class="col-md-4">
                                    <label>Button 1 Link</label>
                                    <input type="text" name="hero_btn1_link[]" class="form-control"
                                        value="{{ $hero->btn1_link }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Button 2 Text</label>
                                    <input type="text" name="hero_btn2_text[]" class="form-control"
                                        value="{{ $hero->btn2_text }}">
                                </div>
                                <div class="col-md-4">
                                    <label>Button 2 Link</label>
                                    <input type="text" name="hero_btn2_link[]" class="form-control"
                                        value="{{ $hero->btn2_link }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Button 3 Text</label>
                                    <input type="text" name="hero_btn3_text[]" class="form-control"
                                        value="{{ $hero->btn3_text }}">
                                </div>
                                <div class="col-md-4">
                                    <label>Button 3 Link</label>
                                    <input type="text" name="hero_btn3_link[]" class="form-control"
                                        value="{{ $hero->btn3_link }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Hero Background Image</label>
                                <input type="file" name="hero_image[]" class="form-control-file">
                                @if($hero->background_image)
                                    <div class="mt-2">
                                        <img src="{{ asset($hero->background_image) }}" alt="Hero Image" style="height: 80px;">
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-sm btn-danger remove-hero-btn">Remove</button>
                        </div>
                    @empty
                        {{-- No heroes exist, show one empty form --}}
                        <div class="hero-section mb-3 p-3 border rounded">
                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" name="hero_title[]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Subtitle</label>
                                <input type="text" name="hero_subtitle[]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Hero Background Image</label>
                                <input type="file" name="hero_image[]" class="form-control-file">
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>


            {{-- ================= COLLECTIONS SECTION ================= --}}
            <div class="card mb-3">
                <div class="card-header section-header d-flex justify-content-between align-items-center"
                    data-target="#collections-section">
                    <strong>Collections Section</strong>
                    <span class="toggle-icon">+</span>
                </div>
                <div class="card-body section-body" id="collections-section">
                    <div class="mb-3">
                        <label>Section Title</label>
                        <input type="text" name="collections_title"
                            value="{{ old('collections_title', $collections->title ?? 'Our Collections') }}"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Section Subtitle</label>
                        <textarea name="collections_subtitle" class="form-control"
                            rows="2">{{ old('collections_subtitle', $collections->subtitle ?? 'Specialized manufacturing across diverse fashion categories with uncompromising quality standards') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ================= FEATURE CARDS SECTION ================= --}}
            <div class="card mb-3">
                <div class="card-header section-header d-flex justify-content-between align-items-center"
                    data-target="#cards-section">
                    <strong>Feature Cards Section</strong>
                    <span class="toggle-icon">+</span>
                </div>
                <div class="card-body section-body" id="cards-section">
                    <div class="row">
                        @foreach($cards as $index => $card)
                            <div class="col-lg-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body text-center d-flex flex-column align-items-center gap-3">
                                        <div class="w-100">
                                            <label>SVG Icon</label>
                                            <input type="file" name="cards[{{ $index }}][svg]" class="form-control-file"
                                                accept=".svg">
                                            @if($card->svg_path)
                                                <div class="mt-2">
                                                    <img src="{{ asset($card->svg_path) }}" style="height:50px;">
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mb-2 w-100">
                                            <label>Title</label>
                                            <input type="hidden" name="cards[{{ $index }}][id]" value="{{ $card->id }}">
                                            <input type="text" name="cards[{{ $index }}][title]" value="{{ $card->title }}"
                                                class="form-control" required>
                                        </div>
                                        <div class="mb-2 w-100">
                                            <label>Description</label>
                                            <input type="text" name="cards[{{ $index }}][description]"
                                                value="{{ $card->description }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ================= FEATURED COLLECTIONS ================= --}}
            <div class="card mb-3">
                <div class="card-header section-header d-flex justify-content-between align-items-center"
                    data-target="#featured-section">
                    <strong>Featured Collections Section</strong>
                    <span class="toggle-icon">+</span>
                </div>
                <div class="card-body section-body" id="featured-section">
                    <div class="mb-3">
                        <label>Main Section Title</label>
                        <input type="text" name="featured_main_title"
                            value="{{ old('featured_main_title', $featured->main_title ?? 'Featured Collections') }}"
                            class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Main Section Subtitle</label>
                        <input type="text" name="featured_main_subtitle"
                            value="{{ old('featured_main_subtitle', $featured->main_subtitle ?? 'Discover our latest designs') }}"
                            class="form-control">
                    </div>
                    <hr>
                    <h5>Collection Cards</h5>
                    <div id="cards-wrapper">
                        @foreach($featuredCards as $index => $card)
                            <div class="card mb-3 p-3 border featured-collection-card">
                                <input type="hidden" name="featured_deleted_ids[]" id="featured-deleted-ids">
                                <input type="hidden" name="featured_collections[{{ $index }}][id]" value="{{ $card->id }}">
                                <div class="mb-2 w-100">
                                    <label>Title</label>
                                    <input type="text" name="featured_collections[{{ $index }}][title]"
                                        value="{{ $card->title }}" class="form-control" required>
                                </div>
                                <div class="mb-2 w-100">
                                    <label>Subtitle</label>
                                    <input type="text" name="featured_collections[{{ $index }}][subtitle]"
                                        value="{{ $card->subtitle }}" class="form-control">
                                </div>
                                <div class="mb-2">
                                    <label>Card Image</label>
                                    <input type="file" name="featured_collections[{{ $index }}][image]" class="form-control">
                                    @if($card->image)
                                        <img src="{{ asset($card->image) }}" alt="Card Image" class="mt-2"
                                            style="max-width: 150px;">
                                    @endif
                                </div>
                                <div class="text-end">
                                    <button type="button" class="btn btn-sm btn-danger remove-featured-card">Remove</button>
                                </div>
                            </div>
                        @endforeach


                        {{-- Add New Card Button --}}
                        <button type="button" id="add-card-btn" class="btn btn-secondary mt-2">Add New Card</button>
                    </div>
                </div>
            </div>

            {{-- ================= HERITAGE ================= --}}
            <div class="card mb-3">
                <div class="card-header section-header d-flex justify-content-between align-items-center"
                    data-target="#heritage-section">
                    <strong>Heritage Section</strong>
                    <span class="toggle-icon">+</span>
                </div>
                <div class="card-body section-body" id="heritage-section">
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="heritage_title"
                            value="{{ old('heritage_title', $heritage->title ?? 'Heritage of Excellence') }}"
                            class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Paragraph 1</label>
                        <textarea name="heritage_paragraph1" class="form-control"
                            rows="3">{{ old('heritage_paragraph1', $heritage->paragraph1 ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Paragraph 2</label>
                        <textarea name="heritage_paragraph2" class="form-control"
                            rows="3">{{ old('heritage_paragraph2', $heritage->paragraph2 ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Button Text</label>
                        <input type="text" name="heritage_btn_text"
                            value="{{ old('heritage_btn_text', $heritage->button_text ?? 'Our Story') }}"
                            class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Heritage Image</label>
                        <input type="file" name="heritage_image" class="form-control-file">
                        @if(!empty($heritage->image))
                            <img src="{{ asset($heritage->image) }}" style="height:120px;margin-top:8px;">
                        @endif
                    </div>
                </div>
            </div>

            {{-- ================= CLIENTS ================= --}}
            <div class="card mb-3">
                <div class="card-header section-header d-flex justify-content-between align-items-center"
                    data-target="#clients-section">
                    <strong>Client Section</strong>
                    <span class="toggle-icon">+</span>
                </div>
                <div class="card-body section-body" id="clients-section">
                    <div id="client-rows">
                        <button type="button" class="btn btn-sm btn-outline-primary" id="addClientBtn">+ Add New</button>
                        @foreach($clients as $client)
                            <div class="client-row border p-3 mb-2" data-client-id="{{ $client->id }}">
                                <div class="row align-items-center">
                                    <div class="col-md-2 mb-2">
                                        <label>Image</label>
                                        <input type="file" name="clients[existing][image][{{ $client->id }}]"
                                            class="form-control-file">
                                        @if($client->image)
                                            <img src="{{ asset($client->image) }}" width="80" height="80" class="rounded">
                                        @endif
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label>Name</label>
                                        <input type="text" name="clients[existing][name][{{ $client->id }}]"
                                            value="{{ old('clients.existing.name.' . $client->id, $client->name) }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label>Designation</label>
                                        <input type="text" name="clients[existing][designation][{{ $client->id }}]"
                                            value="{{ old('clients.existing.designation.' . $client->id, $client->designation) }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label>Quote</label>
                                        <input type="text" name="clients[existing][quote][{{ $client->id }}]"
                                            value="{{ old('clients.existing.quote.' . $client->id, $client->quote) }}"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-1 mb-2 d-flex align-items-end">
                                        <button type="button"
                                            class="btn btn-sm btn-danger removeExistingClientBtn">Remove</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>

                </div>
            </div>

            {{-- ================= SUBSCRIPTION ================= --}}
            <div class="card mb-3">
                <div class="card-header section-header d-flex justify-content-between align-items-center"
                    data-target="#subscription-section">
                    <strong>Subscription Section</strong>
                    <span class="toggle-icon">+</span>
                </div>
                <div class="card-body section-body" id="subscription-section">
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="subscription_title"
                            value="{{ old('subscription_title', $subscription->title ?? '') }}" class="form-control"
                            required>
                    </div>
                    <div class="mb-3">
                        <label>Subtitle / Description</label>
                        <textarea name="subscription_subtitle" class="form-control"
                            rows="3">{{ old('subscription_subtitle', $subscription->subtitle ?? '') }}</textarea>
                    </div>
                </div>
            </div>
            {{-- ================= CONTACT INFO ================= --}}
            <div class="card mb-3">
                <div class="card-header section-header d-flex justify-content-between align-items-center"
                    data-target="#contact-section">
                    <strong>Contact Info Section</strong>
                    <span class="toggle-icon">+</span>
                </div>
                <div class="card-body section-body" id="contact-section">
                    @foreach($contact_infos as $index => $contact)
                        <div class="contact-row border p-3 mb-2">
                            <input type="hidden" name="contact_infos[{{ $index }}][id]" value="{{ $contact->id }}">
                            <div class="row align-items-center">
                                {{-- Title --}}
                                <div class="col-md-3 mb-2">
                                    <label>Title</label>
                                    <input type="text" name="contact_infos[{{ $index }}][title]" value="{{ $contact->title }}"
                                        class="form-control" required>
                                </div>

                                {{-- Type Dropdown --}}
                                <div class="col-md-2 mb-2">
                                    <label>Type</label>
                                    <select name="contact_infos[{{ $index }}][type]" class="form-control">
                                        <option value="address" {{ $contact->type == 'address' ? 'selected' : '' }}>Address
                                        </option>
                                        <option value="phone" {{ $contact->type == 'phone' ? 'selected' : '' }}>Phone</option>
                                        <option value="email" {{ $contact->type == 'email' ? 'selected' : '' }}>Email</option>
                                        <option value="hours" {{ $contact->type == 'hours' ? 'selected' : '' }}>hours</option>
                                    </select>
                                </div>

                                {{-- Details --}}
                                <div class="col-md-5 mb-2">
                                    <label>Details</label>
                                    <textarea name="contact_infos[{{ $index }}][details]" class="form-control"
                                        rows="2">{{ $contact->details }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ================= SUBMIT BUTTON ================= --}}
            <div class="card mb-3">
                <div class="card-body text-end">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fa fa-check-circle me-2"></i> Save All Settings
                    </button>
                </div>
            </div>
        </form>
    </div>

    <style>
        .section-body {
            display: none;
        }

        .section-header.active {
            font-weight: bold;
        }

        .section-header .toggle-icon {
            font-weight: bold;
        }
    </style>

    <script>
        const headers = document.querySelectorAll('.section-header');

        headers.forEach(header => {
            header.addEventListener('click', () => {
                // Close all other sections
                headers.forEach(h => {
                    if (h !== header) {
                        h.classList.remove('active');
                        const body = document.querySelector(h.dataset.target);
                        if (body) body.style.display = 'none';
                        const icon = h.querySelector('.toggle-icon');
                        if (icon) icon.textContent = '+';
                    }
                });

                // Toggle current section
                header.classList.toggle('active');
                const target = document.querySelector(header.dataset.target);
                const icon = header.querySelector('.toggle-icon');
                if (target) {
                    if (header.classList.contains('active')) {
                        target.style.display = 'block';
                        if (icon) icon.textContent = '−';
                    } else {
                        target.style.display = 'none';
                        if (icon) icon.textContent = '+';
                    }
                }
            });
        });


        function addNewCardRow() {
            var container = document.getElementById('add-card-section');

            // Create a new row div with SVG + inputs (HTML string)
            var newRow = document.createElement('div');
            newRow.innerHTML = `
                                                                        <div class="row new-card-row">
                                                                            <div class="col-lg-4">
                                                                                <div class="card">
                                                                                    <div class="card-body text-center d-flex flex-column align-items-center gap-3">
                                                                                        <div class="svg-wrapper">

                                                                                        </div>
                                                                                        <div class="mb-2 w-100">
                                                                                            <label>Title</label>
                                                                                            <input type="text" name="cards[new][title][]" class="form-control" required>
                                                                                        </div>
                                                                                        <div class="mb-2 w-100">
                                                                                            <label>Description</label>
                                                                                            <input type="text" name="cards[new][description][]" class="form-control">
                                                                                        </div>
                                                                                        <button type="button" class="btn btn-danger remove-row">Remove</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        `;

            // Append to container
            container.appendChild(newRow);

            // Add remove event
            newRow.querySelector('.remove-row').addEventListener('click', function () {
                newRow.remove();
            });
        }

        //  JS to dynamically add more rows
        document.getElementById('addClientBtn').addEventListener('click', function () {
            const container = document.getElementById('client-rows');
            const newRow = document.createElement('div');
            newRow.classList.add('client-row', 'border', 'p-3', 'mb-2');
            newRow.innerHTML = `
                                                                            <div class="row align-items-center">
                                                                                <div class="col-md-2 mb-2">
                                                                                    <label>Image</label>
                                                                                    <input type="file" name="clients[new][image][]" class="form-control-file">
                                                                                </div>
                                                                                <div class="col-md-3 mb-2">
                                                                                    <label>Name</label>
                                                                                    <input type="text" name="clients[new][name][]" placeholder="Name" class="form-control">
                                                                                </div>
                                                                                <div class="col-md-3 mb-2">
                                                                                    <label>Designation</label>
                                                                                    <input type="text" name="clients[new][designation][]" placeholder="Designation" class="form-control">
                                                                                </div>
                                                                                <div class="col-md-3 mb-2">
                                                                                    <label>Quote</label>
                                                                                    <input type="text" name="clients[new][quote][]" placeholder="Quote" class="form-control">
                                                                                </div>
                                                                                <div class="col-md-1 mb-2 d-flex align-items-end">
                                                                                    <button type="button" class="btn btn-sm btn-danger cancelClientBtn">Cancel</button>
                                                                                </div>
                                                                            </div>
                                                                        `;
            container.appendChild(newRow);

            // Attach Cancel event
            newRow.querySelector('.cancelClientBtn').addEventListener('click', function () {
                newRow.remove();
            });
        });
        document.querySelectorAll('.removeExistingClientBtn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const row = btn.closest('.client-row');
                const clientId = row.dataset.clientId;

                if (confirm('Are you sure you want to delete this client?')) {
                    // Add a hidden input for deleted client IDs
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'clients[deleted][]';
                    input.value = clientId;
                    document.querySelector('#client-rows').appendChild(input);

                    // Remove row visually
                    row.remove();
                }
            });
        });


        function addQuickLink() {
            let container = document.getElementById('quick-links-container');
            let html = `
                                                                        <div class="row mb-2 quick-link-row">
                                                                            <div class="col-md-5 mb-2">
                                                                                <input type="text" name="footer_quick[new][text][]" class="form-control" placeholder="Link Text" required>
                                                                            </div>
                                                                            <div class="col-md-5 mb-2">
                                                                                <input type="text" name="footer_quick[new][url][]" class="form-control" placeholder="Link URL" required>
                                                                            </div>
                                                                            <div class="col-md-2 mb-2 d-flex align-items-end">
                                                                                <button class="btn btn-danger btn-sm w-100 remove-quick-link">Remove</button>
                                                                            </div>
                                                                        </div>`;
            container.insertAdjacentHTML('beforeend', html);
        }

        function addService() {
            let container = document.getElementById('services-container');
            let html = `
                                                                        <div class="row mb-2 service-row">
                                                                            <div class="col-md-5 mb-2">
                                                                                <input type="text" name="footer_service[new][text][]" class="form-control" placeholder="Service Text" required>
                                                                            </div>
                                                                            <div class="col-md-5 mb-2">
                                                                                <input type="text" name="footer_service[new][url][]" class="form-control" placeholder="Service URL" required>
                                                                            </div>
                                                                            <div class="col-md-2 mb-2 d-flex align-items-end">
                                                                                <button class="btn btn-danger btn-sm w-100 remove-service">Remove</button>
                                                                            </div>
                                                                        </div>`;
            container.insertAdjacentHTML('beforeend', html);
        }

        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-quick-link')) {
                e.target.closest('.quick-link-row').remove();
            }
            if (e.target && e.target.classList.contains('remove-service')) {
                e.target.closest('.service-row').remove();
            }
        });



        // Start index based on existing cards
        let featuredCardIndex = {{ $featuredCards->count() }};

        // Add new Featured Collection card
        document.getElementById('add-card-btn').addEventListener('click', function () {
            const wrapper = document.getElementById('cards-wrapper');
            const cardHtml = `
                                            <div class="card mb-3 p-3 border featured-collection-card">
                                                <div class="mb-2">
                                                    <label>Title</label>
                                                    <input type="text" name="featured_collections[${featuredCardIndex}][title]" class="form-control" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label>Subtitle</label>
                                                    <input type="text" name="featured_collections[${featuredCardIndex}][subtitle]" class="form-control">
                                                </div>
                                                <div class="mb-2">
                                                    <label>Card Image</label>
                                                    <input type="file" name="featured_collections[${featuredCardIndex}][image]" class="form-control">
                                                </div>
                                                <div class="text-end">
                                                    <button type="button" class="btn btn-sm btn-danger remove-featured-card">Remove</button>
                                                </div>
                                            </div>
                                        `;
            wrapper.insertAdjacentHTML('beforeend', cardHtml);
            featuredCardIndex++;
        });

        // Remove existing or newly added Featured Collection card
        document.getElementById('cards-wrapper').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-featured-card')) {
                e.target.closest('.featured-collection-card').remove();
            }
        });

        document.getElementById('cards-wrapper').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-featured-card')) {
                const card = e.target.closest('.featured-collection-card');

                // If card has an ID (existing in DB)
                const hiddenInput = card.querySelector('input[name*="[id]"]');
                if (hiddenInput && hiddenInput.value) {
                    // Create a new hidden input for each deleted ID
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'featured_deleted_ids[]';
                    input.value = hiddenInput.value;
                    document.querySelector('form').appendChild(input);
                }

                // Remove from UI
                card.remove();
            }
        });




        document.getElementById('add-hero-btn').addEventListener('click', function () {
            let container = document.getElementById('hero-sections-body');
            let template = container.querySelector('.hero-section').cloneNode(true);

            // Clear values for new section
            template.querySelectorAll('input').forEach(input => {
                if (input.type === 'file') {
                    input.value = '';
                } else {
                    input.value = '';
                }
            });

            container.appendChild(template);
        });

        // Remove hero section
        document.getElementById('hero-sections-body').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-hero-btn')) {
                e.target.closest('.hero-section').remove();
            }
        });


    </script>
@endsection
