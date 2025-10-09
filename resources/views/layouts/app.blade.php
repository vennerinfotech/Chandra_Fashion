<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/cf-logo-1.png') }}">
    <title>@yield('title', 'Chandra Fashion')</title>

    {{-- Bootstrap CSS --}}
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    {{-- Font Awesome CSS --}}
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">

    {{-- Owl Carousel CSS --}}
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet">


    {{-- Custom Admin CSS --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    {{-- Jquery JS --}}
    <script src="{{ asset('js/jquery-min.js') }}"></script>

    {{-- Owl Carousel JS --}}
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>


    {{-- Bootstrap JS --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    {{-- Font Awesome JS --}}
    <script src="{{ asset('js/all.min.js') }}"></script>




    <!-- Custom CSS -->
    <style>
        body {
              font-family: "Open Sans", sans-serif;
            background-color: #f8f9fa;
        }

        .header {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
        /* #chatbox {
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
        } */


/* Chat bubbles */
.chat-message {
    max-width: 80%;
    padding: 10px 14px;
    border-radius: 15px;
    font-size: 14px;
    line-height: 1.4;
}

.chat-message.user {
    background: #007bff;
    color: #fff;
    align-self: flex-end;
    border-bottom-right-radius: 0;
}

.chat-message.bot {
    background: #f1f1f1;
    color: #000;
    align-self: flex-start;
    border-bottom-left-radius: 0;
}

/* Typing animation */
.typing {
    display: flex;
    gap: 4px;
}

.typing span {
    width: 8px;
    height: 8px;
    background: #ccc;
    border-radius: 50%;
    animation: blink 1.4s infinite both;
}

.typing span:nth-child(2) { animation-delay: 0.2s; }
.typing span:nth-child(3) { animation-delay: 0.4s; }

@keyframes blink {
    0%, 80%, 100% { opacity: 0; }
    40% { opacity: 1; }
}

/* Scroll container */
#chat-messages {
    display: flex;
    flex-direction: column;
    gap: 5px;
    overflow-y: auto;
}

        .zoomable {
            transition: transform 0.3s ease;
        }

        .zoomable:hover {
            transform: scale(1.5);
            /* Zoom in */
            z-index: 10;
            /* Bring above other elements */
            position: relative;
        }

        .btn-selected {
            color: #fff !important;
            background-color: #212529 !important;
            border-color: #212529 !important;
        }
    </style>

    @stack('styles')
</head>

<body>

    @include('partials.header')

    <main class="">
        @yield('content')
    </main>

    @include('partials.footer')

   <script>
document.addEventListener("DOMContentLoaded", function () {
    const header = document.querySelector(".header-wrapper");

    window.addEventListener("scroll", function () {
        if (window.scrollY > 50) {
            header.classList.add("scrolled");
        } else {
            header.classList.remove("scrolled");
        }
    });
});
</script>

<script>
$(document).ready(function() {
    function equalizeHeights() {
        var maxHeight = 0;
        var $boxes = $('.new-arrival-box, .product-filter-right .card, .collection-item');
        $boxes.css('height', 'auto'); // reset first

        $boxes.each(function() {
            var thisHeight = $(this).outerHeight();
            if (thisHeight > maxHeight) maxHeight = thisHeight;
        });

        $boxes.css('height', maxHeight + 'px');
    }

    // Run after images load
    $(window).on('load resize', equalizeHeights);
});
</script>



    <script>

    document.addEventListener("DOMContentLoaded", function() {
        const chatBtn = document.querySelector(".chatbot-btn");
        const chatWindow = document.getElementById("chat-window");
        const chatInput = document.getElementById("chat-input");
        const chatMessages = document.getElementById("chat-messages");
        const sendBtn = document.getElementById("send-btn");
        const closeBox = document.getElementById("close-box");

        closeBox.addEventListener("click", function() {
    chatWindow.style.display = "none";

        });

        // Toggle chat window
        chatBtn.addEventListener("click", function() {
            chatWindow.style.display = (chatWindow.style.display === "none" || chatWindow.style.display === "") ? "flex" : "none";
        });

        // Append message
        function appendMessage(sender, text){
            const msg = document.createElement("div");
            msg.classList.add("chat-message", sender);
            msg.textContent = text;
            chatMessages.appendChild(msg);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Typing indicator
        function appendTyping(){
            const typing = document.createElement("div");
            typing.classList.add("chat-message", "bot");
            typing.innerHTML = '<div class="typing"><span></span><span></span><span></span></div>';
            chatMessages.appendChild(typing);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            return typing;
        }

        // Send message
        function sendMessage(){
            const message = chatInput.value.trim();
            if(!message) return;

            // User message
            appendMessage("user", message);
            chatInput.value = "";

            // Typing indicator
            const typingIndicator = appendTyping();

            // Fetch backend response (Laravel route)
            fetch("{{ route('send.chat') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message })
            })
            .then(res => res.json())
            .then(data => {
                typingIndicator.remove();
                appendMessage("bot", data.reply);
            })
            .catch(err => {
                typingIndicator.remove();
                appendMessage("bot", "Error: " + err.message);
            });
        }

        // Event listeners
        sendBtn.addEventListener("click", sendMessage);
        chatInput.addEventListener("keypress", function(e){
            if(e.key === "Enter") sendMessage();
        });
    });
    </script>
    @stack('scripts')
</body>

</html>
