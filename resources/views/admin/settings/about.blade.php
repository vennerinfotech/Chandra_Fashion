@extends('admin.layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-3">About Section — Manage</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Hero / Top --}}
        <div class="card mb-3">
            <div class="card-header section-header" data-target="#heroSection">
                <strong>Hero / Top</strong>
                <span class="toggle-icon">+</span>
            </div>
            <div id="heroSection" class="section-body" style="display:none;">
                <div class="card-body">
                    <div class="mb-3">
                        <label>About Title</label>
                        <input type="text" name="about_title" class="form-control" value="{{ old('about_title', $about->about_title ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label>About Subtitle</label>
                        <input type="text" name="about_subtitle" class="form-control" value="{{ old('about_subtitle', $about->about_subtitle ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label>Experience Years</label>
                        <input type="number" name="experience_years" class="form-control" value="{{ old('experience_years', $about->experience_years ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label>Hero Image</label>
                        <input type="file" name="hero_image" class="form-control-file">
                        @if(!empty($about->hero_image))
                        <img src="{{ asset($about->hero_image) }}" style="max-height:120px;" class="mt-2">
                        @endif
                    </div>
                    <div class="mb-3">
                        <label>Paragraph 1</label>
                        <textarea name="paragraph1" class="form-control" rows="4">{{ old('paragraph1', $about->paragraph1 ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Paragraph 2</label>
                        <textarea name="paragraph2" class="form-control" rows="4">{{ old('paragraph2', $about->paragraph2 ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Testimonial Text</label>
                        <textarea name="testimonial_text" class="form-control" rows="3">{{ old('testimonial_text', $about->testimonial_text ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Author</label>
                        <input type="text" name="testimonial_author" class="form-control" value="{{ old('testimonial_author', $about->testimonial_author ?? '') }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Why Choose Us --}}
        <div class="card mb-3">
            <div class="card-header section-header" data-target="#whySection">
                <strong>Why Choose Us</strong>
                <span class="toggle-icon">+</span>
            </div>
            <div id="whySection" class="section-body" style="display:none;">
                <div class="card-body">
                    <div class="mb-3">
                        <label>Title</label>
                        <input type="text" name="why_title" class="form-control" value="{{ old('why_title', $about->why_title ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label>Paragraph 1</label>
                        <textarea name="why_choose_us_1" class="form-control" rows="3">{{ old('why_choose_us_1', $about->why_choose_us_1 ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Paragraph 2</label>
                        <textarea name="why_choose_us_2" class="form-control" rows="3">{{ old('why_choose_us_2', $about->why_choose_us_2 ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label>Why Choose Us Image</label>
                        <input type="file" name="why_choose_us_image" class="form-control-file">
                        @if(!empty($about->why_choose_us_image))
                        <img src="{{ asset($about->why_choose_us_image) }}" style="max-height:120px;" class="mt-2">
                        @endif
                    </div>

                    <label>Bullet Points</label>
                    <div id="why-list">
                        @php $whyList = old('why_list', $about->why_list ?? []); @endphp
                        @if(count($whyList) > 0)
                            @foreach($whyList as $w)
                            <div class="d-flex mb-2">
                                <input type="text" name="why_list[]" class="form-control me-2" value="{{ $w }}">
                                <button type="button" class="btn btn-danger remove-why">Remove</button>
                            </div>
                            @endforeach
                        @else
                            <div class="d-flex mb-2">
                                <input type="text" name="why_list[]" class="form-control me-2" placeholder="Bullet point">
                                <button type="button" class="btn btn-danger remove-why">Remove</button>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add-why" class="btn btn-sm btn-secondary mt-2">Add Bullet</button>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="card mb-3">
            <div class="card-header section-header" data-target="#statsSection">
                <strong>Stats (Showcase numbers)</strong>
                <span class="toggle-icon">+</span>
            </div>
            <div id="statsSection" class="section-body" style="display:none;">
                <div class="card-body">
                    @php $stats = old('stats', $about->stats ?? [
                        ['label'=>'Happy Customers','number'=>15,'suffix'=>'k'],
                        ['label'=>'Team Members','number'=>15,'suffix'=>'+'],
                        ['label'=>'Total Awards','number'=>50,'suffix'=>'+'],
                        ['label'=>'Total Products','number'=>500,'suffix'=>'+'],
                    ]); @endphp

                    <div id="stats-wrapper">
                        @foreach($stats as $s)
                        <div class="row mb-2 align-items-center">
                            <div class="col-md-5">
                                <input type="text" name="stats_label[]" class="form-control" value="{{ $s['label'] ?? '' }}" placeholder="Label">
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="stats_number[]" class="form-control" value="{{ $s['number'] ?? 0 }}" placeholder="Number">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="stats_suffix[]" class="form-control" value="{{ $s['suffix'] ?? '' }}" placeholder="Suffix">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-stat">Remove</button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-stat" class="btn btn-sm btn-secondary mt-2">Add Stat</button>
                </div>
            </div>
        </div>

        {{-- Team Members --}}
        <div class="card mb-3">
            <div class="card-header section-header" data-target="#teamSection">
                <strong>Team Members</strong>
                <span class="toggle-icon">+</span>
            </div>
            <div id="teamSection" class="section-body" style="display:none;">
                <div class="card-body">
                    <div id="team-wrapper">
                        @php $team = old('team', $about->team ?? []); @endphp
                        @if(count($team) > 0)
                            @foreach($team as $member)
                            <div class="team-row border p-2 mb-2 d-flex align-items-center gap-2">
                                <div style="width:120px;">
                                    <label>Photo</label><br>
                                    <input type="file" name="team_image[]" class="form-control-file">
                                    <input type="hidden" name="existing_team_image[]" value="{{ $member['image'] ?? '' }}">
                                    @if(!empty($member['image']))
                                    <img src="{{ asset($member['image']) }}" style="height:60px;margin-top:6px;">
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <label>Name</label>
                                    <input type="text" name="team_name[]" class="form-control" value="{{ $member['name'] ?? '' }}">
                                    <label class="mt-1">Designation</label>
                                    <input type="text" name="team_designation[]" class="form-control" value="{{ $member['designation'] ?? '' }}">
                                </div>
                                <div>
                                    <button type="button" class="btn btn-danger remove-team">Remove</button>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="team-row border p-2 mb-2 d-flex align-items-center gap-2">
                                <div style="width:120px;">
                                    <label>Photo</label><br>
                                    <input type="file" name="team_image[]" class="form-control-file">
                                    <input type="hidden" name="existing_team_image[]" value="">
                                </div>
                                <div class="flex-grow-1">
                                    <label>Name</label>
                                    <input type="text" name="team_name[]" class="form-control" value="">
                                    <label class="mt-1">Designation</label>
                                    <input type="text" name="team_designation[]" class="form-control" value="">
                                </div>
                                <div>
                                    <button type="button" class="btn btn-danger remove-team">Remove</button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" id="add-team" class="btn btn-sm btn-secondary mt-2">Add Member</button>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="card mt-3">
            <div class="card-body text-end">
                <button class="btn btn-success btn-lg" type="submit">Save About</button>
            </div>
        </div>
    </form>
</div>

{{-- Styles --}}
<style>
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
}
.section-header .toggle-icon {
    font-weight: bold;
    font-size: 18px;
}
</style>

{{-- Scripts --}}
<script>
    // Toggle sections
    const headers = document.querySelectorAll('.section-header');
    headers.forEach(header => {
        header.addEventListener('click', () => {
            headers.forEach(h => {
                if (h !== header) {
                    h.classList.remove('active');
                    const body = document.querySelector(h.dataset.target);
                    if (body) body.style.display = 'none';
                    const icon = h.querySelector('.toggle-icon');
                    if (icon) icon.textContent = '+';
                }
            });
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

    // Add/remove Why bullets
    document.getElementById('add-why').addEventListener('click', function() {
        const node = document.createElement('div');
        node.className = 'd-flex mb-2';
        node.innerHTML = `<input type="text" name="why_list[]" class="form-control me-2" placeholder="Bullet point"><button type="button" class="btn btn-danger remove-why">Remove</button>`;
        document.getElementById('why-list').appendChild(node);
    });

    // Add/remove Stats
    document.getElementById('add-stat').addEventListener('click', function() {
        const html = `<div class="row mb-2 align-items-center">
            <div class="col-md-5"><input type="text" name="stats_label[]" class="form-control" placeholder="Label"></div>
            <div class="col-md-3"><input type="number" name="stats_number[]" class="form-control" placeholder="Number"></div>
            <div class="col-md-2"><input type="text" name="stats_suffix[]" class="form-control" placeholder="Suffix"></div>
            <div class="col-md-2"><button type="button" class="btn btn-danger remove-stat">Remove</button></div>
        </div>`;
        document.getElementById('stats-wrapper').insertAdjacentHTML('beforeend', html);
    });

    // Add/remove Team members
    document.getElementById('add-team').addEventListener('click', function() {
        const html = `<div class="team-row border p-2 mb-2 d-flex align-items-center gap-2">
            <div style="width:120px;">
                <label>Photo</label><br>
                <input type="file" name="team_image[]" class="form-control-file">
                <input type="hidden" name="existing_team_image[]" value="">
            </div>
            <div class="flex-grow-1">
                <label>Name</label>
                <input type="text" name="team_name[]" class="form-control" value="">
                <label class="mt-1">Designation</label>
                <input type="text" name="team_designation[]" class="form-control" value="">
            </div>
            <div>
                <button type="button" class="btn btn-danger remove-team">Remove</button>
            </div>
        </div>`;
        document.getElementById('team-wrapper').insertAdjacentHTML('beforeend', html);
    });

    // Remove buttons
    document.addEventListener('click', function(e) {
        if(e.target.classList.contains('remove-why')) e.target.closest('.d-flex').remove();
        if(e.target.classList.contains('remove-stat')) e.target.closest('.row').remove();
        if(e.target.classList.contains('remove-team')) e.target.closest('.team-row').remove();
    });

    // Image preview for all file inputs
    document.addEventListener('change', function(e) {
        if(e.target && e.target.type === 'file') {
            const fileInput = e.target;
            const files = fileInput.files;
            if(files && files[0]) {
                let img = fileInput.nextElementSibling;
                if(!img || img.tagName !== 'IMG') {
                    img = document.createElement('img');
                    img.style.maxHeight = '120px';
                    img.classList.add('mt-2');
                    fileInput.parentNode.appendChild(img);
                }
                const reader = new FileReader();
                reader.onload = function(ev) {
                    img.src = ev.target.result;
                }
                reader.readAsDataURL(files[0]);
            }
        }
    });
</script>
@endsection
