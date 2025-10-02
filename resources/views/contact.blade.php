@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

    <section class="contact-page-wrapper top-section-padding">
        <div class="container contact-page-form">
            <div class="row">
                <img src="{{ asset('images/contact-top.png') }}" alt="Contact Icon" class="img-fluid contact-top-img">
                <h2 class="section-title">Contact Us</h2>
                <p class="section-sub-title">Get in touch with our team. We're here to help with all your fashion and textile
                    needs.</p>
            </div>
            <div class="row">
                {{-- Left: Form --}}
                <div class="col-md-6">
                    <div class="card">
                        <h4 class="card-title">Send us a message</h4>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">Name *</label>
                                    <input type="text" name="name" class="form-control" placeholder="Your full name"
                                        required>
                                </div>
                                <div class="col">
                                    <label class="form-label">Company</label>
                                    <input type="text" name="company" class="form-control" placeholder="Company name">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" class="form-control" placeholder="your@email.com"
                                        required>
                                </div>
                                <div class="col">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control"
                                        placeholder="+1 (555) 000-0000">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Country</label>
                                <select name="country" class="form-select">
                                    <option value="">Select your country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->name }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Message *</label>
                                <textarea name="message" rows="6" class="form-control" placeholder="Tell us about your requirements..." required></textarea>
                            </div>

                            <button type="submit" class="btn">Send Message</button>
                        </form>
                    </div>
                </div>

                {{-- Right: Contact Info --}}
                <div class="col-md-6">
                    <div class="card mb">
                        <h4 class="card-title">Get in touch</h4>
                       <div class="contact-page-info">
                            <div class="contact-info-inner">
                                <div class="icon">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <div class="info">
                                    <h6>Office Address</h6>
                                    <p>123 Fashion District Mumbai, Maharashtra 400001 India</p>
                                </div>
                            </div>
                            <div class="contact-info-inner">
                                <div class="icon">
                                   <i class="fa-solid fa-envelope"></i>
                                </div>
                                <div class="info">
                                    <h6>Email</h6>
                                    <p>info@chandrafashion.com <br>sales@chandrafashion.com</p>
                                </div>
                            </div>
                            <div class="contact-info-inner">
                                <div class="icon">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <div class="info">
                                    <h6>Phone</h6>
                                    <p>+91 12345 67890 <br>+91 98765 43210</p>
                                </div>
                            </div>
                             <div class="contact-info-inner">
                                <div class="icon">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <div class="info">
                                    <h6>Business Hours</h6>
                                    <p>Mon - Fri: 9:00 AM - 6:00 PM<br>Sat: 9:00 AM - 2:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <h5 class="card-title">Follow Us</h5>
                        <div class="d-md-flex gap-2">
                            <a href="#" class="contact-follow bg-facebook"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" fill="currentColor" class="bi bi-facebook"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                                </svg></a>
                            <a href="#" class="contact-follow bg-instagram"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" fill="currentColor" class="bi bi-instagram"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                                </svg></a>
                            <a href="#" class="contact-follow bg-linkedin"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" fill="currentColor" class="bi bi-linkedin"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z" />
                                </svg></a>
                            <a href="#" class="contact-follow bg-twitter"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" fill="currentColor" class="bi bi-twitter"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334q.002-.211-.006-.422A6.7 6.7 0 0 0 16 3.542a6.7 6.7 0 0 1-1.889.518 3.3 3.3 0 0 0 1.447-1.817 6.5 6.5 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.32 9.32 0 0 1-6.767-3.429 3.29 3.29 0 0 0 1.018 4.382A3.3 3.3 0 0 1 .64 6.575v.045a3.29 3.29 0 0 0 2.632 3.218 3.2 3.2 0 0 1-.865.115 3 3 0 0 1-.614-.057 3.28 3.28 0 0 0 3.067 2.277A6.6 6.6 0 0 1 .78 13.58a6 6 0 0 1-.78-.045A9.34 9.34 0 0 0 5.026 15" />
                                </svg></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Map Section --}}

    <section class="map-wrapper section-padding">
        <div class="container">
            <div class="row">
                <h2 class="section-title">Find Us</h2>
                <p class="section-sub-title">Visit our showroom and manufacturing facility</p>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3770.975315569125!2d72.87765531535352!3d19.07598398708974!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c6307e90d7f7%3A0xaad0e2b546f9a25a!2sMumbai%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1694599999999!5m2!1sen!2sin"
                    width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>

        </div>
    </section>
@endsection
