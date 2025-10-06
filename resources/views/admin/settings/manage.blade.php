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
                    data-target="#hero-section">
                    <strong>Hero Section</strong>
                    <span class="toggle-icon">+</span>
                </div>
                <div class="card-body section-body" id="hero-section">
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
                            <img src="{{ asset($hero->background_image) }}" style="height:90px;margin-top:8px;">
                        @endif
                    </div>
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
                            <div class="card mb-3 p-3 border">
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
                            </div>
                        @endforeach
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
                        @foreach($clients as $index => $client)
                            <div class="client-row border p-3 mb-2">
                                <div class="row align-items-center">
                                    <div class="col-md-2 mb-2">
                                        <label>Image</label>
                                        <input type="file" name="clients[existing][image][{{ $client->id }}]"
                                            class="form-control-file">
                                        @if($client->image)
                                            <img src="{{ asset($client->image) }}" style="height:80px;margin-top:5px;">
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
                        {{-- New client row --}}
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
                                <div class="col-md-3 mb-2">
                                    <label>Title</label>
                                    <input type="text" name="contact_infos[{{ $index }}][title]" value="{{ $contact->title }}"
                                        class="form-control" required>
                                </div>
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

    {{-- ================= JS ================= --}}
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
    </script>
@endsection
