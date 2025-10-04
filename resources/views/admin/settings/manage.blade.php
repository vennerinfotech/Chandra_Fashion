@extends('admin.layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="mb-3">Homepage Settings — Manage All</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- ============ GENERAL (header/footer) ============ --}}

            {{-- ============ HERO SECTION ============ --}}
            <div class="card mb-3">
                <div class="card-header"><strong>Hero Section</strong></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="hero_title" value="{{ old('hero_title', $hero->title ?? '') }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Subtitle</label>
                        <input type="text" name="hero_subtitle" value="{{ old('hero_subtitle', $hero->subtitle ?? '') }}"
                            class="form-control">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Button 1 Text</label>
                            <input type="text" name="hero_btn1_text"
                                value="{{ old('hero_btn1_text', $hero->btn1_text ?? '') }}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Button 1 Link</label>
                            <input type="text" name="hero_btn1_link"
                                value="{{ old('hero_btn1_link', $hero->btn1_link ?? '') }}" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Button 2 Text</label>
                            <input type="text" name="hero_btn2_text"
                                value="{{ old('hero_btn2_text', $hero->btn2_text ?? '') }}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Button 2 Link</label>
                            <input type="text" name="hero_btn2_link"
                                value="{{ old('hero_btn2_link', $hero->btn2_link ?? '') }}" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Button 3 Text</label>
                            <input type="text" name="hero_btn3_text"
                                value="{{ old('hero_btn3_text', $hero->btn3_text ?? '') }}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Button 3 Link</label>
                            <input type="text" name="hero_btn3_link"
                                value="{{ old('hero_btn3_link', $hero->btn3_link ?? '') }}" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Hero Background Image</label>
                        <input type="file" name="hero_image" class="form-control-file">
                        @if(!empty($hero->background_image))
                            <img src="{{ asset('storage/' . $hero->background_image) }}" style="height:90px;margin-top:8px;">
                        @endif
                    </div>
                </div>
            </div>

            {{-- ============ COLLECTIONS SECTION ============ --}}
            <div class="card mb-3">
                <div class="card-header"><strong>Collections Section</strong></div>
                <div class="card-body">
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

            {{-- ============ CARD SECTION ============ --}}
            <div class="card mb-3">
                <div class="card-header"><strong>Feature Cards</strong></div>
                <div class="card-body">
                    <div class="row">
                        @for($i = 0; $i < 3; $i++)
                            <div class="col-lg-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body text-center d-flex flex-column align-items-center gap-3">

                                        {{-- SVG Upload --}}
                                        <div class="w-100">
                                            <label>SVG Icon</label>
                                            <input type="file" name="cards[{{ $i }}][svg]" class="form-control-file"
                                                accept=".svg">
                                            @if(!empty($cards[$i]->svg_path ?? ''))
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $cards[$i]->svg_path) }}" style="height:50px;">
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Title --}}
                                        <div class="mb-2 w-100">
                                            <label>Title</label>
                                            <input type="text" name="cards[{{ $i }}][title]"
                                                value="{{ $cards[$i]->title ?? '' }}" class="form-control" required>
                                        </div>

                                        {{-- Description --}}
                                        <div class="mb-2 w-100">
                                            <label>Description</label>
                                            <input type="text" name="cards[{{ $i }}][description]"
                                                value="{{ $cards[$i]->description ?? '' }}" class="form-control">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- ============ FEATURED COLLECTIONS SECTION ============ --}}
            <div class="card mb-3">
                <div class="card-header"><strong>Featured Collections Section</strong></div>
                <div class="card-body">
                    {{-- Section Main Title --}}
                    <div class="mb-3">
                        <label>Main Section Title</label>
                        <input type="text" name="featured_main_title"
                            value="{{ old('featured_main_title', $featured->main_title ?? 'Featured Collections') }}"
                            class="form-control" required>
                    </div>

                    {{-- Section Main Subtitle --}}
                    <div class="mb-3">
                        <label>Main Section Subtitle</label>
                        <input type="text" name="featured_main_subtitle"
                            value="{{ old('featured_main_subtitle', $featured->main_subtitle ?? 'Discover our latest designs and seasonal highlights') }}"
                            class="form-control">
                    </div>

                    <hr>

                    {{-- Collection Cards --}}
                    <h5>Collection Cards</h5>
                    <div id="cards-wrapper">
                        @foreach($featuredCards as $index => $card)
                            <div class="card mb-3 p-3 border">
                                <input type="hidden" name="cards[{{ $index }}][id]" value="{{ $card->id }}">

                                <div class="mb-2">
                                    <label>Card Title</label>
                                    <input type="text" name="cards[{{ $index }}][title]"
                                        value="{{ old('cards.' . $index . '.title', $card->title) }}" class="form-control"
                                        required>
                                </div>

                                <div class="mb-2">
                                    <label>Card Subtitle</label>
                                    <input type="text" name="cards[{{ $index }}][subtitle]"
                                        value="{{ old('cards.' . $index . '.subtitle', $card->subtitle) }}"
                                        class="form-control">
                                </div>

                                <div class="mb-2">
                                    <label>Card Image</label>
                                    <input type="file" name="cards[{{ $index }}][image]" class="form-control">
                                    @if($card->image)
                                        <img src="{{ asset('storage/' . $card->image) }}" alt="Card Image" class="mt-2"
                                            style="max-width: 150px;">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Add New Card Button --}}
                    <button type="button" id="add-card-btn" class="btn btn-secondary mt-2">Add New Card</button>
                </div>
            </div>



            {{-- ============ HERITAGE SECTION ============ --}}
            <div class="card mb-3">
                <div class="card-header"><strong>Heritage Section</strong></div>
                <div class="card-body">
                    {{-- Section Title --}}
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="heritage_title"
                            value="{{ old('heritage_title', $heritage->title ?? 'Heritage of Excellence') }}"
                            class="form-control" required>
                    </div>

                    {{-- Description 1 --}}
                    <div class="mb-3">
                        <label>Paragraph 1</label>
                        <textarea name="heritage_paragraph1" class="form-control"
                            rows="3">{{ old('heritage_paragraph1', $heritage->paragraph1 ?? 'For over three decades, Chandra Fashion has been at the forefront of premium clothing manufacturing, blending traditional craftsmanship with modern innovation.') }}</textarea>
                    </div>

                    {{-- Description 2 --}}
                    <div class="mb-3">
                        <label>Paragraph 2</label>
                        <textarea name="heritage_paragraph2" class="form-control"
                            rows="3">{{ old('heritage_paragraph2', $heritage->paragraph2 ?? 'Our commitment to quality, sustainability, and customer satisfaction has made us a trusted partner for fashion brands worldwide.') }}</textarea>
                    </div>

                    {{-- Button Text --}}
                    <div class="mb-3">
                        <label>Button Text</label>
                        <input type="text" name="heritage_btn_text"
                            value="{{ old('heritage_btn_text', $heritage->button_text ?? 'Our Story') }}"
                            class="form-control">
                    </div>

                    {{-- Image --}}
                    <div class="mb-3">
                        <label>Heritage Image</label>
                        <input type="file" name="heritage_image" class="form-control-file">
                        @if(!empty($heritage->image))
                            <img src="{{ asset('storage/' . $heritage->image) }}" style="height:120px;margin-top:8px;">
                        @endif
                    </div>
                </div>
            </div>


            {{-- ============ CLIENT SECTION — Add New Only ============ --}}
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Client Section</strong>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addClientBtn">+ Add New</button>
                </div>
                <div class="card-body">
                    {{-- Container for all client rows --}}
                    <div id="client-rows">
                        @foreach($clients as $index => $client)
                            <div class="client-row border p-3 mb-2">
                                <div class="row align-items-center">
                                    <div class="col-md-2 mb-2">
                                        <label>Image</label>
                                        <input type="file" name="clients[existing][image][{{ $client->id }}]"
                                            class="form-control-file">
                                        @if($client->image)
                                            <img src="{{ asset('storage/' . $client->image) }}" style="height:80px;margin-top:5px;">
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
                                    <div class="col-md-4 mb-2">
                                        <label>Quote</label>
                                        <input type="text" name="clients[existing][quote][{{ $client->id }}]"
                                            value="{{ old('clients.existing.quote.' . $client->id, $client->quote) }}"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Default new client row for adding --}}
                        <div class="client-row border p-3 mb-2">
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
                                    <input type="text" name="clients[new][designation][]" placeholder="Designation"
                                        class="form-control">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>Quote</label>
                                    <input type="text" name="clients[new][quote][]" placeholder="Quote"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- ============ SUBSCRIPTION SECTION — Manage Text ============ --}}
            <div class="card mb-3">
                <div class="card-header"><strong>Subscription Section Text</strong></div>
                <div class="card-body">
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

            {{-- ============ FOOTER SECTION ============ --}}
            {{-- <div class="card mb-3">
                <div class="card-header"><strong>Footer Settings</strong></div>
                <div class="card-body"> --}}

                    {{-- Brand Info --}}
                    {{-- <h5>Brand Info</h5>
                    <div class="mb-3">
                        <label>Brand Name</label>
                        <input type="text" name="footer_brand_name"
                            value="{{ old('footer_brand_name', $footer->brand_name ?? '') }}" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Brand Description</label>
                        <textarea name="footer_brand_desc" class="form-control"
                            rows="3">{{ old('footer_brand_desc', $footer->brand_desc ?? '') }}</textarea>
                    </div> --}}

                    {{-- Social Links --}}
                    {{-- <h5>Social Links</h5>
                    <div class="mb-2">
                        <label>Facebook URL</label>
                        <input type="text" name="footer_facebook"
                            value="{{ old('footer_facebook', $footer->facebook ?? '') }}" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Instagram URL</label>
                        <input type="text" name="footer_instagram"
                            value="{{ old('footer_instagram', $footer->instagram ?? '') }}" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>LinkedIn URL</label>
                        <input type="text" name="footer_linkedin"
                            value="{{ old('footer_linkedin', $footer->linkedin ?? '') }}" class="form-control">
                    </div> --}}

                    {{-- Quick Links --}}
                    {{-- <h5>Quick Links</h5>
                    <div id="quick-links-container"> --}}
                        {{-- Default row --}}
                        {{-- <div class="row mb-2 quick-link-row">
                            <div class="col-md-5 mb-2">
                                <input type="text" name="footer_quick[new][text][]" class="form-control"
                                    placeholder="Link Text" required>
                            </div>
                            <div class="col-md-5 mb-2">
                                <input type="text" name="footer_quick[new][url][]" class="form-control"
                                    placeholder="Link URL" required>
                            </div>
                            <div class="col-md-2 mb-2 d-flex align-items-end">
                                <button class="btn btn-danger btn-sm w-100 remove-quick-link">Remove</button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <a href="#" class="btn btn-sm btn-outline-primary" onclick="addQuickLink(); return false;">+ Add
                            Quick Link</a>
                    </div> --}}

                    {{-- Services --}}
                    {{-- <h5>Services</h5>
                    <div id="services-container"> --}}
                        {{-- Default row --}}
                        {{-- <div class="row mb-2 service-row">
                            <div class="col-md-5 mb-2">
                                <input type="text" name="footer_service[new][text][]" class="form-control"
                                    placeholder="Service Text" required>
                            </div>
                            <div class="col-md-5 mb-2">
                                <input type="text" name="footer_service[new][url][]" class="form-control"
                                    placeholder="Service URL" required>
                            </div>
                            <div class="col-md-2 mb-2 d-flex align-items-end">
                                <button class="btn btn-danger btn-sm w-100 remove-service">Remove</button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <a href="#" class="btn btn-sm btn-outline-primary" onclick="addService(); return false;">+ Add
                            Service</a>
                    </div> --}}

                    {{-- Contact Info --}}
                    {{-- <h5>Contact Info</h5>
                    <div class="mb-2">
                        <label>Address</label>
                        <input type="text" name="footer_address" value="{{ old('footer_address', $footer->address ?? '') }}"
                            class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Phone</label>
                        <input type="text" name="footer_phone" value="{{ old('footer_phone', $footer->phone ?? '') }}"
                            class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Email</label>
                        <input type="text" name="footer_email" value="{{ old('footer_email', $footer->email ?? '') }}"
                            class="form-control">
                    </div> --}}

                    {{-- Copyright --}}
                    {{-- <div class="mb-2">
                        <label>Copyright Text</label>
                        <input type="text" name="footer_copyright"
                            value="{{ old('footer_copyright', $footer->copyright ?? '') }}" class="form-control">
                    </div>
                </div>
            </div> --}}
            <div class="card mb-3">
                <div class="card-body text-end">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fa fa-check-circle me-2"></i> Save All Settings
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- quick JS to allow the "create" nested forms to submit directly --}}
    <script>
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


        // title subtitle image js

        let cardIndex = {{ $featuredCards->count() }};
        document.getElementById('add-card-btn').addEventListener('click', function () {
            const wrapper = document.getElementById('cards-wrapper');
            const cardHtml = `
                    <div class="card mb-3 p-3 border">
                        <div class="mb-2">
                            <label>Card Title</label>
                            <input type="text" name="cards[${cardIndex}][title]" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label>Card Subtitle</label>
                            <input type="text" name="cards[${cardIndex}][subtitle]" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Card Image</label>
                            <input type="file" name="cards[${cardIndex}][image]" class="form-control">
                        </div>
                    </div>
                `;
            wrapper.insertAdjacentHTML('beforeend', cardHtml);
            cardIndex++;
        });
    </script>
@endsection
