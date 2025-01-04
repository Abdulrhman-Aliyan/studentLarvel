<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> <!-- Add this line -->
    <style>
        .sticky-navbar {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
        }
        .navbar-nav {
            margin-left: auto;
        }
    </style>
    @yield('head') <!-- Section for additional head content -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Students</a> <!-- Update this line -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    @if(Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">{{ Auth::user()->name }}</a> <!-- Update this line -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        </li>
                    @endif
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        @yield('content') <!-- Section for the main content -->
    </div>
    <a href="{{ url('/chat') }}" class="chat-button" title="Chat with us">
        <i class="fas fa-comments"></i>
    </a>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    @yield('scripts') <!-- Section for additional scripts -->
    <style>
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
    </style>
</body>
</html>