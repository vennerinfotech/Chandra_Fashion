<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Chandra Fashion')</title>

   {{-- Bootstrap CSS --}}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

     {{-- Font Awesome CSS --}}
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">


    {{-- Custom Admin CSS --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">


     {{-- Bootstrap JS --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    {{-- Font Awesome JS --}}
    <script src="{{ asset('js/all.min.js') }}"></script>


  <!-- Custom CSS -->
  <style>
    body {
      font-family: "Playfair Display", serif;
      background-color: #f8f9fa;
    }
    .header {
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      padding: 1rem 0;
    }
    .hero {
      background-color: #ececec;
      padding: 4rem 0;
      text-align: center;
    }
    .product-card img {
      object-fit: cover;
      height: 200px;
    }
     .btn-black {
      background-color: #000;
      color: #fff;
      border-radius: 0;
      border: none;
    }
    .btn-black:hover {
      background-color: #333;
      color: #fff;
    }

    /* Floating Chatbox - Right Corner */
    #chatbox {
        position: fixed;
        bottom: 80px;
        right: 19px;
        width: 330px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        font-size: 15px;
        z-index: 10000;
        display: flex;
        flex-direction: column;
        display: none;
    }
    #chatbox .chat-header {
        background: #000;
        color: #fff;
        padding: 10px;
        border-radius: 12px 12px 0 0;
        font-weight: bold;
    }
    #chatbox .chat-body {
        max-height: 200px;
        overflow-y: auto;
        padding: 10px;
    }
    #chatbox .chat-message {
        margin-bottom: 8px;
        padding: 8px 10px;
        border-radius: 10px;
    }
    #chatbox .chat-message.bot {
        background: #f1f1f1;
        text-align: left;
    }
    #chatbox .chat-message.user {
        background: #007bff;
        color: #fff;
        text-align: right;
    }
    #chatbox .chat-footer {
        padding: 10px;
        border-top: 1px solid #ddd;
    }

  </style>

  @stack('styles')
</head>
<body>

  @include('partials.header')

  <main class="">
    @yield('content')
    <!-- Floating AI Chat Box -->
    <div id="chatbox">
        <div class="chat-header">
            <i class="fa-solid fa-robot me-2"></i> AI Assistant
            <span id="chat-toggle" class="float-end" style="cursor:pointer;">−</span>
        </div>
        <div class="chat-body" id="chat-body">
            <div class="chat-message bot">👋 Hi! How can I help you today?</div>
        </div>
        <div class="chat-footer">
            <input type="text" id="chat-input" class="form-control" placeholder="Type a message...">
            <button id="chat-send" class="btn btn-dark btn-sm mt-2 w-100">Send</button>
        </div>
    </div>

  </main>

  @include('partials.footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
document.getElementById("chat-send").addEventListener("click", function() {
    let input = document.getElementById("chat-input");
    let message = input.value.trim();
    if(message !== "") {
        let body = document.getElementById("chat-body");

        // Show user message
        let userMsg = document.createElement("div");
        userMsg.className = "chat-message user";
        userMsg.innerText = message;
        body.appendChild(userMsg);

        // Auto-reply (dummy AI)
        let botMsg = document.createElement("div");
        botMsg.className = "chat-message bot";
        botMsg.innerText = "🤖 This is a demo AI reply!";
        setTimeout(() => {
            body.appendChild(botMsg);
            body.scrollTop = body.scrollHeight;
        }, 600);

        input.value = "";
        body.scrollTop = body.scrollHeight;
    }
});

// Toggle minimize/maximize
document.getElementById("chat-toggle").addEventListener("click", function() {
    let body = document.getElementById("chat-body");
    let footer = document.querySelector("#chatbox .chat-footer");
    if(body.style.display === "none") {
        body.style.display = "block";
        footer.style.display = "block";
        this.innerText = "−";
    } else {
        body.style.display = "none";
        footer.style.display = "none";
        this.innerText = "+";
    }
});
</script>

  @stack('scripts')
</body>
</html>
