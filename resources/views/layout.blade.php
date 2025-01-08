<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sticky-navbar {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            z-index: 1020;
            width: 100%;
            background-color: transparent; /* Make the navbar background transparent */
            transition: background-color 0.3s ease-in-out; /* Smooth transition */
            height: 100px;
        }
        .navbar-scrolled {
            background-color: white !important; /* Solid white background */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add shadow */
        }
        .navbar-nav {
            margin-left: auto;
            margin-right: auto; /* Center the navbar items */
        }
        .register-button {
            background-color: white;
            color: #FFA500; /* Orange text */
            border: 1px solid #FFA500;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .register-button:hover {
            background-color: #FFA500;
            color: white;
        }
        .nav-link.active {
            border-bottom: 2px solid #FFA500; /* Orange underline for active page */
        }
        .chat-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1030;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-decoration: none; /* Add this line */
        }
        .chat-button:hover {
            background-color: #0056b3;
        }
        .scroll-to-top {
            position: fixed;
            bottom: 80px;
            right: 20px;
            z-index: 1030;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        .scroll-to-top.show {
            opacity: 1;
        }
        .scroll-to-top:hover {
            background-color: #0056b3;
        }
    </style>
    @yield('head') <!-- Section for additional head content -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <!-- Education Icon -->
                <i class="fas fa-graduation-cap fa-3x"></i>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('courses') ? 'active' : '' }}" href="{{ url('/courses') }}">Courses</a>
                    </li>
                </ul>
                @if(Auth::check())
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                @else
                    <a class="nav-link" href="{{ url('/login') }}">Login</a>
                    <a class="nav-link register-button btn .rounded-lg border-0 px-3 py-2 ms-4 fw-normal" href="{{ url('/register') }}">Register</a>
                @endif
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </nav>
    
    @yield('content') <!-- Section for the main content -->

    <!-- Chat Button -->
    <a href="{{ url('/chat') }}" class="chat-button" title="Chat with us">
        <i class="fas fa-comments"></i>
    </a>

    <!-- Return to Top Button -->
    <a href="#" class="scroll-to-top" title="Return to top">
        <i class="bi bi-arrow-up"></i>
    </a>

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    @yield('scripts') <!-- Section for additional scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show or hide the scroll-to-top button
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('.scroll-to-top').addClass('show');
                $('.sticky-navbar').addClass('navbar-scrolled');
            } else {
                $('.scroll-to-top').removeClass('show');
                $('.sticky-navbar').removeClass('navbar-scrolled');
            }
        });

        // Smooth scroll to top
        $('.scroll-to-top').click(function(e) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: 0 }, '300');
        });
    </script>
</body>
</html>