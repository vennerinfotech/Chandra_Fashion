<footer>
  <div class="container">
    <div class="row">
      <!-- Column 1: Brand Info -->
      <div class="col-md-6 col-lg-3 brand-info">
        <h3>Chandra Fashion</h3>
        <p>Premium B2B clothing manufacturer serving global fashion brands since 1985.</p>
        <div class="social-links mt-3">
          <a href="#" class="bi bi-facebook"><i class="fa-brands fa-facebook"></i></a>
          <a href="#" class="bi bi-instagram"><i class="fa-brands fa-instagram"></i></a>
          <a href="#" class="bi bi-linkedin"><i class="fa-brands fa-square-linkedin"></i></a>
          <a href="#" class="bi bi-linkedin"><i class="fa-brands fa-youtube"></i></a>
        </div>
      </div>

      <!-- Column 2: Quick Links -->
      <div class="col-md-6 col-lg-3 quick-links">
        <h4>Quick Links</h4>
        <ul>
            <li><a href="{{ route('home') }}">About Us</a></li>
            <li><a href="{{ route('contact') }}">Contact Us</a></li>
            <li><a href="{{ route('products.index') }}">Products</a></li>
            <li><a href="{{ route('products.index') }}">Check Price</a></li>
        </ul>
      </div>

      <!-- Column 3: Services -->
      <div class="col-md-6 col-lg-3 services">
        <h4>Services</h4>
        <ul>
          <li><a href="#">Custom Manufacturing</a></li>
          <li><a href="#">Design Consultation</a></li>
          <li><a href="#">Quality Control</a></li>
          <li><a href="#">Global Shipping</a></li>
        </ul>
      </div>

      <!-- Column 4: Contact Info -->
      <div class="col-md-6 col-lg-3 contact-info">
        <h4>Contact Info</h4>
        <ul>
            <li><a href="#"><i class="fa-solid fa-location-dot"></i>Mumbai, India</a></li>
            <li><a href="#"><i class="fa-solid fa-phone"></i>+91 98765 43210</a></li>
            <li><a href="#"><i class="fa-solid fa-envelope"></i>info@chandrafashion.com</a></li>
        </ul>
      </div>
    </div>

    <hr class="border-light" />

    <div class="text-center bottom-text">
      &copy; 2025 Chandra Fashion. All Rights Reserved.
    </div>
  </div>

  <!-- Chatbot icon fixed bottom right -->
  <div>
    <button class="chatbot-btn">
      {{-- <i class="fas fa-robot" style="color: #273847; font-size: 20px;"></i> --}}
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-robot" viewBox="0 0 16 16">
        <path d="M6 12.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5M3 8.062C3 6.76 4.235 5.765 5.53 5.886a26.6 26.6 0 0 0 4.94 0C11.765 5.765 13 6.76 13 8.062v1.157a.93.93 0 0 1-.765.935c-.845.147-2.34.346-4.235.346s-3.39-.2-4.235-.346A.93.93 0 0 1 3 9.219zm4.542-.827a.25.25 0 0 0-.217.068l-.92.9a25 25 0 0 1-1.871-.183.25.25 0 0 0-.068.495c.55.076 1.232.149 2.02.193a.25.25 0 0 0 .189-.071l.754-.736.847 1.71a.25.25 0 0 0 .404.062l.932-.97a25 25 0 0 0 1.922-.188.25.25 0 0 0-.068-.495c-.538.074-1.207.145-1.98.189a.25.25 0 0 0-.166.076l-.754.785-.842-1.7a.25.25 0 0 0-.182-.135"/>
        <path d="M8.5 1.866a1 1 0 1 0-1 0V3h-2A4.5 4.5 0 0 0 1 7.5V8a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1v1a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-1a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1v-.5A4.5 4.5 0 0 0 10.5 3h-2zM14 7.5V13a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7.5A3.5 3.5 0 0 1 5.5 4h5A3.5 3.5 0 0 1 14 7.5"/>
      </svg>
    </button>
  </div>
  <!-- Chat Window (hidden by default) -->
<div id="chat-window" style="display:none; position:fixed; bottom:80px; right:20px; width:300px; height:400px; background:white; border:1px solid #ccc; border-radius:10px; box-shadow:0px 4px 10px rgba(0,0,0,0.2); overflow:hidden; flex-direction:column;">
    <div style="background:#273847; color:white; padding:10px; font-weight:bold;">
        AI Assistant
    </div>
    <div id="chat-messages" style="flex:1; padding:10px; overflow-y:auto; font-size:14px;"></div>
    <div style="display:flex; border-top:1px solid #ccc;">
        <input type="text" id="chat-input" placeholder="Type a message..." style="flex:1; border:none; padding:10px; font-size:14px;">
        <button id="send-btn" style="background:#273847; color:white; border:none; padding:10px;">Send</button>
    </div>
</div>
</footer>
